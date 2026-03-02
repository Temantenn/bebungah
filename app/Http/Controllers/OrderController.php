<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use App\Models\Theme;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    public function create()
    {

        $themes = Theme::where('is_active', true)->get();

        return view('order.form', compact('themes'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'slug'            => 'required|alpha_dash|unique:invitations,slug',
            'theme_id'        => 'required|exists:themes,id',
            'client_whatsapp' => 'required|numeric',
            'groom_name'      => 'required|string',
            'bride_name'      => 'required|string',
            'event_date'      => 'required|date',
        ], [
            'slug.required'            => 'Link undangan wajib diisi.',
            'slug.unique'              => 'Link undangan ini sudah dipakai, silakan pilih link lain.',
            'slug.alpha_dash'          => 'Link hanya boleh berisi huruf, angka, dan tanda strip (-).',
            'client_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'theme_id.required'        => 'Silakan pilih salah satu tema.',
        ]);

        $whatsapp = $request->client_whatsapp;
        if (str_starts_with($whatsapp, '0')) {
            $whatsapp = '62' . substr($whatsapp, 1);
        } elseif (str_starts_with($whatsapp, '8')) {
            $whatsapp = '62' . $whatsapp;
        }

        $generatedEmail = $request->slug . '@temanten.com';

        if (User::where('email', $generatedEmail)->exists()) {
            return back()->withErrors(['slug' => 'ID Login untuk link ini sudah terdaftar. Mohon ganti link undangan.'])->withInput();
        }

        DB::beginTransaction();

        try {

            $user = User::create([
                'name'     => $request->groom_name . ' & ' . $request->bride_name,
                'email'    => $generatedEmail,
                'password' => Hash::make(Str::random(10)),
                'role'     => 'client',
            ]);

            $content = [
                'mempelai' => [
                    'pria' => [
                        'nama'      => $request->groom_name,
                        'panggilan' => explode(' ', $request->groom_name)[0],
                        'ayah'      => 'Bpk. (Nama Ayah Pria)',
                        'ibu'       => 'Ibu (Nama Ibu Pria)',
                        'foto'      => null
                    ],
                    'wanita' => [
                        'nama'      => $request->bride_name,
                        'panggilan' => explode(' ', $request->bride_name)[0],
                        'ayah'      => 'Bpk. (Nama Ayah Wanita)',
                        'ibu'       => 'Ibu (Nama Ibu Wanita)',
                        'foto'      => null
                    ]
                ],
                'acara' => [
                    'akad' => [
                        'judul'   => 'Akad Nikah',
                        'waktu'   => $request->event_date . ' 08:00:00',
                        'tempat'  => 'Lokasi Akad',
                        'alamat'  => 'Alamat lengkap lokasi akad...',
                        'maps'    => '#'
                    ],
                    'resepsi' => [
                        'judul'   => 'Resepsi Pernikahan',
                        'waktu'   => $request->event_date . ' 11:00:00',
                        'tempat'  => 'Lokasi Resepsi',
                        'alamat'  => 'Alamat lengkap lokasi resepsi...',
                        'maps'    => '#'
                    ]
                ],
                'media' => [
                    'cover'      => null,
                    'music'      => null,
                    'video_link' => null,
                    'gallery'    => []
                ],
                'amplop' => [
                    'bank_name'      => 'BCA',
                    'account_number' => '1234567890',
                    'account_holder' => $request->groom_name,
                    'alamat_kado'    => 'Alamat rumah mempelai...'
                ],
                'love_stories' => [],
                'quote'        => 'Kami mengundang Anda untuk merayakan pernikahan kami.'
            ];

            Invitation::create([
                'uuid'            => (string) Str::uuid(),
                'user_id'         => $user->id,
                'theme_id'        => $request->theme_id,
                'slug'            => $request->slug,
                'title'           => 'The Wedding of ' . $request->groom_name . ' & ' . $request->bride_name,
                'event_date'      => $request->event_date,
                'status'          => 'pending',
                'client_whatsapp' => $whatsapp,
                'content'         => $content
            ]);

            DB::commit();

            // Log order baru untuk tracking
            Log::channel('activity')->info('New invitation order created', [
                'slug'     => $request->slug,
                'email'    => $generatedEmail,
                'whatsapp' => $whatsapp,
                'theme_id' => $request->theme_id,
            ]);

            return redirect()->route('order.payment')->with([
                'success'     => 'Pesanan berhasil dibuat!',
                'order_email' => $generatedEmail,
                'order_wa'    => $whatsapp,
                'order_slug'  => $request->slug
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            // Log error ke file log — jangan tampilkan detail ke pengguna
            Log::channel('daily')->error('Failed to create invitation order', [
                'slug'  => $request->slug ?? '-',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors(['msg' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.'])->withInput();
        }
    }

    public function payment()
    {
        // Ambil slug pesanan dari session
        $slug = session('order_slug');

        if (!$slug) {
            return redirect()->route('order.create');
        }

        // Ambil data undangan beserta temanya
        $invitation = Invitation::where('slug', $slug)
            ->with('theme')
            ->firstOrFail();

        return view('order.payment', compact('invitation'));
    }
}