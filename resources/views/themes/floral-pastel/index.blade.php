<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 48 48%22><rect width=%2248%22 height=%2248%22 rx=%2212%22 fill=%22%234F46E5%22/><path d=%22M15 13h18v6h-6v17h-6v-17h-6v-6z%22 fill=%22white%22/></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&family=Pinyon+Script&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite(['resources/css/floral-pastel.css'])

    <style>

        :root { --primary: #D4A373; --secondary: #A98467; --bg-color: #FAFAFA; --font-heading: 'Pinyon Script', cursive; }
        body { font-family: 'Jost', sans-serif; background: var(--bg-color); margin: 0; color: #555; }
        .mobile-container { max-width: 480px; margin: 0 auto; background: white; min-height: 100vh; position: relative; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .hero { height: 100vh; background-size: cover; background-position: center; position: relative; display: flex; align-items: center; justify-content: center; text-align: center; color: white; }
        .hero::before { content:''; position: absolute; inset: 0; background: rgba(0,0,0,0.4); }
        .hero-box { position: relative; z-index: 2; text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
        .hero-names { font-family: var(--font-heading); font-size: 3.5rem; margin: 10px 0; line-height: 1.2; }
        .btn-open { background: var(--primary); color: white; border: none; padding: 12px 30px; border-radius: 50px; font-size: 1rem; cursor: pointer; transition: 0.3s; margin-top: 20px; }
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border-radius: 20px; padding: 30px; margin: 20px; border: 1px solid white; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .section-title { font-family: var(--font-heading); font-size: 2.5rem; color: var(--secondary); text-align: center; margin-bottom: 20px; }
        .couple-img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 5px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .form-control { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-submit { background: var(--secondary); color: white; border: none; padding: 10px 20px; border-radius: 5px; width: 100%; cursor: pointer; }
        #heroCover { transition: transform 0.8s ease-in-out; position: fixed; inset: 0; z-index: 9999; }
        #heroCover.open { transform: translateY(-100%); }
        .music-box { position: fixed; bottom: 20px; right: 20px; width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; z-index: 100; box-shadow: 0 2px 10px rgba(0,0,0,0.2); cursor: pointer; }
        .spin { animation: spin 4s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .countdown-box { display: flex; justify-content: center; gap: 15px; margin-bottom: 20px; }
        .timer-item { background: var(--primary); color: white; padding: 10px; border-radius: 10px; min-width: 60px; }
        .timer-item span { font-size: 1.2rem; font-weight: bold; display: block; }
        .timer-item small { font-size: 0.7rem; text-transform: uppercase; }
        .gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .gallery-item { width: 100%; height: 150px; object-fit: cover; border-radius: 10px; }
    </style>
</head>
<body style="overflow: hidden;">

    @php

        function getImgUrl($path) {
            if (!$path) return 'https://via.placeholder.com/150';
            return \Illuminate\Support\Str::startsWith($path, 'http') ? $path : asset($path);
        }
    @endphp

    <div class="mobile-container">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div id="petals-container" style="position: fixed; inset: 0; pointer-events: none; z-index: 0;"></div>

        @if(isset($invitation->content['media']['music']))
        <div class="music-box" onclick="toggleMusic()" id="musicBtn" style="display:none;">
            <i class="ph-fill ph-music-note"></i>
        </div>
        <audio id="bgMusic" loop>
            <source src="{{ getImgUrl($invitation->content['media']['music']) }}" type="audio/mpeg">
        </audio>
        @endif

        <section class="hero" id="heroCover" style="background-image: url('{{ getImgUrl($invitation->content['media']['cover'] ?? '') }}');">
            <div class="hero-box">
                <p style="text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem;">The Wedding Of</p>
                <h1 class="hero-names">
                    {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }}
                    <br> & <br>
                    {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                </h1>
                <p style="margin-bottom: 20px;">
                    {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
                </p>
                <div style="background: rgba(255,255,255,0.6); backdrop-filter: blur(10px); padding: 8px 20px; border-radius: 50px; display:inline-block;">
                    <small style="color: var(--secondary);">Kepada Yth.</small>
                    <div style="font-weight: bold; font-size: 1.1rem; color: var(--secondary);">{{ isset($guest) ? $guest->name : 'Tamu Undangan' }}</div>
                </div>
                <br>
                <button class="btn-open" onclick="openInvitation()">Buka Undangan</button>
            </div>
        </section>

        <div id="mainContent">

            <div class="hero-inside" style="position: relative; text-align: center; color: white; padding: 50px 20px; background-image: url('{{ getImgUrl($invitation->content['media']['cover'] ?? '') }}'); background-size: cover; background-position: center;">
                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.5);"></div>
                <div style="position: relative; z-index: 2;">
                    <h2 style="font-family: var(--font-heading); font-size: 3rem; margin:0; line-height: 1;">We Are Getting Married!</h2>
                    <p style="margin-top: 10px;">Mohon doa restu dari Bapak/Ibu/Saudara/i</p>
                </div>
            </div>

            <section class="section" style="padding-top: 0;">
                <div class="glass-card">
                    <i class="ph-duotone ph-flower-lotus" style="font-size: 2.5rem; color: var(--primary);"></i>
                    <p style="margin-top: 15px; font-style: italic;">"{{ $invitation->content['quote'] ?? 'Tanpa mengurangi rasa hormat...' }}"</p>
                </div>
            </section>

            <section class="section" style="padding-top: 0;">
                <h2 class="section-title">Mempelai</h2>
                <div class="glass-card">
                    <div style="margin-bottom: 30px;">
                        <img src="{{ getImgUrl($invitation->content['mempelai']['pria']['foto'] ?? '') }}" class="couple-img">
                        <h3 style="font-size: 2rem; color: var(--primary); font-family: var(--font-heading);">{{ $invitation->content['mempelai']['pria']['nama'] ?? 'Mempelai Pria' }}</h3>
                        <p style="font-size: 0.9rem;">Putra Bpk {{ $invitation->content['mempelai']['pria']['ayah'] ?? '...' }} & Ibu {{ $invitation->content['mempelai']['pria']['ibu'] ?? '...' }}</p>
                        @if(!empty($invitation->content['mempelai']['pria']['instagram']))
                        <a href="https://instagram.com/{{ $invitation->content['mempelai']['pria']['instagram'] }}" target="_blank" style="color: var(--secondary); text-decoration: none; display: block; margin-top: 5px;">
                            <i class="ph-logo ph-instagram-logo"></i> @ {{ $invitation->content['mempelai']['pria']['instagram'] }}
                        </a>
                        @endif
                    </div>

                    <div style="font-family: var(--font-heading); font-size: 2.5rem; color: #ccc;">&</div>

                    <div style="margin-top: 30px;">
                        <img src="{{ getImgUrl($invitation->content['mempelai']['wanita']['foto'] ?? '') }}" class="couple-img">
                        <h3 style="font-size: 2rem; color: var(--primary); font-family: var(--font-heading);">{{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Mempelai Wanita' }}</h3>
                        <p style="font-size: 0.9rem;">Putri Bpk {{ $invitation->content['mempelai']['wanita']['ayah'] ?? '...' }} & Ibu {{ $invitation->content['mempelai']['wanita']['ibu'] ?? '...' }}</p>
                        @if(!empty($invitation->content['mempelai']['wanita']['instagram']))
                        <a href="https://instagram.com/{{ $invitation->content['mempelai']['wanita']['instagram'] }}" target="_blank" style="color: var(--secondary); text-decoration: none; display: block; margin-top: 5px;">
                            <i class="ph-logo ph-instagram-logo"></i> @ {{ $invitation->content['mempelai']['wanita']['instagram'] }}
                        </a>
                        @endif
                    </div>
                </div>
            </section>

            @if(isset($invitation->content['love_stories']) && is_array($invitation->content['love_stories']))
            <section class="section" style="padding-top: 0;" id="story">
                <h2 class="section-title">Love Story</h2>
                <div class="glass-card" style="text-align: left;">
                    <div class="timeline">
                        @foreach($invitation->content['love_stories'] as $story)
                        @if(!empty($story['title']))
                        <div class="timeline-item" style="margin-bottom: 20px; border-left: 2px solid var(--primary); padding-left: 15px;">
                            <span class="story-year" style="font-weight: bold; color: var(--primary);">{{ $story['year'] ?? '' }}</span>
                            <h4 class="story-title" style="margin: 5px 0;">{{ $story['title'] ?? '' }}</h4>
                            <p style="font-size: 0.9rem;">{{ $story['story'] ?? '' }}</p>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            <section class="section" style="padding-top: 0;">
                <h2 class="section-title">Save The Date</h2>
                <div class="glass-card">

                    <div class="countdown-box" id="countdown">
                        <div class="timer-item"><span id="days">00</span><small>HARI</small></div>
                        <div class="timer-item"><span id="hours">00</span><small>JAM</small></div>
                        <div class="timer-item"><span id="minutes">00</span><small>MENIT</small></div>
                        <div class="timer-item"><span id="seconds">00</span><small>DETIK</small></div>
                    </div>

                    <div class="event-item" style="margin-bottom: 30px;">
                        <h3 style="color: var(--primary);">{{ $invitation->content['acara']['akad']['judul'] ?? 'Akad Nikah' }}</h3>
                        <p style="font-weight: 500; margin: 5px 0; color: #333;">
                            {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
                        </p>
                        <p>{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('H:i') }} WIB - Selesai</p>
                        <p style="margin-top: 5px; font-size: 0.9rem;"><strong>{{ $invitation->content['acara']['akad']['tempat'] ?? '' }}</strong></p>
                        @php
                            $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                            $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                            $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
                        @endphp
                        @if($akadL1)<p style="font-size: 0.8rem; color: #777; margin: 2px 0;">{{ $akadL1 }}</p>@endif
                        @if($akadL2)<p style="font-size: 0.8rem; color: #777; margin: 2px 0;">{{ $akadL2 }}</p>@endif
                        @if(!empty($invitation->content['acara']['akad']['maps']))
                            <a href="{{ $invitation->content['acara']['akad']['maps'] }}" target="_blank" style="position:relative; z-index:50; display:inline-block; margin-top:10px; color:white; background:var(--secondary); padding:5px 15px; border-radius:15px; text-decoration:none; font-size:0.8rem;">Google Maps</a>
                        @endif
                    </div>

                    <div class="event-item">
                        <h3 style="color: var(--primary);">{{ $invitation->content['acara']['resepsi']['judul'] ?? 'Resepsi' }}</h3>
                        <p style="font-weight: 500; margin: 5px 0; color: #333;">
                            {{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
                        </p>
                        <p>{{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->format('H:i') }} WIB - Selesai</p>
                        <p style="margin-top: 5px; font-size: 0.9rem;"><strong>{{ $invitation->content['acara']['resepsi']['tempat'] ?? '' }}</strong></p>
                        @php
                            $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                            $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                            $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
                        @endphp
                        @if($resepsiL1)<p style="font-size: 0.8rem; color: #777; margin: 2px 0;">{{ $resepsiL1 }}</p>@endif
                        @if($resepsiL2)<p style="font-size: 0.8rem; color: #777; margin: 2px 0;">{{ $resepsiL2 }}</p>@endif
                        @if(!empty($invitation->content['acara']['resepsi']['maps']))
                            <a href="{{ $invitation->content['acara']['resepsi']['maps'] }}" target="_blank" style="position:relative; z-index:50; display:inline-block; margin-top:10px; color:white; background:var(--secondary); padding:5px 15px; border-radius:15px; text-decoration:none; font-size:0.8rem;">Google Maps</a>
                        @endif
                    </div>
                </div>
            </section>

            @if(isset($invitation->content['media']['gallery']) && is_array($invitation->content['media']['gallery']))
            <section class="section" style="padding-top: 0;">
                <h2 class="section-title">Our Moments</h2>
                <div class="glass-card">
                    <div class="gallery-grid">
                        @foreach($invitation->content['media']['gallery'] as $photo)
                            <img src="{{ getImgUrl($photo) }}" class="gallery-item">
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            <section class="section" style="padding-top: 0;">
                <h2 class="section-title">Wedding Gift</h2>
                <div class="glass-card">
                    <p style="margin-bottom: 20px;">Doa restu Anda merupakan karunia yang sangat berarti bagi kami.</p>

                    @if(!empty($invitation->content['amplop']['bank_name']))
                    <div class="bank-container">
                        <h3 style="margin: 0;">{{ $invitation->content['amplop']['bank_name'] }}</h3>
                        <p style="font-size: 1.5rem; font-weight: bold; letter-spacing: 1px; margin: 10px 0;" id="rek1">
                            {{ $invitation->content['amplop']['account_number'] ?? '0000000' }}
                        </p>
                        <p>a.n {{ $invitation->content['amplop']['account_holder'] ?? 'Nama' }}</p>
                        <button onclick="copyToClipboard('rek1')" style="margin-top: 15px; background: white; border: none; padding: 8px 20px; border-radius: 20px; cursor: pointer; color: var(--secondary); font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            Salin Nomor
                        </button>
                    </div>
                    @endif

                    <div style="margin-top: 25px;">
                        <h4 style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Kirim Kado</h4>
                        <p style="margin: 5px 0; font-size: 0.9rem;">{{ $invitation->content['amplop']['alamat_kado'] ?? '-' }}</p>

                        @if(!empty($invitation->content['amplop']['maps_kado']))
                        <a href="{{ $invitation->content['amplop']['maps_kado'] }}" target="_blank" style="display:inline-block; margin-top:5px; font-size:0.8rem; color:var(--primary);">
                            Lihat Lokasi Kado
                        </a>
                        @endif
                    </div>
                </div>
            </section>

            <section class="section" style="padding-bottom: 50px; padding-top: 0;">
                <h2 class="section-title">Kirim Ucapan</h2>
                <div class="glass-card">
                    @if(session('success'))
                        <div style="background: rgba(255,255,255,0.8); color: var(--secondary); padding: 10px; border-radius: 10px; margin-bottom: 20px; text-align:center;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('kirim.ucapan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">

                        <input type="text" name="nama" class="form-control" placeholder="Nama Anda" required>
                        <select name="kehadiran" class="form-control" required>
                            <option value="hadir">Hadir</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                            <option value="ragu">Ragu-ragu</option>
                        </select>
                        <textarea name="ucapan" class="form-control" rows="3" placeholder="Tulis doa restu..." required></textarea>
                        <button type="submit" class="btn-submit">Kirim</button>
                    </form>
                    <div style="margin-top: 30px; text-align: left; max-height: 300px; overflow-y: auto;">
                        @if($invitation->comments->count() > 0)
                            @foreach($invitation->comments->sortByDesc('created_at') as $comment)
                                <div style="border-bottom: 1px solid rgba(0,0,0,0.05); padding: 15px 0;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <strong style="color: var(--secondary);">
                                            {{ $comment->name }}
                                        </strong>

                                        <span style="font-size: 0.7rem; background: var(--bg-color); padding: 2px 8px; border-radius: 10px;">
                                            {{ ucfirst(str_replace('_', ' ', $comment->rsvp_status)) }}
                                        </span>
                                    </div>

                                    <p style="margin-top: 5px; font-size: 0.9rem;">
                                        {{ $comment->comment }}
                                    </p>

                                    <small style="color: #aaa;">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            @endforeach
                        @else
                            <p style="text-align: center; color: #999;">Belum ada ucapan.</p>
                        @endif
                    </div>
                </div>
            </section>

            <footer style="padding: 20px; text-align: center; font-size: 0.8rem;">
                <h2 style="font-family: var(--font-heading); margin-bottom: 10px;">
                    {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                </h2>
                <p>Created with Temanten</p>
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            function createPetals() {
                const container = document.getElementById('petals-container');
                if(!container) return;
                for (let i = 0; i < 15; i++) {
                    const petal = document.createElement('div');
                    petal.classList.add('petal');
                    const size = Math.random() * 15 + 10;
                    petal.style.width = `${size}px`; petal.style.height = `${size}px`;
                    petal.style.background = Math.random() > 0.5 ? '#FFD1DC' : '#E6E6FA';
                    petal.style.opacity = '0.7';
                    petal.style.borderRadius = '50% 0 50% 0';
                    petal.style.position = 'absolute';
                    petal.style.left = `${Math.random() * 100}%`;
                    petal.style.top = `-20px`;
                    petal.style.transition = `top ${Math.random() * 5 + 5}s linear, transform ${Math.random() * 5 + 5}s linear`;

                    container.appendChild(petal);

                    setTimeout(() => {
                        petal.style.top = '110vh';
                        petal.style.transform = `rotate(${Math.random() * 360}deg)`;
                    }, 100);

                    setTimeout(() => {
                        petal.style.transition = 'none';
                        petal.style.top = '-20px';
                        setTimeout(() => {
                            petal.style.transition = `top ${Math.random() * 5 + 5}s linear, transform ${Math.random() * 5 + 5}s linear`;
                        }, 100);
                    }, 10000);
                }
            }
            createPetals();

            const audio = document.getElementById('bgMusic');
            const musicBtn = document.getElementById('musicBtn');

            window.openInvitation = function() {
                const cover = document.getElementById('heroCover');
                if(cover) cover.classList.add('open');
                document.body.style.overflow = 'auto';

                if(audio && musicBtn) {
                    musicBtn.style.display = 'flex';
                    audio.play().then(() => {
                        musicBtn.classList.add('spin');
                    }).catch(e => console.log("Audio play blocked"));
                }
            }

            window.toggleMusic = function() {
                if(audio && musicBtn) {
                    if(audio.paused) {
                        audio.play();
                        musicBtn.classList.add('spin');
                    } else {
                        audio.pause();
                        musicBtn.classList.remove('spin');
                    }
                }
            }

            window.copyToClipboard = function(id) {
                const el = document.getElementById(id);
                if(el) {
                    navigator.clipboard.writeText(el.innerText).then(() => alert('Nomor Rekening Disalin!'));
                }
            }

            const targetStr = "{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('Y-m-d H:i:s') }}";
            const targetDate = new Date(targetStr).getTime();

            setInterval(function() {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    const ids = ['days', 'hours', 'minutes', 'seconds'];
                    ids.forEach(id => {
                        const el = document.getElementById(id);
                        if(el) el.innerText = "0";
                    });
                    return;
                }

                const d = Math.floor(distance / (1000 * 60 * 60 * 24));
                const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((distance % (1000 * 60)) / 1000);

                if(document.getElementById("days")) document.getElementById("days").innerText = d;
                if(document.getElementById("hours")) document.getElementById("hours").innerText = h;
                if(document.getElementById("minutes")) document.getElementById("minutes").innerText = m;
                if(document.getElementById("seconds")) document.getElementById("seconds").innerText = s;
            }, 1000);
        });
    </script>
</body>
</html>