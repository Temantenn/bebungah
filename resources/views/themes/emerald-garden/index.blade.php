<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Emerald' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Gardenia' }}</title>

    @vite(['resources/css/app.css', 'resources/css/emerald.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="antialiased">
    @php
        function getImgUrl($path) {
            if (!$path) return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=400&fit=crop';
            if (str_contains($path, 'placeholder')) return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=400&fit=crop';
            return \Illuminate\Support\Str::startsWith($path, 'http') ? $path : asset($path);
        }
    @endphp

    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
        <div class="absolute top-[-20%] left-[-20%] w-[600px] h-[600px] bg-[#143d30] rounded-full blur-[100px] opacity-60"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] bg-[#D4AF37] rounded-full blur-[150px] opacity-10"></div>
    </div>

    <div class="fixed top-6 right-6 z-[100]">
        <button onclick="toggleMusic()" id="musicBtn" class="w-10 h-10 rounded-full bg-[#0B201A]/80 border border-[#D4AF37]/50 text-[#D4AF37] flex items-center justify-center shadow-lg backdrop-blur-md transition hover:scale-110">
            <i class="ph-fill ph-music-note text-lg"></i>
        </button>
    </div>

    <audio id="bg-music" loop>
        <source src="{{ asset($invitation->content['media']['music'] ?? 'assets/music/emerald-garden.mp3') }}" type="audio/mp3">
    </audio>

    <div id="gate" class="fixed inset-0 z-[999] flex items-center justify-center bg-[#0B201A]">
        <div class="absolute inset-0 z-0 opacity-40">
            <img src="{{ getImgUrl($invitation->content['media']['cover'] ?? '') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0B201A] via-[#0B201A]/50 to-transparent"></div>
        </div>

        <div class="relative z-10 text-center px-8 w-full max-w-md">
            <div class="border border-[#D4AF37]/40 p-1 rounded-t-[150px] rounded-b-[20px] backdrop-blur-sm bg-[#0B201A]/30">
                <div class="border border-[#D4AF37] px-6 py-12 rounded-t-[146px] rounded-b-[16px]">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[#D4AF37] mb-6">The Wedding Of</p>
                    <h1 class="font-royal text-5xl md:text-6xl text-white leading-none mb-4 drop-shadow-lg">
                        {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Emerald' }} <br>
                        <span class="text-3xl font-light italic text-[#D4AF37]">&</span> <br>
                        {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Gardenia' }}
                    </h1>
                    <div class="w-10 h-px bg-[#D4AF37] mx-auto my-8"></div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-300 mb-2">Dear Guest</p>
                    <h3 class="font-royal text-xl text-white capitalize mb-10">
                        @if(isset($guest))
                            {{ $guest->name }}
                        @else
                            {{ request('to') ? str_replace('-', ' ', preg_replace('/-[a-zA-Z0-9]{4}$/', '', request('to'))) : 'Tamu Undangan' }}
                        @endif
                    </h3>
                    <button onclick="openInvitation()" class="group relative px-8 py-3 bg-[#D4AF37] text-[#0B201A] font-bold text-xs uppercase tracking-widest rounded-full overflow-hidden shadow-[0_0_20px_rgba(212,175,55,0.4)] hover:scale-105 transition">
                        Buka Undangan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="main-content" class="fixed inset-0 overflow-y-auto no-scrollbar scroll-smooth pb-28">

        <section id="home" class="min-h-screen flex flex-col justify-end items-center text-center px-6 pb-24 relative">
            <div class="absolute top-0 left-0 w-full h-[70vh] z-[-1]">
                <img src="{{ getImgUrl($invitation->content['media']['hero'] ?? $invitation->content['media']['cover'] ?? '') }}" class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#0B201A]"></div>
            </div>
            <div class="reveal-on-scroll">
                <p class="text-[#D4AF37] text-xs tracking-[0.3em] uppercase mb-4">Save The Date</p>
                <h2 class="font-royal text-4xl md:text-6xl text-white mb-6">
                    {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Emerald' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Gardenia' }}
                </h2>
                <p class="text-gray-300 italic text-sm max-w-xs mx-auto mb-8">"{{ $invitation->content['quote'] ?? 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri...' }}"</p>
                <div id="countdown" class="flex justify-center gap-6 font-royal text-[#D4AF37] text-xl border-t border-[#D4AF37]/30 pt-6 max-w-xs mx-auto"></div>
            </div>
        </section>

        <section id="intro" class="pt-10 pb-10 px-6 relative">
            <div class="max-w-lg mx-auto text-center reveal-on-scroll">

                <div class="mb-5 flex justify-center opacity-70">
                    <i class="ph-fill ph-plant text-3xl text-[#D4AF37]"></i>
                </div>

                <p class="text-sm font-bold text-[#D4AF37] uppercase tracking-widest mb-4">Assalamualaikum Wr. Wb.</p>
                <p class="text-sm text-gray-300 mb-8 leading-relaxed">
                    Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan pernikahan putra-putri kami:
                </p>

                <div class="border-t border-b border-[#D4AF37]/30 py-8 relative">
                    <i class="ph-fill ph-quotes text-4xl text-[#D4AF37]/20 absolute top-4 left-1/2 transform -translate-x-1/2"></i>
                    <p class="font-royal text-xl text-white italic mb-4 relative z-10">
                        "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri..."
                    </p>
                    <p class="text-xs font-bold text-[#D4AF37] uppercase tracking-widest">
                        (QS. Ar-Rum: 21)
                    </p>
                </div>

            </div>
        </section>

        <section id="couple" class="pt-8 pb-20 px-6">
            <div class="max-w-lg mx-auto">
                <h2 class="font-royal text-4xl text-center text-[#D4AF37] mb-12 reveal-on-scroll">The Couple</h2>

                <div class="flex items-center gap-6 mb-12 reveal-on-scroll">
                    <div class="relative w-32 h-40 shrink-0">
                        <div class="absolute inset-0 border border-[#D4AF37] rounded-tl-[40px] rounded-br-[40px] translate-x-2 translate-y-2"></div>
                        <img src="{{ getImgUrl($invitation->content['mempelai']['pria']['foto'] ?? '') }}" class="w-full h-full object-cover rounded-tl-[40px] rounded-br-[40px] relative z-10 grayscale hover:grayscale-0 transition duration-700">
                    </div>
                    <div>
                        <h3 class="font-royal text-3xl text-white mb-1">{{ $invitation->content['mempelai']['pria']['nama'] ?? 'Emerald Garden Putra' }}</h3>
                        <p class="text-[10px] uppercase tracking-widest text-[#D4AF37] mb-2">The Groom</p>
                        <p class="text-xs text-gray-400">Putra Bpk {{ $invitation->content['mempelai']['pria']['ayah'] ?? 'Bpk. Emerald' }} <br>& Ibu {{ $invitation->content['mempelai']['pria']['ibu'] ?? 'Ibu Emerald' }}</p>
                        @if(!empty($invitation->content['mempelai']['pria']['instagram']))
                        <a href="https://instagram.com/{{ $invitation->content['mempelai']['pria']['instagram'] }}" class="inline-block mt-3 text-[#D4AF37] text-lg"><i class="ph-fill ph-instagram-logo"></i></a>
                        @endif
                    </div>
                </div>

                <div class="flex flex-row-reverse items-center gap-6 text-right reveal-on-scroll">
                    <div class="relative w-32 h-40 shrink-0">
                        <div class="absolute inset-0 border border-[#D4AF37] rounded-tr-[40px] rounded-bl-[40px] -translate-x-2 translate-y-2"></div>
                        <img src="{{ getImgUrl($invitation->content['mempelai']['wanita']['foto'] ?? '') }}" class="w-full h-full object-cover rounded-tr-[40px] rounded-bl-[40px] relative z-10 grayscale hover:grayscale-0 transition duration-700">
                    </div>
                    <div>
                        <h3 class="font-royal text-3xl text-white mb-1">{{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Gardenia Putri Jelita' }}</h3>
                        <p class="text-[10px] uppercase tracking-widest text-[#D4AF37] mb-2">The Bride</p>
                        <p class="text-xs text-gray-400">Putri Bpk {{ $invitation->content['mempelai']['wanita']['ayah'] ?? 'Bpk. Garden' }} <br>& Ibu {{ $invitation->content['mempelai']['wanita']['ibu'] ?? 'Ibu Garden' }}</p>
                        @if(!empty($invitation->content['mempelai']['wanita']['instagram']))
                        <a href="https://instagram.com/{{ $invitation->content['mempelai']['wanita']['instagram'] }}" class="inline-block mt-3 text-[#D4AF37] text-lg"><i class="ph-fill ph-instagram-logo"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section id="story" class="py-20 px-6 bg-[#091a15]">
            <div class="max-w-lg mx-auto">
                <h2 class="font-royal text-4xl text-center text-[#D4AF37] mb-12 reveal-on-scroll">Our Journey</h2>
                @php
                    $stories = $invitation->content['love_stories'] ?? [
                        [
                            'year' => '2019',
                            'title' => 'First Sight',
                            'story' => 'Pertemuan pertama kami di taman kota, sebuah kebetulan yang indah.'
                        ],
                        [
                            'year' => '2022',
                            'title' => 'Proposal',
                            'story' => 'Di bawah langit penuh bintang, kami memutuskan untuk melangkah ke jenjang yang lebih serius.'
                        ]
                    ];
                @endphp
                @if(isset($stories) && is_array($stories) && count($stories) > 0)
                <div class="relative pl-8 border-l border-[#D4AF37]/20 space-y-10">
                    @foreach($stories as $story)
                    <div class="relative reveal-on-scroll">
                        <div class="absolute -left-[37px] top-1 w-4 h-4 bg-[#0B201A] border border-[#D4AF37] rounded-full flex items-center justify-center">
                            <div class="w-1.5 h-1.5 bg-[#D4AF37] rounded-full"></div>
                        </div>
                        <span class="text-[#D4AF37] text-xs font-bold tracking-widest mb-1 block">{{ $story['year'] ?? '' }}</span>
                        <h4 class="font-royal text-2xl text-white mb-2">{{ $story['title'] ?? '' }}</h4>
                        <p class="text-sm text-gray-400 leading-relaxed">{{ $story['story'] ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>

        <section id="event" class="py-20 px-6">
            <div class="max-w-lg mx-auto text-center">
                <h2 class="font-royal text-4xl text-[#D4AF37] mb-12 reveal-on-scroll">Wedding Event</h2>
                <div class="grid gap-6">
                    <div class="glass-panel p-8 rounded-2xl reveal-on-scroll">
                        <i class="ph-duotone ph-rings-wedding text-4xl text-[#D4AF37] mb-4"></i>
                        <h3 class="font-royal text-2xl text-white mb-1">{{ $invitation->content['acara']['akad']['judul'] ?? 'Akad Nikah' }}</h3>
                        <p class="text-[#D4AF37] text-xs font-bold uppercase tracking-wider mb-6">{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now()->addDays(20))->translatedFormat('l, d F Y') }}</p>
                        <div class="space-y-2 text-sm text-gray-300 mb-6">
                            <p><i class="ph-fill ph-clock mr-2"></i> {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? '09:00')->format('H:i') }} WIB</p>
                            <p class="px-8 leading-relaxed">{{ $invitation->content['acara']['akad']['tempat'] ?? 'Emerald Garden Hall' }} <br> {{ $invitation->content['acara']['akad']['alamat'] ?? '' }}</p>
                            @php
                                $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                                $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                                $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
                            @endphp
                            @if($akadL1)<p class="px-8 text-xs text-gray-400">{{ $akadL1 }}</p>@endif
                            @if($akadL2)<p class="px-8 text-xs text-gray-400">{{ $akadL2 }}</p>@endif
                        </div>
                        <a href="{{ $invitation->content['acara']['akad']['maps'] ?? '#' }}" class="inline-block border-b border-[#D4AF37] text-[#D4AF37] text-xs uppercase tracking-widest pb-1">Open Map</a>
                    </div>
                    <div class="glass-panel p-8 rounded-2xl reveal-on-scroll">
                        <i class="ph-duotone ph-wine text-4xl text-[#D4AF37] mb-4"></i>
                        <h3 class="font-royal text-2xl text-white mb-1">{{ $invitation->content['acara']['resepsi']['judul'] ?? 'Resepsi Pernikahan' }}</h3>
                        <p class="text-[#D4AF37] text-xs font-bold uppercase tracking-wider mb-6">{{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now()->addDays(20))->translatedFormat('l, d F Y') }}</p>
                        <div class="space-y-2 text-sm text-gray-300 mb-6">
                            <p><i class="ph-fill ph-clock mr-2"></i> {{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? '11:00')->format('H:i') }} WIB</p>
                            <p class="px-8 leading-relaxed">{{ $invitation->content['acara']['resepsi']['tempat'] ?? 'Grand Ballroom Emerald' }} <br> {{ $invitation->content['acara']['resepsi']['alamat'] ?? '' }}</p>
                            @php
                                $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                                $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                                $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
                            @endphp
                            @if($resepsiL1)<p class="px-8 text-xs text-gray-400">{{ $resepsiL1 }}</p>@endif
                            @if($resepsiL2)<p class="px-8 text-xs text-gray-400">{{ $resepsiL2 }}</p>@endif
                        </div>
                        <a href="{{ $invitation->content['acara']['resepsi']['maps'] ?? '#' }}" class="inline-block border-b border-[#D4AF37] text-[#D4AF37] text-xs uppercase tracking-widest pb-1">Open Map</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="gallery" class="py-20 px-4">
            <h2 class="font-royal text-4xl text-center text-[#D4AF37] mb-8 reveal-on-scroll">Gallery</h2>
            <div class="columns-2 gap-3 space-y-3 max-w-2xl mx-auto">
                @php
                    $gallery = $invitation->content['media']['gallery'] ?? [
                        'https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=600&fit=crop',
                        'https://images.unsplash.com/photo-1511285560982-1356c11d4606?w=400&h=600&fit=crop',
                        'https://images.unsplash.com/photo-1519225421980-715cb0202128?w=400&h=600&fit=crop',
                        'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400&h=600&fit=crop',
                    ];
                @endphp
                @if(isset($gallery) && is_array($gallery))
                    @foreach($gallery as $photo)
                        <img src="{{ getImgUrl($photo) }}" class="w-full rounded-lg opacity-80 hover:opacity-100 transition duration-500 reveal-on-scroll">
                    @endforeach
                @endif
            </div>
        </section>

        <section id="gift" class="py-20 px-6 bg-[#091a15]">
            <div class="max-w-lg mx-auto text-center">
                <h2 class="font-royal text-4xl text-[#D4AF37] mb-10 reveal-on-scroll">Wedding Gift</h2>

                <p class="text-sm text-gray-300 mb-8 reveal-on-scroll px-4">
                    Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Namun jika memberi adalah ungkapan tanda kasih Anda, Anda dapat memberi kado secara cashless.
                </p>

                <div class="gift-card-emerald p-8 rounded-2xl text-center mb-10 reveal-on-scroll transform hover:scale-105 transition duration-500">
                    @php
                        $amplop = $invitation->content['amplop'] ?? [];
                    @endphp
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        <p class="text-[10px] font-bold text-white uppercase tracking-widest">Transfer Bank</p>
                    </div>
                    <p class="font-royal text-xl sm:text-2xl text-white mb-4">{{ $amplop['bank_name'] ?? 'BCA' }}</p>
                    <p class="font-royal text-2xl sm:text-3xl font-bold text-[#D4AF37] tracking-wider mb-2" id="rekNum">{{ $amplop['account_number'] ?? '8888-9999-0000' }}</p>
                    <p class="text-sm text-gray-300">a.n {{ $amplop['account_holder'] ?? 'Emerald Garden Putra' }}</p>
                    <button onclick="copyText('rekNum')" class="mt-6 w-full sm:w-auto px-8 py-3 bg-[#0B201A] hover:bg-white text-[#D4AF37] text-xs font-bold uppercase tracking-widest rounded-xl transition-all border border-[#D4AF37]/50 flex items-center justify-center gap-2 mx-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        Salin Nomor
                    </button>
                    @if(isset($amplop['qris_image']))
                    <div class="mt-6 pt-6 border-t border-[#D4AF37]/50">
                        <p class="text-[10px] font-bold text-[#D4AF37] uppercase tracking-widest mb-4">Atau Scan QRIS Berikut</p>
                        <img src="{{ asset($amplop['qris_image']) }}" alt="QRIS" class="w-40 h-40 object-contain mx-auto bg-white p-2 border-2 border-[#D4AF37] rounded-xl shadow-lg">
                    </div>
                    @endif
                </div>

                @if(!empty($invitation->content['amplop']['alamat_kado']) || !isset($invitation->content['amplop']))
                <div class="glass-panel p-6 rounded-2xl reveal-on-scroll">
                    <i class="ph-duotone ph-package text-3xl text-[#D4AF37] mb-2"></i>
                    <h3 class="font-bold text-white mb-2 uppercase text-sm tracking-wide">Kirim Kado Fisik</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">{{ $invitation->content['amplop']['alamat_kado'] ?? 'Jl. Permata Hijau No. 10, Jakarta Selatan' }}</p>
                </div>
                @endif
            </div>
        </section>

        <section id="wishes" class="py-20 px-6 pb-40">
            <div class="max-w-lg mx-auto">
                <h2 class="font-royal text-4xl text-center text-[#D4AF37] mb-8 reveal-on-scroll">Wishes</h2>

                <div class="glass-panel p-6 rounded-2xl reveal-on-scroll">
                    @if(session('success'))
                        <div class="bg-green-900/50 text-green-200 p-3 rounded mb-4 text-xs text-center border border-green-500/30">
                            <i class="ph-fill ph-check-circle inline mr-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('kirim.ucapan') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">

                        <input type="text" name="nama" placeholder="Nama Lengkap" class="input-emerald" required>

                        <select name="kehadiran" class="input-emerald cursor-pointer">
                            <option value="hadir" class="bg-[#0B201A]">Saya Akan Hadir</option>
                            <option value="tidak_hadir" class="bg-[#0B201A]">Maaf, Tidak Bisa Hadir</option>
                        </select>

                        <textarea name="ucapan" rows="2" placeholder="Tuliskan doa & ucapan..." class="input-emerald resize-none" required></textarea>

                        <button type="submit" class="w-full mt-4 bg-[#D4AF37] text-[#0B201A] py-3 rounded-lg font-bold text-xs uppercase hover:bg-white transition shadow-lg">
                            Kirim Ucapan
                        </button>
                    </form>
                </div>

                <div class="mt-10 space-y-6">
                    @foreach($invitation->comments->sortByDesc('created_at') as $comment)
                    <div class="border-b border-[#D4AF37]/10 pb-4 reveal-on-scroll flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#D4AF37] text-[#0B201A] flex items-center justify-center font-bold text-xs shrink-0">
                            {{ substr($comment->name ?? '', 0, 1) }}
                        </div>
                        <div class="w-full">
                            <div class="flex justify-between items-baseline mb-1">
                                <strong class="text-[#D4AF37] text-sm">{{ $comment->name }}</strong>
                                <span class="text-[10px] text-gray-600">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-gray-300 italic">"{{ $comment->comment }}"</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <div id="navbar" class="nav-leaf-container">
        <button onclick="scrollToSection('home')" class="nav-leaf active" data-section="home">
            <i class="ph-fill ph-house"></i>
        </button>
        <button onclick="scrollToSection('couple')" class="nav-leaf" data-section="couple">
            <i class="ph-fill ph-heart"></i>
        </button>
        <button onclick="scrollToSection('story')" class="nav-leaf" data-section="story">
            <i class="ph-fill ph-book-open-text"></i>
        </button>
        <button onclick="scrollToSection('event')" class="nav-leaf" data-section="event">
            <i class="ph-fill ph-calendar-star"></i>
        </button>
        <button onclick="scrollToSection('gallery')" class="nav-leaf" data-section="gallery">
            <i class="ph-fill ph-image"></i>
        </button>
        <button onclick="scrollToSection('gift')" class="nav-leaf" data-section="gift">
            <i class="ph-fill ph-gift"></i>
        </button>
        <button onclick="scrollToSection('wishes')" class="nav-leaf" data-section="wishes">
            <i class="ph-fill ph-chat-circle-text"></i>
        </button>
    </div>

    <script>
        function openInvitation() {
            document.getElementById('gate').classList.add('open');
            setTimeout(() => { document.getElementById('navbar').classList.add('visible'); }, 600);

            const audio = document.getElementById('bg-music');
            if(audio) audio.play();

            initScrollSpy();
            triggerRevealAnimations();
        }

        function toggleMusic() {
            const audio = document.getElementById('bg-music');
            const icon = document.querySelector('#musicBtn i');
            if (audio.paused) {
                audio.play();
                icon.classList.remove('ph-play');
                icon.classList.add('ph-music-note');
            } else {
                audio.pause();
                icon.classList.remove('ph-music-note');
                icon.classList.add('ph-play');
            }
        }

        function scrollToSection(id) {
            document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
        }

        function initScrollSpy() {
            const sections = document.querySelectorAll('section');
            const navButtons = document.querySelectorAll('.nav-leaf');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        navButtons.forEach(btn => btn.classList.remove('active'));
                        const activeId = entry.target.id;
                        const activeButton = document.querySelector(`.nav-leaf[data-section="${activeId}"]`);
                        if (activeButton) activeButton.classList.add('active');
                    }
                });
            }, { root: null, threshold: 0.3 });

            sections.forEach(section => observer.observe(section));
        }

        function triggerRevealAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show-up');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal-on-scroll').forEach(el => {
                el.classList.add('animate-up');
                observer.observe(el);
            });
        }

        function copyText(id) {
            navigator.clipboard.writeText(document.getElementById(id).innerText).then(() => alert('Nomor tersalin!'));
        }

        const targetDate = new Date("{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now()->addDays(20))->format('Y-m-d H:i:s') }}").getTime();
        setInterval(() => {
            const now = new Date().getTime();
            const diff = targetDate - now;
            if(diff > 0) {
                const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                document.getElementById('countdown').innerHTML = `<span>${d} Hari</span> <span class="mx-2">•</span> <span>${h} Jam</span> <span class="mx-2">•</span> <span>${m} Menit</span>`;
            }
        }, 1000);
    </script>
</body>
</html>