<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Bayu' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Marina' }}</title>
    @vite(['resources/css/ocean.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>

    @php
        function getImgUrl($path) {

            if (!$path) return 'https://images.unsplash.com/photo-1544207246-bedac5a36b53?w=800&fit=crop';
            if (str_contains($path, 'placeholder')) return 'https://images.unsplash.com/photo-1544207246-bedac5a36b53?w=800&fit=crop';
            return \Illuminate\Support\Str::startsWith($path, 'http') ? $path : asset($path);
        }
    @endphp

<div class="app-container">

    <div class="music-btn" id="musicBtn" onclick="toggleMusic()">
        <i class="ph-fill ph-music-note text-lg" id="musicIcon"></i>
    </div>
    <audio id="bgMusic" loop>
        <source src="{{ asset($invitation->content['media']['music'] ?? 'assets/music/ocean-breeze.mp3') }}" type="audio/mpeg">
    </audio>

    <div class="gate-overlay" id="gate" style="background-image: url('{{ getImgUrl($invitation->content['media']['cover'] ?? 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=800&fit=crop') }}');">
        <div class="absolute inset-0 bg-[#1F4E79]/60 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#1F4E79] via-transparent to-transparent"></div>

        <div class="relative z-10 text-center text-white px-6">
            <p class="text-xs tracking-[0.3em] uppercase opacity-90 mb-4">The Wedding Of</p>
            <h1 class="font-serif text-5xl md:text-6xl mb-2 drop-shadow-lg leading-tight">
                {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Bayu' }} <br>
                <span class="text-3xl text-gold font-serif italic">&</span> <br>
                {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Marina' }}
            </h1>
            <p class="mt-4 mb-8 text-sm opacity-90">{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}</p>

            <div class="bg-white/10 backdrop-blur-md border border-white/20 px-6 py-3 rounded-xl inline-block mb-8">
                <p class="text-[10px] uppercase tracking-widest opacity-70 mb-1">Kepada Yth:</p>
                <h3 class="font-serif text-lg capitalize font-bold">
                    @if(isset($guest))
                        {{ $guest->name }}
                    @else
                        {{ request('to') ? str_replace('-', ' ', preg_replace('/-[a-zA-Z0-9]{4}$/', '', request('to'))) : 'Tamu Undangan' }}
                    @endif
                </h3>
            </div>
            <br>
            <button onclick="openInvitation()" class="bg-white text-[#1F4E79] px-8 py-3 rounded-full text-xs font-bold uppercase tracking-widest hover:bg-[#A9D6E5] transition transform hover:scale-105 shadow-xl flex items-center gap-2 mx-auto">
                <i class="ph-bold ph-envelope-open"></i> Buka Undangan
            </button>
        </div>
    </div>

    <section id="page-home" class="page-section active flex flex-col items-center pt-0">
        <div class="relative w-full h-[55vh]">
            <img src="{{ getImgUrl($invitation->content['media']['hero'] ?? $invitation->content['media']['cover'] ?? 'https://images.unsplash.com/photo-1544207246-bedac5a36b53?w=800&fit=crop') }}" class="w-full h-full object-cover rounded-b-[40px] shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-t from-[#F0F8FF] to-transparent rounded-b-[40px]"></div>
        </div>
        <div class="px-6 -mt-8 w-full relative z-10">
            <div class="ocean-card text-center">
                <p class="text-xs text-gold uppercase tracking-widest mb-2">Save The Date</p>
                <h1 class="font-serif text-3xl text-deep-blue mb-4">
                    {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Bayu' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Marina' }}
                </h1>

                <div id="countdown" class="flex justify-center gap-2 mb-4"></div>

                <p class="text-xs text-gray-500 italic">"{{ $invitation->content['quote'] ?? 'Seperti ombak yang selalu kembali ke pantai, cintaku akan selalu kembali padamu.' }}"</p>
            </div>
        </div>
    </section>

    <section id="page-couple" class="page-section scrollable pt-20 px-6">
        <h2 class="font-serif text-3xl text-deep-blue text-center mb-10">Mempelai</h2>

        <div class="couple-wrapper">
            <div class="couple-bg-blob"></div>
            <div class="couple-photo-box">
                <img src="{{ getImgUrl($invitation->content['mempelai']['pria']['foto'] ?? 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&h=400&fit=crop') }}" alt="Groom">
            </div>
            <div class="relative z-10">
                <h3 class="font-serif text-2xl text-deep-blue font-bold">{{ $invitation->content['mempelai']['pria']['nama'] ?? 'Bayu Samudra' }}</h3>
                <p class="text-xs text-gold font-bold uppercase tracking-widest mb-2">The Groom</p>
                <p class="text-xs text-gray-500">Putra Bpk {{ $invitation->content['mempelai']['pria']['ayah'] ?? 'Bpk. Samudra' }} <br>& Ibu {{ $invitation->content['mempelai']['pria']['ibu'] ?? 'Ibu Airin' }}</p>
                @if(!empty($invitation->content['mempelai']['pria']['instagram']))
                <a href="https://instagram.com/{{ $invitation->content['mempelai']['pria']['instagram'] }}" class="inline-block mt-2 text-deep-blue"><i class="ph-fill ph-instagram-logo text-xl"></i></a>
                @endif
            </div>
        </div>

        <div class="text-center my-8 text-3xl text-gold font-serif">&</div>

        <div class="couple-wrapper">
            <div class="couple-bg-blob"></div>
            <div class="couple-photo-box">
                <img src="{{ getImgUrl($invitation->content['mempelai']['wanita']['foto'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=400&fit=crop') }}" alt="Bride">
            </div>
            <div class="relative z-10">
                <h3 class="font-serif text-2xl text-deep-blue font-bold">{{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Marina Azzurra' }}</h3>
                <p class="text-xs text-gold font-bold uppercase tracking-widest mb-2">The Bride</p>
                <p class="text-xs text-gray-500">Putri Bpk {{ $invitation->content['mempelai']['wanita']['ayah'] ?? 'Bpk. Maritim' }} <br>& Ibu {{ $invitation->content['mempelai']['wanita']['ibu'] ?? 'Ibu Lauta' }}</p>
                @if(!empty($invitation->content['mempelai']['wanita']['instagram']))
                <a href="https://instagram.com/{{ $invitation->content['mempelai']['wanita']['instagram'] }}" class="inline-block mt-2 text-deep-blue"><i class="ph-fill ph-instagram-logo text-xl"></i></a>
                @endif
            </div>
        </div>
    </section>

    <section id="page-story" class="page-section scrollable pt-20 px-6">
        <h2 class="font-serif text-3xl text-deep-blue text-center mb-8">Kisah Kami</h2>

        @php
            $defaultStories = [
                ['year' => '2019', 'title' => 'Pertemuan', 'story' => 'Kami bertemu pertama kali di sebuah festival musik jazz tepi pantai.'],
                ['year' => '2023', 'title' => 'Lamaran', 'story' => 'Di atas perahu saat matahari terbenam, ia memintaku menjadi pendamping hidupnya.']
            ];
            $stories = $invitation->content['love_stories'] ?? $defaultStories;
        @endphp

        @if(!empty($stories))
        <div class="timeline">
            @foreach($stories as $story)
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="ocean-card p-4 mb-0">
                    <span class="text-gold font-bold text-xs bg-gold/10 px-2 py-1 rounded">{{ $story['year'] }}</span>
                    <h4 class="font-serif text-lg text-deep-blue mt-2 mb-1">{{ $story['title'] }}</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">{{ $story['story'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-500 text-sm">Every love story is beautiful.</p>
        @endif
    </section>

    <section id="page-event" class="page-section scrollable pt-20 px-6">
        <h2 class="font-serif text-3xl text-deep-blue text-center mb-8">Acara</h2>

        <div class="ocean-card border-l-4 border-l-[#1F4E79]">
            <div class="flex justify-between">
                <h3 class="font-serif text-xl text-deep-blue font-bold">{{ $invitation->content['acara']['akad']['judul'] ?? 'Akad Nikah' }}</h3>
                <i class="ph-duotone ph-hands-praying text-2xl text-deep-blue opacity-50"></i>
            </div>
            <hr class="my-3 border-gray-100">
            <p class="text-sm font-bold mb-1">{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}</p>
            <p class="text-xs text-gray-600 mb-3">Pukul {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('H:i') }} WIB</p>
            <p class="text-xs text-gray-500 bg-gray-50 p-2 rounded">{{ $invitation->content['acara']['akad']['tempat'] ?? 'Blue Lagoon Chapel' }}<br>{{ $invitation->content['acara']['akad']['alamat'] ?? '' }}</p>
            @php
                $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
            @endphp
            @if($akadL1)<p class="text-xs text-gray-400 bg-gray-50 px-2 pb-1 rounded">{{ $akadL1 }}</p>@endif
            @if($akadL2)<p class="text-xs text-gray-400 bg-gray-50 px-2 pb-2 rounded">{{ $akadL2 }}</p>@endif
            <a href="{{ $invitation->content['acara']['akad']['maps'] ?? '#' }}" class="inline-block mt-3 text-xs font-bold text-deep-blue underline">Google Maps</a>
        </div>

        <div class="ocean-card border-l-4 border-l-[#D4C5A0]">
            <div class="flex justify-between">
                <h3 class="font-serif text-xl text-deep-blue font-bold">{{ $invitation->content['acara']['resepsi']['judul'] ?? 'Resepsi Sunset' }}</h3>
                <i class="ph-duotone ph-wine text-2xl text-gold opacity-80"></i>
            </div>
            <hr class="my-3 border-gray-100">
            <p class="text-sm font-bold mb-1">{{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->translatedFormat('l, d F Y') }}</p>
            <p class="text-xs text-gray-600 mb-3">Pukul {{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->format('H:i') }} WIB</p>
            <p class="text-xs text-gray-500 bg-gray-50 p-2 rounded">{{ $invitation->content['acara']['resepsi']['tempat'] ?? 'The Bay Beach Club' }}<br>{{ $invitation->content['acara']['resepsi']['alamat'] ?? '' }}</p>
            @php
                $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
            @endphp
            @if($resepsiL1)<p class="text-xs text-gray-400 bg-gray-50 px-2 pb-1 rounded">{{ $resepsiL1 }}</p>@endif
            @if($resepsiL2)<p class="text-xs text-gray-400 bg-gray-50 px-2 pb-2 rounded">{{ $resepsiL2 }}</p>@endif
            <a href="{{ $invitation->content['acara']['resepsi']['maps'] ?? '#' }}" class="inline-block mt-3 text-xs font-bold text-gold underline">Google Maps</a>
        </div>
    </section>

    <section id="page-gallery" class="page-section scrollable pt-20 px-4">
        <h2 class="font-serif text-3xl text-deep-blue text-center mb-6">Galeri</h2>
        <div class="gallery-grid mb-12">
            @php
                $gallery = $invitation->content['media']['gallery'] ?? [
                    'https://images.unsplash.com/photo-1544207246-bedac5a36b53?w=400&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=400&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=400&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400&h=600&fit=crop',
                ];
            @endphp
            @foreach($gallery as $photo)
                <img src="{{ getImgUrl($photo) }}" class="gallery-img">
            @endforeach
        </div>
    </section>

    <section id="page-wishes" class="page-section scrollable pt-20 px-6">

        <h2 class="font-serif text-3xl text-deep-blue text-center mb-6">Wedding Gift</h2>

        <div class="gift-card-cc">
                <div class="ocean-card p-6 sm:p-8 rounded-[2rem] text-center mb-8 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/40 to-white/10 backdrop-blur-md opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    <div class="relative z-10">
                        <i class="ph-duotone ph-credit-card text-4xl text-deep-blue mb-4"></i>
                        <p class="text-xs font-bold uppercase tracking-widest text-[#5F9EA0] mb-2">Transfer Bank</p>
                        <h3 class="font-serif text-2xl text-deep-blue mb-4">{{ $invitation->content['amplop']['bank_name'] ?? 'Bank Mandiri' }}</h3>
                        
                        <div class="bg-white/60 p-4 rounded-xl mb-4 border border-white/50 shadow-[0_4px_15px_-5px_rgba(0,0,0,0.05)]">
                            <p class="font-sans text-2xl sm:text-3xl font-bold tracking-[0.15em] text-deep-blue mb-1" id="rekNum">{{ $invitation->content['amplop']['account_number'] ?? '1234-5678-9000' }}</p>
                            <p class="text-sm text-[#5F9EA0]">a.n {{ $invitation->content['amplop']['account_holder'] ?? 'Ocean Putra' }}</p>
                        </div>

                        <button onclick="copyText('rekNum')" class="w-full sm:w-auto px-8 py-3 bg-deep-blue hover:bg-[#1A3A5A] text-white text-xs font-bold uppercase tracking-widest rounded-full transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 mx-auto">
                            <i class="ph-bold ph-copy"></i> Salin Nomor 
                        </button>
                        @if(isset($invitation->content['amplop']['qris_image']))
                        <div class="mt-6 pt-6 border-t border-[#5F9EA0]/20">
                            <p class="text-[10px] font-bold text-[#5F9EA0] uppercase tracking-widest mb-4">Atau Scan QRIS Berikut</p>
                            <img src="{{ asset($invitation->content['amplop']['qris_image']) }}" alt="QRIS" class="w-40 h-40 object-contain mx-auto bg-white p-2 border-2 border-[#5F9EA0]/30 rounded-xl shadow-md">
                        </div>
                        @endif
                    </div>
                </div>

        @if(!empty($invitation->content['amplop']['alamat_kado']))
        <div class="ocean-card text-center border-dashed border-2 mb-10">
            <p class="text-xs font-bold text-deep-blue">Kirim Kado Fisik</p>
            <p class="text-xs text-gray-500 mt-1">{{ $invitation->content['amplop']['alamat_kado'] }}</p>
        </div>
        @endif

        <hr class="border-t border-gray-300 my-8 w-1/2 mx-auto">

        <h2 class="font-serif text-3xl text-deep-blue text-center mb-8">Ucapan & Doa</h2>

        <div class="ocean-card">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded text-xs text-center mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('kirim.ucapan') }}" method="POST">
                @csrf
                <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">
                <input type="text" name="nama" placeholder="Nama Lengkap" class="form-input" required>
                <select name="kehadiran" class="form-input cursor-pointer text-gray-600">
                    <option value="hadir">Saya Akan Hadir</option>
                    <option value="tidak_hadir">Maaf, Tidak Bisa Hadir</option>
                    <option value="ragu">Masih Ragu</option>
                </select>
                <textarea name="ucapan" rows="3" placeholder="Tuliskan doa restu..." class="form-input resize-none" required></textarea>
                <button type="submit" class="btn-primary">KIRIM UCAPAN</button>
            </form>
        </div>

        <div class="space-y-4 pb-4">
            @foreach($invitation->comments->sortByDesc('created_at') as $comment)
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-100 text-deep-blue flex items-center justify-center font-bold text-xs shrink-0">
                    {{ substr($comment->name ?? '', 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <strong class="text-deep-blue text-sm">{{ $comment->name }}</strong>
                        <span class="text-[9px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs text-gray-600 italic">"{{ $comment->comment }}"</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <div class="bottom-nav" id="bottomNav">
        <div class="nav-item active" onclick="switchPage('home', this)"><i class="ph-fill ph-house"></i></div>
        <div class="nav-item" onclick="switchPage('couple', this)"><i class="ph-fill ph-heart"></i></div>
        <div class="nav-item" onclick="switchPage('story', this)"><i class="ph-fill ph-book-open-text"></i></div>
        <div class="nav-item" onclick="switchPage('event', this)"><i class="ph-fill ph-calendar-check"></i></div>
        <div class="nav-item" onclick="switchPage('gallery', this)"><i class="ph-fill ph-image"></i></div>
        <div class="nav-item" onclick="switchPage('wishes', this)"><i class="ph-fill ph-chat-circle-text"></i></div>
    </div>

</div>

<script>
    function openInvitation() {
        document.getElementById('gate').classList.add('open');
        setTimeout(() => {
            document.getElementById('bottomNav').classList.add('visible');
            document.getElementById('musicBtn').classList.add('visible');
        }, 800);
        const audio = document.getElementById('bgMusic');
        if(audio) {
            audio.play();
            document.getElementById('musicBtn').classList.add('spin');
        }
    }

    function toggleMusic() {
        const audio = document.getElementById('bgMusic');
        const btn = document.getElementById('musicBtn');
        const icon = document.getElementById('musicIcon');

        if (audio.paused) {
            audio.play();
            btn.classList.add('spin');
            icon.classList.replace('ph-pause', 'ph-music-note');
        } else {
            audio.pause();
            btn.classList.remove('spin');
            icon.classList.replace('ph-music-note', 'ph-pause');
        }
    }

    function switchPage(pageId, element) {
        document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));
        const target = document.getElementById('page-' + pageId);
        target.classList.add('active');
        if(target.classList.contains('scrollable')) target.scrollTop = 0;

        document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }

    function copyText(id) {
        navigator.clipboard.writeText(document.getElementById(id).innerText).then(() => alert('Nomor Rekening Disalin!'));
    }

    const targetDate = new Date("{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now()->addDays(20))->format('Y-m-d H:i:s') }}").getTime();
    setInterval(() => {
        const now = new Date().getTime();
        const diff = targetDate - now;
        if(diff > 0) {
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const secs = Math.floor((diff % (1000 * 60)) / 1000);

            const boxClass = "bg-[#F0F8FF] p-2 rounded-lg text-center w-14 shadow-sm border border-[#A9D6E5]";
            const numClass = "block font-bold text-lg text-[#1F4E79]";
            const labelClass = "text-[9px] uppercase tracking-wide text-gray-500";

            document.getElementById('countdown').innerHTML = `
                <div class="${boxClass}"><span class="${numClass}">${days}</span><span class="${labelClass}">Hari</span></div>
                <div class="${boxClass}"><span class="${numClass}">${hours}</span><span class="${labelClass}">Jam</span></div>
                <div class="${boxClass}"><span class="${numClass}">${mins}</span><span class="${labelClass}">Mnt</span></div>
                <div class="${boxClass}"><span class="${numClass}">${secs}</span><span class="${labelClass}">Dtk</span></div>
            `;
        }
    }, 1000);
</script>
</body>
</html>