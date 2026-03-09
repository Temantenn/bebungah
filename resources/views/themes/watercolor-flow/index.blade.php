<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Arta' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Canva' }}</title>

    @vite(['resources/css/watercolor.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Nunito:wght@400;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased overflow-hidden">

    @php
        function getImgUrl($path) {

            if (!$path) return 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&fit=crop';
            if (str_contains($path, 'placeholder')) return 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&fit=crop';
            return \Illuminate\Support\Str::startsWith($path, 'http') ? $path : asset($path);
        }
    @endphp

    <div id="ornaments-container">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="fixed inset-0 z-[5] pointer-events-none">
        <div class="absolute inset-4 border-2 border-[#8CA6DB]/30 rounded-[30px] z-10"></div>

        <img src="{{ asset('assets/themes/watercolor/flower-top-left.png') }}" class="absolute -top-10 -left-10 w-48 opacity-90 animate-float-slow" onerror="this.style.display='none'">
        <img src="{{ asset('assets/themes/watercolor/flower-bottom-right.png') }}" class="absolute -bottom-10 -right-10 w-48 opacity-90 animate-float-slow delay-1000" onerror="this.style.display='none'">
    </div>

    <div id="music-control" class="fixed top-6 right-6 z-[100] opacity-0 pointer-events-none transition-opacity duration-1000">
        <button onclick="toggleMusic()" id="musicBtn" class="w-10 h-10 rounded-full bg-white/80 shadow-lg text-[#5D8AA8] flex items-center justify-center animate-spin-slow border border-[#5D8AA8]/20">
            <i class="ph-fill ph-music-note text-lg"></i>
        </button>
    </div>

    <audio id="bg-music" loop>
        <source src="{{ asset($invitation->content['media']['music'] ?? 'assets/music/watercolor-flow.mp3') }}" type="audio/mp3">
    </audio>

    <div id="gate" class="gate-overlay flex-col text-center px-6 bg-cover bg-center" style="background-image: url('{{ getImgUrl($invitation->content['media']['cover'] ?? 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=800&fit=crop') }}');">
        <div class="absolute inset-0 bg-white/40 backdrop-blur-[3px]"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-white/50"></div>

        <div class="relative z-10 space-y-6">
            <p class="font-serif text-sm tracking-[0.3em] text-[#5D8AA8] uppercase font-bold">The Wedding Of</p>

            <h1 class="font-script text-6xl md:text-8xl text-[#2C3E50] drop-shadow-sm leading-tight">
                {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Arta' }} <br> <span class="text-[#D65A78] text-4xl">&</span> <br> {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Canva' }}
            </h1>

            <div class="water-card px-8 py-6 inline-block">
                <p class="text-[10px] text-gray-500 tracking-widest uppercase mb-2">Kepada Yth.</p>
                <h3 class="font-serif text-xl md:text-2xl text-[#2C3E50] font-bold capitalize">
                    @if(isset($guest))
                        {{ $guest->name }}
                    @else
                        {{ request('to') ? str_replace('-', ' ', preg_replace('/-[a-zA-Z0-9]{4}$/', '', request('to'))) : 'Tamu Undangan' }}
                    @endif
                </h3>
            </div>

            <br>

            <button onclick="openInvitation()" class="px-8 py-3 rounded-full bg-[#5D8AA8] text-white shadow-lg hover:bg-[#4a6d85] transition duration-300 text-xs font-bold uppercase tracking-widest flex items-center gap-2 mx-auto transform hover:scale-105">
                <i class="ph-bold ph-envelope-open"></i> Buka Undangan
            </button>
        </div>
    </div>

    <section id="home" class="page-section active flex flex-col justify-center items-center text-center px-6 pt-20 pb-24">
        <div class="relative mb-8 w-64 h-80">
            <div class="absolute inset-0 bg-[#D65A78]/20 rounded-[40%_60%_70%_30%/40%_50%_60%_50%] animate-morph"></div>
            <img src="{{ getImgUrl($invitation->content['media']['hero'] ?? $invitation->content['media']['cover'] ?? 'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=800&fit=crop') }}" class="absolute inset-2 w-[calc(100%-16px)] h-[calc(100%-16px)] object-cover rounded-[40%_60%_70%_30%/40%_50%_60%_50%] shadow-xl">
        </div>

        <p class="font-serif text-lg text-[#5D8AA8] italic mb-2">Save The Date</p>
        <h1 class="font-script text-5xl md:text-6xl text-[#2C3E50] mb-4">
            {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Arta' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Canva' }}
        </h1>

        <div class="bg-white/60 backdrop-blur-sm px-6 py-2 rounded-full border border-white shadow-sm text-gray-600 text-xs tracking-[0.2em] uppercase mt-2">
            {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
        </div>
    </section>

    <section id="mempelai" class="page-section scrollable px-6 pt-24 pb-24">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="section-title">Mempelai</h2>
            <p class="text-xs text-gray-500 mb-8 italic max-w-xs mx-auto">"Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri..."</p>

            <div class="water-card p-6 mb-6 relative overflow-hidden">
                <div class="absolute -right-5 -top-5 w-20 h-20 bg-[#5D8AA8]/10 rounded-full blur-xl"></div>
                <img src="{{ getImgUrl($invitation->content['mempelai']['pria']['foto'] ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop') }}" class="w-32 h-32 mx-auto rounded-full border-4 border-white shadow-md mb-4 object-cover">
                <h3 class="font-script text-3xl text-[#2C3E50]">{{ $invitation->content['mempelai']['pria']['nama'] ?? 'Arta Wiguna' }}</h3>
                <p class="text-[10px] uppercase tracking-widest text-[#5D8AA8] font-bold mt-1">The Groom</p>
                <p class="text-sm text-gray-600 mt-3">Putra dari Bpk. {{ $invitation->content['mempelai']['pria']['ayah'] ?? 'Bpk. Sketsa' }} <br>& Ibu {{ $invitation->content['mempelai']['pria']['ibu'] ?? 'Ibu Gambar' }}</p>
                @if(!empty($invitation->content['mempelai']['pria']['instagram']))
                <a href="https://instagram.com/{{ $invitation->content['mempelai']['pria']['instagram'] }}" target="_blank" class="inline-block mt-3 text-[#5D8AA8]"><i class="ph-fill ph-instagram-logo text-xl"></i></a>
                @endif
            </div>

            <div class="text-4xl font-script text-[#D65A78] my-4">&</div>

            <div class="water-card p-6 relative overflow-hidden">
                <div class="absolute -left-5 -bottom-5 w-20 h-20 bg-[#D65A78]/10 rounded-full blur-xl"></div>
                <img src="{{ getImgUrl($invitation->content['mempelai']['wanita']['foto'] ?? 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=400&h=400&fit=crop') }}" class="w-32 h-32 mx-auto rounded-full border-4 border-white shadow-md mb-4 object-cover">
                <h3 class="font-script text-3xl text-[#2C3E50]">{{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Canva Larasati' }}</h3>
                <p class="text-[10px] uppercase tracking-widest text-[#D65A78] font-bold mt-1">The Bride</p>
                <p class="text-sm text-gray-600 mt-3">Putri dari Bpk. {{ $invitation->content['mempelai']['wanita']['ayah'] ?? 'Bpk. Kuas' }} <br>& Ibu {{ $invitation->content['mempelai']['wanita']['ibu'] ?? 'Ibu Warna' }}</p>
                @if(!empty($invitation->content['mempelai']['wanita']['instagram']))
                <a href="https://instagram.com/{{ $invitation->content['mempelai']['wanita']['instagram'] }}" target="_blank" class="inline-block mt-3 text-[#D65A78]"><i class="ph-fill ph-instagram-logo text-xl"></i></a>
                @endif
            </div>
        </div>
    </section>

    <section id="story" class="page-section scrollable px-6 pt-24 pb-24">
        <div class="max-w-3xl mx-auto">
            <h2 class="section-title">Kisah Kami</h2>
            <div class="relative mt-8">
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gradient-to-b from-[#5D8AA8] to-[#D65A78] opacity-30"></div>

                @php
                    $stories = $invitation->content['love_stories'] ?? [
                        ['year' => '2018', 'title' => 'Pertama Jumpa', 'story' => 'Kami bertemu pertama kali di sebuah galeri seni lokal.'],
                        ['year' => '2022', 'title' => 'Komitmen', 'story' => 'Di rooftop gedung tua, kami berjanji untuk melangkah bersama selamanya.']
                    ];
                @endphp

                @if(isset($stories) && is_array($stories))
                    @foreach($stories as $story)
                    <div class="relative pl-10 mb-8">
                        <div class="absolute left-[13px] top-1 w-3 h-3 bg-white border-2 border-[#5D8AA8] rounded-full z-10"></div>

                        <div class="water-card p-4 text-left">
                            <span class="text-[#D65A78] font-bold text-xs">{{ $story['year'] }}</span>
                            <h3 class="font-serif text-lg font-bold text-[#2C3E50]">{{ $story['title'] }}</h3>
                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $story['story'] }}</p>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <section id="event" class="page-section scrollable px-6 pt-24 pb-24">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="section-title">Rangkaian Acara</h2>

            <div class="flex justify-center gap-3 mb-10 mt-4">
                <div class="water-card p-2 w-16"><span id="days" class="block text-xl font-bold text-[#5D8AA8]">00</span><span class="text-[9px]">Hari</span></div>
                <div class="water-card p-2 w-16"><span id="hours" class="block text-xl font-bold text-[#5D8AA8]">00</span><span class="text-[9px]">Jam</span></div>
                <div class="water-card p-2 w-16"><span id="minutes" class="block text-xl font-bold text-[#5D8AA8]">00</span><span class="text-[9px]">Menit</span></div>
                <div class="water-card p-2 w-16"><span id="seconds" class="block text-xl font-bold text-[#5D8AA8]">00</span><span class="text-[9px]">Detik</span></div>
            </div>

            <div class="space-y-6">
                <div class="water-card p-6 border-t-4 border-t-[#5D8AA8]">
                    <h3 class="font-serif text-xl font-bold text-[#2C3E50] mb-2">{{ $invitation->content['acara']['akad']['judul'] ?? 'Akad Nikah' }}</h3>
                    <div class="text-[#5D8AA8] font-bold mb-4 bg-[#5D8AA8]/10 inline-block px-4 py-1 rounded-full text-xs">
                        {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('H:i') }} WIB - Selesai
                    </div>
                    <p class="text-sm font-bold text-gray-700">{{ $invitation->content['acara']['akad']['tempat'] ?? 'Masjid Agung Raya' }}</p>
                    <p class="text-xs text-gray-500 mb-1">{{ $invitation->content['acara']['akad']['alamat'] ?? '' }}</p>
                    @php
                        $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                        $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                        $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
                    @endphp
                    @if($akadL1)<p class="text-xs text-gray-400 mb-0">{{ $akadL1 }}</p>@endif
                    @if($akadL2)<p class="text-xs text-gray-400 mb-4">{{ $akadL2 }}</p>@else<span class="mb-4 block"></span>@endif
                    <a href="{{ $invitation->content['acara']['akad']['maps'] ?? '#' }}" target="_blank" class="text-xs bg-[#5D8AA8] text-white px-4 py-2 rounded-full font-bold hover:bg-[#4a6d85] transition">Google Maps</a>
                </div>

                <div class="water-card p-6 border-t-4 border-t-[#D65A78]">
                    <h3 class="font-serif text-xl font-bold text-[#2C3E50] mb-2">{{ $invitation->content['acara']['resepsi']['judul'] ?? 'Resepsi Pernikahan' }}</h3>
                    <div class="text-[#D65A78] font-bold mb-4 bg-[#D65A78]/10 inline-block px-4 py-1 rounded-full text-xs">
                        {{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->format('H:i') }} WIB - Selesai
                    </div>
                    <p class="text-sm font-bold text-gray-700">{{ $invitation->content['acara']['resepsi']['tempat'] ?? 'Ballroom Hotel Splendor' }}</p>
                    <p class="text-xs text-gray-500 mb-1">{{ $invitation->content['acara']['resepsi']['alamat'] ?? '' }}</p>
                    @php
                        $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                        $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                        $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
                    @endphp
                    @if($resepsiL1)<p class="text-xs text-gray-400 mb-0">{{ $resepsiL1 }}</p>@endif
                    @if($resepsiL2)<p class="text-xs text-gray-400 mb-4">{{ $resepsiL2 }}</p>@else<span class="mb-4 block"></span>@endif
                    <a href="{{ $invitation->content['acara']['resepsi']['maps'] ?? '#' }}" target="_blank" class="text-xs bg-[#D65A78] text-white px-4 py-2 rounded-full font-bold hover:bg-[#b04a62] transition">Google Maps</a>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="page-section scrollable px-4 pt-24 pb-24">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="section-title">Galeri Foto</h2>

            <div class="columns-2 md:columns-3 gap-3 space-y-3 mt-6">
                @php
                    $gallery = $invitation->content['media']['gallery'] ?? [
                        'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=400&h=600&fit=crop',
                        'https://images.unsplash.com/photo-1511285560982-1356c11d4606?w=400&h=600&fit=crop',
                        'https://images.unsplash.com/photo-1522673607200-1645062cd958?w=400&h=600&fit=crop',
                    ];
                @endphp
                @foreach($gallery as $photo)
                <div class="water-card p-1 break-inside-avoid hover:scale-[1.02] transition duration-500">
                    <img src="{{ getImgUrl($photo) }}" class="w-full rounded-lg" loading="lazy">
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="gift" class="page-section scrollable px-6 pt-24 pb-24">
        <div class="max-w-xl mx-auto text-center">
            <h2 class="section-title">Tanda Kasih</h2>

            <div class="water-card p-6 mt-6 bg-gradient-to-br from-white to-[#F0F8FF] border border-[#5D8AA8]/20">
                @php $amplop = $invitation->content['amplop'] ?? []; @endphp
                <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                    <p class="font-serif text-xl sm:text-2xl text-gray-800 mb-2">{{ $amplop['bank_name'] ?? 'Bank BCA' }}</p>
                    <p class="font-sans text-xl sm:text-2xl font-bold tracking-wider text-pink-600 mb-2" id="rekNum">{{ $amplop['account_number'] ?? '8888-9999-0000' }}</p>
                    <p class="text-sm text-gray-600 mb-4">a.n {{ $amplop['account_holder'] ?? 'Watercolor Putra' }}</p>
                    <button onclick="copyText('rekNum')" class="w-full py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i class="ph-bold ph-copy"></i> Salin Nomor Rekening
                    </button>
                </div>
                @if(isset($amplop['qris_image']))
                <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Atau Scan QRIS Berikut</p>
                    <img src="{{ asset($amplop['qris_image']) }}" alt="QRIS" class="w-40 h-40 object-contain mx-auto bg-white p-2 border-2 border-pink-100 rounded-xl shadow-sm">
                </div>
                @endif
            </div>
            @if(!empty($invitation->content['amplop']['alamat_kado']))
            <div class="mt-6 water-card p-6 border-dashed border-2 border-gray-300">
                <i class="ph-duotone ph-gift text-3xl text-[#D65A78] mb-2"></i>
                <p class="text-sm font-bold text-gray-700">Kirim Kado Fisik</p>
                <p class="text-xs text-gray-500 mt-1">{{ $invitation->content['amplop']['alamat_kado'] }}</p>
            </div>
            @endif
        </div>
    </section>

    <section id="rsvp" class="page-section scrollable px-6 pt-24 pb-24">
        <div class="max-w-xl mx-auto">
            <h2 class="section-title">Ucapan & Doa</h2>

            <div class="water-card p-6 mt-6">
                @if(session('success'))
                    <div class="bg-green-50 text-green-700 px-4 py-2 rounded-lg mb-4 text-xs text-center border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('kirim.ucapan') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">

                    <input type="text" name="nama" required placeholder="Nama Anda" class="w-full bg-[#F9F9F9] border border-gray-200 rounded-lg p-3 text-sm focus:border-[#5D8AA8] outline-none transition">

                    <select name="kehadiran" class="w-full bg-[#F9F9F9] border border-gray-200 rounded-lg p-3 text-sm focus:border-[#5D8AA8] outline-none transition text-gray-600">
                        <option value="hadir">Saya Akan Hadir</option>
                        <option value="tidak_hadir">Maaf Tidak Bisa Hadir</option>
                    </select>

                    <textarea name="ucapan" rows="3" required placeholder="Tulis doa & ucapan..." class="w-full bg-[#F9F9F9] border border-gray-200 rounded-lg p-3 text-sm focus:border-[#5D8AA8] outline-none transition"></textarea>

                    <button type="submit" class="w-full bg-[#5D8AA8] text-white font-bold py-3 rounded-lg hover:bg-[#4a6d85] transition text-sm shadow-md">
                        KIRIM UCAPAN
                    </button>
                </form>
            </div>

            <div class="space-y-3 mt-6 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                @foreach($invitation->comments as $comment)
                <div class="water-card p-3 flex gap-3 items-start">
                    <div class="w-8 h-8 rounded-full bg-gray-100 text-[#5D8AA8] flex items-center justify-center font-bold text-xs shrink-0 border border-gray-200">
                        {{ substr($comment->name ?? '', 0, 1) }}
                    </div>
                    <div class="w-full">
                        <div class="flex justify-between items-start">
                            <h4 class="font-bold text-[#2C3E50] text-xs">{{ $comment->name }}</h4>
                            <span class="text-[9px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <span class="text-[9px] px-2 py-0.5 rounded-full inline-block mb-1 {{ $comment->rsvp_status == 'hadir' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ $comment->rsvp_status == 'hadir' ? 'Hadir' : ($comment->rsvp_status == 'ragu' ? 'Ragu' : 'Tidak Hadir') }}
                        </span>
                        <p class="text-xs text-gray-600 italic">"{{ $comment->comment }}"</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="nav-wrapper opacity-0 pointer-events-none transition-opacity duration-1000" id="navWrapper">
        <div class="nav-items">
            <button class="nav-btn active" onclick="switchPage('home')" data-label="Home"><i class="ph ph-house-line"></i></button>
            <button class="nav-btn" onclick="switchPage('mempelai')" data-label="Couple"><i class="ph ph-heart"></i></button>
            <button class="nav-btn" onclick="switchPage('story')" data-label="Story"><i class="ph ph-book-open-text"></i></button>
            <button class="nav-btn" onclick="switchPage('event')" data-label="Event"><i class="ph ph-calendar-heart"></i></button>
            <button class="nav-btn" onclick="switchPage('gallery')" data-label="Gallery"><i class="ph ph-image"></i></button>
            <button class="nav-btn" onclick="switchPage('gift')" data-label="Gift"><i class="ph ph-gift"></i></button>
            <button class="nav-btn" onclick="switchPage('rsvp')" data-label="Wishes"><i class="ph ph-chat-circle-text"></i></button>
        </div>
        <button class="nav-trigger" onclick="toggleNav()">
            <i class="ph ph-list font-bold"></i>
        </button>
    </div>

    <script>
        function openInvitation() {
            document.getElementById('gate').classList.add('open');
            document.getElementById('bg-music').play().catch(e => console.log("Audio play failed"));
            setTimeout(() => {
                document.getElementById('music-control').classList.remove('opacity-0', 'pointer-events-none');
                document.getElementById('navWrapper').classList.remove('opacity-0', 'pointer-events-none');
            }, 500);
        }

        function toggleMusic() {
            const audio = document.getElementById('bg-music');
            const btn = document.getElementById('musicBtn');
            if (audio.paused) {
                audio.play();
                btn.classList.add('animate-spin-slow');
            } else {
                audio.pause();
                btn.classList.remove('animate-spin-slow');
            }
        }

        function copyText(id) {
            navigator.clipboard.writeText(document.getElementById(id).innerText).then(() => alert('Disalin!'));
        }

        function toggleNav() {
            const wrapper = document.getElementById('navWrapper');
            const icon = wrapper.querySelector('.nav-trigger i');
            wrapper.classList.toggle('open');
            icon.classList.toggle('ph-list', !wrapper.classList.contains('open'));
            icon.classList.toggle('ph-x', wrapper.classList.contains('open'));
        }

        function switchPage(pageId) {

            document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));

            const target = document.getElementById(pageId);
            target.classList.add('active');

            if(target.classList.contains('scrollable')) target.scrollTop = 0;

            document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
            const activeBtn = document.querySelector(`button[onclick="switchPage('${pageId}')"]`);
            if(activeBtn) activeBtn.classList.add('active');

            toggleNav();
        }

        const targetDate = new Date("{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now()->addDays(20))->format('Y-m-d H:i:s') }}").getTime();
        setInterval(() => {
            const now = new Date().getTime();
            const diff = targetDate - now;
            if(diff > 0) {
                document.getElementById('days').innerText = Math.floor(diff / (1000 * 60 * 60 * 24));
                document.getElementById('hours').innerText = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                document.getElementById('minutes').innerText = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                document.getElementById('seconds').innerText = Math.floor((diff % (1000 * 60)) / 1000);
            }
        }, 1000);
    </script>
</body>
</html>