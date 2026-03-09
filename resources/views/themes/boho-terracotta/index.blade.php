<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</title>
    @vite(['resources/css/boho.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>

<div class="app-container">

    @if(isset($invitation->content['media']['music']))
    <div class="music-btn" id="musicBtn" onclick="toggleMusic()">
        <i class="ph-fill ph-music-note text-xl" id="musicIcon"></i>
    </div>
    <audio id="bgMusic" loop>
        <source src="{{ asset($invitation->content['media']['music']) }}" type="audio/mpeg">
    </audio>
    @endif

    <div class="gate-overlay" id="gate" style="background-image: url('{{ asset($invitation->content['media']['cover'] ?? '') }}');">
        <div class="absolute inset-0 bg-[#3D322C]/40"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#3D322C] via-transparent to-transparent opacity-90"></div>

        <div class="relative z-10 text-center text-[#F9F5F0] px-8 pb-16 w-full">
            <div class="p-8 rounded-t-[100px] rounded-b-xl backdrop-blur-md bg-[#3D322C]/40 border border-[#F9F5F0]/20 shadow-2xl">
                <p class="text-[10px] tracking-[0.4em] uppercase opacity-70 mb-4 font-bold">The Wedding Of</p>

                <h1 class="font-serif text-5xl mb-2 leading-none italic">
                    {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} <br>
                    <span class="text-3xl font-sans not-italic text-[#DBCDBA]">&</span> <br>
                    {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                </h1>

                <div class="w-12 h-px bg-[#DBCDBA]/60 mx-auto my-6"></div>

                <p class="text-[10px] uppercase tracking-widest mb-2 opacity-60">Kepada Yth:</p>
                <h3 class="font-serif text-xl font-bold capitalize mb-8">{{ isset($guest) ? $guest->name : 'Tamu Undangan' }}</h3>

                <button onclick="openInvitation()" class="bg-[#F9F5F0] text-[#3D322C] px-8 py-4 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-[#DBCDBA] transition shadow-lg flex items-center gap-2 mx-auto">
                    Buka Undangan
                </button>
            </div>
        </div>
    </div>

    <section id="page-home" class="page-section active flex flex-col items-center pt-10 px-6 overflow-y-auto pb-40">
        <div class="animate-up w-full">
            <p class="text-xs text-terra font-bold uppercase tracking-[0.3em] mb-6 text-center">Save The Date</p>

            <div class="relative w-full h-[50vh] mb-8">
                <div class="absolute inset-0 border border-terra rounded-t-[150px] translate-x-2 translate-y-2 opacity-30"></div>

                <img src="{{ asset($invitation->content['media']['cover'] ?? '') }}" class="w-full h-full object-cover rounded-t-[150px] shadow-xl border-[6px] border-white relative z-10">
            </div>

            <div class="text-center">
                <h1 class="font-serif text-4xl text-coffee mb-2 italic">
                    {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} <span class="text-terra not-italic">&</span> {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                </h1>
                <p class="text-sm font-bold text-terra uppercase tracking-wide mb-6">
                    {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
                </p>

                <div id="countdown" class="flex justify-center gap-4 mb-8 text-coffee font-serif italic text-xl"></div>

                <p class="text-xs text-coffee opacity-60 leading-relaxed max-w-xs mx-auto">"{{ $invitation->content['quote'] ?? '' }}"</p>
            </div>
        </div>
    </section>

    <section id="page-couple" class="page-section scrollable pt-20 px-6 pb-40">
        <h2 class="font-serif text-4xl text-coffee text-center mb-10 italic animate-up">The Couple</h2>

        <div class="flex flex-col items-center mb-12 animate-up">
            <div class="couple-frame-wrapper">
                <div class="couple-deco"></div>
                <img src="{{ asset($invitation->content['mempelai']['pria']['foto'] ?? '') }}" class="couple-arch">
            </div>
            <h3 class="font-serif text-3xl text-terra font-bold mt-2">{{ $invitation->content['mempelai']['pria']['nama'] ?? 'Mempelai Pria' }}</h3>
            <p class="text-[10px] text-coffee uppercase tracking-[0.2em] opacity-50 mb-3 mt-1">The Groom</p>
            <p class="text-xs text-coffee text-center opacity-80 leading-relaxed">Putra Bpk {{ $invitation->content['mempelai']['pria']['ayah'] ?? '' }} <br>& Ibu {{ $invitation->content['mempelai']['pria']['ibu'] ?? '' }}</p>
            @if(!empty($invitation->content['mempelai']['pria']['instagram']))
            <a href="https://instagram.com/{{ $invitation->content['mempelai']['pria']['instagram'] }}" class="mt-3 text-terra border-b border-terra text-xs pb-0.5">@ {{ $invitation->content['mempelai']['pria']['instagram'] }}</a>
            @endif
        </div>

        <div class="flex flex-col items-center animate-up">
            <div class="couple-frame-wrapper">
                <div class="couple-deco"></div>
                <img src="{{ asset($invitation->content['mempelai']['wanita']['foto'] ?? '') }}" class="couple-arch">
            </div>
            <h3 class="font-serif text-3xl text-terra font-bold mt-2">{{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Mempelai Wanita' }}</h3>
            <p class="text-[10px] text-coffee uppercase tracking-[0.2em] opacity-50 mb-3 mt-1">The Bride</p>
            <p class="text-xs text-coffee text-center opacity-80 leading-relaxed">Putri Bpk {{ $invitation->content['mempelai']['wanita']['ayah'] ?? '' }} <br>& Ibu {{ $invitation->content['mempelai']['wanita']['ibu'] ?? '' }}</p>
            @if(!empty($invitation->content['mempelai']['wanita']['instagram']))
            <a href="https://instagram.com/{{ $invitation->content['mempelai']['wanita']['instagram'] }}" class="mt-3 text-terra border-b border-terra text-xs pb-0.5">@ {{ $invitation->content['mempelai']['wanita']['instagram'] }}</a>
            @endif
        </div>
    </section>

    <section id="page-story" class="page-section scrollable pt-20 px-6 pb-40">
        <h2 class="font-serif text-4xl text-coffee text-center mb-10 italic animate-up">Our Journey</h2>

        @if(isset($invitation->content['love_stories']) && is_array($invitation->content['love_stories']))
        <div class="ml-4 animate-up">
            @foreach($invitation->content['love_stories'] as $story)
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <span class="text-terra font-bold text-xs mb-1 block">{{ $story['year'] ?? '' }}</span>
                <h4 class="font-serif text-xl text-coffee mb-3">{{ $story['title'] ?? '' }}</h4>
                <div class="boho-card p-5 mb-0">
                    <p class="text-xs text-gray-600 leading-relaxed">{{ $story['story'] ?? '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-sm text-gray-500">Love is a beautiful journey.</p>
        @endif
    </section>

    <section id="page-event" class="page-section scrollable pt-20 px-6 pb-40">
        <h2 class="font-serif text-4xl text-coffee text-center mb-10 italic animate-up">The Event</h2>

        <div class="boho-card text-center animate-up">
            <h3 class="font-serif text-3xl text-terra mb-2 italic">{{ $invitation->content['acara']['akad']['judul'] ?? 'Akad Nikah' }}</h3>
            <p class="text-[10px] font-bold text-coffee uppercase tracking-[0.15em] mb-6 border-b border-[#DBCDBA] pb-4 inline-block">
                {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
            </p>

            <div class="mb-4">
                <p class="text-sm font-bold text-coffee">{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('H:i') }} WIB - Selesai</p>
            </div>
            <p class="text-xs text-gray-600 mb-1 px-4">{{ $invitation->content['acara']['akad']['alamat'] ?? '' }}</p>
            @php
                $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
            @endphp
            @if($akadL1)<p class="text-xs text-gray-500 mb-0 px-4">{{ $akadL1 }}</p>@endif
            @if($akadL2)<p class="text-xs text-gray-500 mb-4 px-4">{{ $akadL2 }}</p>@else<span class="mb-4 block"></span>@endif
            @if(!empty($invitation->content['acara']['akad']['maps']))
            <a href="{{ $invitation->content['acara']['akad']['maps'] }}" class="inline-block bg-[#F2EBE5] text-terra px-6 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-[#DBCDBA] transition">Open Map</a>
            @endif
        </div>

        <div class="boho-card text-center mt-6 animate-up">
            <h3 class="font-serif text-3xl text-terra mb-2 italic">{{ $invitation->content['acara']['resepsi']['judul'] ?? 'Resepsi' }}</h3>
            <p class="text-[10px] font-bold text-coffee uppercase tracking-[0.15em] mb-6 border-b border-[#DBCDBA] pb-4 inline-block">
                {{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
            </p>

            <div class="mb-4">
                <p class="text-sm font-bold text-coffee">{{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->format('H:i') }} WIB - Selesai</p>
            </div>
            <p class="text-xs text-gray-600 mb-1 px-4">{{ $invitation->content['acara']['resepsi']['alamat'] ?? '' }}</p>
            @php
                $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
            @endphp
            @if($resepsiL1)<p class="text-xs text-gray-500 mb-0 px-4">{{ $resepsiL1 }}</p>@endif
            @if($resepsiL2)<p class="text-xs text-gray-500 mb-4 px-4">{{ $resepsiL2 }}</p>@else<span class="mb-4 block"></span>@endif
            @if(!empty($invitation->content['acara']['resepsi']['maps']))
            <a href="{{ $invitation->content['acara']['resepsi']['maps'] }}" class="inline-block bg-[#F2EBE5] text-terra px-6 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-[#DBCDBA] transition">Open Map</a>
            @endif
        </div>
    </section>

    <section id="page-gallery" class="page-section scrollable pt-20 px-6 pb-40">
        <h2 class="font-serif text-4xl text-coffee text-center mb-8 italic animate-up">Gallery</h2>
        <div class="grid grid-cols-2 gap-4 animate-up">
            @if(isset($invitation->content['media']['gallery']) && is_array($invitation->content['media']['gallery']))
                @foreach($invitation->content['media']['gallery'] as $photo)
                    @php
                        $photoUrl = Str::startsWith($photo, 'http') ? $photo : asset($photo);
                    @endphp
                    <div class="aspect-[3/4] overflow-hidden rounded-lg shadow-md border border-gray-100">
                        <img src="{{ $photoUrl }}" class="w-full h-full object-cover transition duration-500 hover:scale-105" alt="Gallery">
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <section id="page-wishes" class="page-section scrollable pt-20 px-6 pb-40">

        <div class="animate-up">
            <h2 class="font-serif text-4xl text-coffee text-center mb-8 italic">Wedding Gift</h2>

            @if(!empty($invitation->content['amplop']['bank_name']))
            <div class="gift-card-boho">
                <p class="text-[10px] uppercase tracking-[0.2em] opacity-60 mb-3">Digital Envelope</p>
                <div class="w-8 h-px bg-terra mx-auto mb-4"></div>
                <p class="font-serif text-2xl text-sand-800 mb-6">{{ $invitation->content['amplop']['bank_name'] ?? 'Bank Mandiri' }}</p>
                <div class="bg-white/50 backdrop-blur-sm shadow-inner rounded-xl p-4 sm:p-6 mb-6">
                    <p class="font-serif text-2xl sm:text-3xl font-bold tracking-wider text-sand-900 mb-2" id="rekNum">{{ $invitation->content['amplop']['account_number'] ?? '1234-5678-9000' }}</p>
                    <p class="text-sm text-sand-700">a.n {{ $invitation->content['amplop']['account_holder'] ?? 'Boho Putra' }}</p>
                </div>
                <button onclick="copyText('rekNum')" class="bg-terra hover:bg-sand-900 text-white px-8 py-3 rounded-full text-xs font-bold uppercase tracking-widest transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2 mx-auto">
                    <i class="ph-bold ph-copy"></i> Salin Nomor Rekening
                </button>
                @if(isset($invitation->content['amplop']['qris_image']))
                <div class="mt-8 pt-6 border-t border-sand-400 border-dashed">
                    <p class="text-[10px] font-bold text-terra uppercase tracking-widest mb-4">Atau Scan QRIS</p>
                    <img src="{{ asset($invitation->content['amplop']['qris_image']) }}" alt="QRIS" class="w-40 h-40 object-contain mx-auto bg-white p-2 border border-sand-400 rounded-xl shadow-sm">
                </div>
                @endif
            </div>
            @endif

            @if(!empty($invitation->content['amplop']['alamat_kado']))
            <div class="text-center mt-6 p-4 rounded border border-dashed border-[#DBCDBA] bg-[#fffbf5]">
                <p class="text-[10px] font-bold text-terra uppercase tracking-widest mb-2">Kirim Kado Fisik</p>
                <p class="text-xs text-gray-500 italic">{{ $invitation->content['amplop']['alamat_kado'] }}</p>
                @if(!empty($invitation->content['amplop']['maps_kado']))
                <a href="{{ $invitation->content['amplop']['maps_kado'] }}" class="mt-2 inline-block text-[10px] text-terra border-b border-terra">Lihat Alamat</a>
                @endif
            </div>
            @endif
        </div>

        <hr class="border-t border-[#DBCDBA] my-10 mx-auto w-1/2">

        <div class="animate-up">
            <h2 class="font-serif text-3xl text-coffee text-center mb-8 italic">Wishes</h2>

            <div class="boho-card">
                @if(session('success'))
                    <div class="bg-[#F2EBE5] text-terra px-4 py-3 rounded text-xs text-center mb-6 font-bold tracking-wide">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('kirim.ucapan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">

                    <input type="text" name="nama" placeholder="Nama Lengkap" class="form-input" required>
                    <select name="kehadiran" class="form-input cursor-pointer bg-transparent">
                        <option value="hadir">Saya Akan Hadir</option>
                        <option value="tidak_hadir">Maaf, Tidak Bisa Hadir</option>
                        <option value="ragu">Masih Ragu</option>
                    </select>
                    <textarea name="ucapan" rows="3" placeholder="Tuliskan doa restu..." class="form-input resize-none" required></textarea>

                    <button type="submit" class="btn-terra mt-2">Kirim Ucapan</button>
                </form>
            </div>

            <div class="space-y-4 pb-4">
                @foreach($invitation->comments->sortByDesc('created_at') as $comment)
                <div class="bg-white border-b border-[#E0D8CC] p-4 flex gap-3">
                    <div class="w-8 h-8 rounded-full
                        {{ $comment->rsvp_status == 'hadir' ? 'bg-green-100 text-green-700' : ($comment->rsvp_status == 'tidak_hadir' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}
                         flex items-center justify-center font-bold text-xs shrink-0">
                        {{ substr($comment->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <strong class="text-terra text-sm">{{ $comment->name }}</strong>
                            <span class="text-[9px] text-gray-400 uppercase tracking-wide">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-coffee italic opacity-80">"{{ $comment->comment }}"</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="bottom-nav" id="bottomNav">
        <div class="nav-item active" onclick="switchPage('home', this)"><i class="ph-bold ph-house"></i></div>
        <div class="nav-item" onclick="switchPage('couple', this)"><i class="ph-bold ph-heart"></i></div>
        <div class="nav-item" onclick="switchPage('story', this)"><i class="ph-bold ph-book-open-text"></i></div>
        <div class="nav-item" onclick="switchPage('event', this)"><i class="ph-bold ph-calendar-check"></i></div>
        <div class="nav-item" onclick="switchPage('gallery', this)"><i class="ph-bold ph-image"></i></div>
        <div class="nav-item" onclick="switchPage('wishes', this)"><i class="ph-bold ph-chat-circle-text"></i></div>
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
        if(audio) audio.play().catch(e => console.log("Audio autplay blocked"));
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
        if(target.classList.contains('scrollable') || pageId === 'home') target.scrollTop = 0;

        document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }

    function copyText(id) {
        navigator.clipboard.writeText(document.getElementById(id).innerText).then(() => alert('Nomor Rekening Disalin!'));
    }

    const targetDate = new Date("{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('Y-m-d H:i:s') }}").getTime();
    setInterval(() => {
        const now = new Date().getTime();
        const diff = targetDate - now;
        if(diff > 0) {
            const d = Math.floor(diff / (1000 * 60 * 60 * 24));
            const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

            document.getElementById('countdown').innerHTML = `
                <span>${d} Hari</span> <span class="text-xs text-terra">•</span>
                <span>${h} Jam</span> <span class="text-xs text-terra">•</span>
                <span>${m} Menit</span>
            `;
        }
    }, 1000);
</script>
</body>
</html>