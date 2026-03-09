<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 48 48%22><rect width=%2248%22 height=%2248%22 rx=%2212%22 fill=%22%234F46E5%22/><path d=%22M15 13h18v6h-6v17h-6v-17h-6v-6z%22 fill=%22white%22/></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;800&family=Great+Vibes&family=Urbanist:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div id="ornaments-container"></div>

    <div class="fixed inset-0 z-[5] pointer-events-none">
        <div class="absolute inset-4 border border-[#D4AF37]/40 rounded-[20px]"></div>
        <div class="absolute inset-5 border border-[#D4AF37]/10 rounded-[16px]"></div>

        <img src="{{ asset('frame-atas.png') }}" class="absolute top-0 left-0 w-32 md:w-48 opacity-100 z-10" alt="">
        <img src="{{ asset('frame-bawah.png') }}" class="absolute bottom-0 right-0 w-32 md:w-48 opacity-100 z-10" alt="">
    </div>

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-30 animate-pulse"></div>
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-[#D4AF37] rounded-full blur-[150px] opacity-10"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-purple-900 rounded-full blur-[150px] opacity-15"></div>
    </div>

    @if(isset($invitation->content['media']['music']))
    <div class="fixed top-6 right-6 z-[100]">
        <button onclick="toggleMusic()" id="musicBtn" class="w-8 h-8 rounded-full border border-white/20 bg-black/40 backdrop-blur text-[#D4AF37] flex items-center justify-center animate-spin-slow shadow-lg">
            <i class="ph ph-music-notes text-sm"></i>
        </button>
    </div>

    <audio id="bg-music" loop>
        <source src="{{ asset($invitation->content['media']['music']) }}" type="audio/mp3">
    </audio>
    @endif

    <div id="gate" class="gate-overlay flex-col text-center px-6 bg-cover bg-center" style="background-image: url('{{ asset($invitation->content['media']['cover'] ?? '') }}');">
        <div class="absolute inset-0 bg-black/80"></div>
        <div class="relative z-10 space-y-6">
            <p class="font-royal text-xs tracking-[0.4em] text-gray-400 uppercase">The Wedding Of</p>

            <h1 class="font-royal text-6xl md:text-8xl text-[#D4AF37] drop-shadow-lg">
                {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Romeo' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Juliet' }}
            </h1>

            <div class="w-24 h-px bg-white/30 mx-auto"></div>

            <div class="glass-card px-6 py-4 inline-block border border-[#D4AF37]/30">
                <p class="text-[10px] text-gray-400 tracking-widest uppercase mb-1">Kepada Yth.</p>
                <h3 class="font-royal text-xl md:text-2xl text-white font-bold tracking-wider capitalize">
                    {{ isset($guest) ? $guest->name : 'Tamu Undangan' }}
                </h3>
            </div>

            <br>

            <button onclick="openInvitation()" class="px-8 py-3 rounded-full border border-[#D4AF37] text-[#D4AF37] hover:bg-[#D4AF37] hover:text-black transition duration-500 text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 mx-auto group">
                <i class="ph ph-envelope-open group-hover:animate-bounce"></i> Buka Undangan
            </button>
        </div>
    </div>

    <section id="home" class="page-section active flex flex-col justify-center items-center text-center px-6">
        <div class="glass p-2 rounded-[3rem] mb-6 w-52 h-72 relative group hover:scale-105 transition duration-700">
            <img src="{{ asset($invitation->content['media']['cover'] ?? '') }}" class="w-full h-full object-cover rounded-[2.5rem] brightness-90 group-hover:brightness-100 transition duration-700">
            <div class="absolute inset-0 border border-white/10 rounded-[3rem] scale-110 pointer-events-none"></div>
        </div>

        <p class="font-script text-2xl text-[#D4AF37] mb-2">We Are Getting Married</p>
        <h1 class="font-royal text-5xl md:text-7xl text-white mb-2 drop-shadow-2xl">
            {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Romeo' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Juliet' }}
        </h1>

        <div class="flex items-center gap-4 text-gray-400 text-xs tracking-[0.2em] uppercase mt-2">
            <span>{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l') }}</span>
            <div class="w-1 h-1 bg-[#D4AF37] rounded-full"></div>
            <span>{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('d F Y') }}</span>
        </div>
    </section>

    <section id="mempelai" class="page-section scrollable px-6">
        <div class="max-w-4xl mx-auto text-center pb-8">
            <h2 class="font-royal text-3xl text-[#D4AF37] mb-2">The Couple</h2>
            <p class="text-[10px] uppercase tracking-widest text-gray-500 mb-8">Ar-Rum Ayat 21</p>

            <div class="flex flex-col md:flex-row gap-6 justify-center items-center mt-4">
                <div class="glass-card p-6 w-full max-w-xs relative overflow-hidden group">
                    <div class="absolute inset-0 bg-[#D4AF37]/5 transform scale-x-0 group-hover:scale-x-100 transition origin-left duration-500"></div>
                    <img src="{{ asset($invitation->content['mempelai']['pria']['foto'] ?? 'https://via.placeholder.com/150') }}" class="w-28 h-28 mx-auto rounded-full border border-[#D4AF37] p-1 mb-4 object-cover relative z-10">
                    <h3 class="font-royal text-2xl text-white relative z-10">{{ $invitation->content['mempelai']['pria']['nama'] ?? 'Mempelai Pria' }}</h3>
                    <p class="text-[10px] uppercase tracking-widest text-[#D4AF37] mt-1 relative z-10">The Groom</p>
                    <p class="text-xs text-gray-300 mt-3 relative z-10">Putra dari<br>{{ $invitation->content['mempelai']['pria']['ayah'] ?? '...' }} & {{ $invitation->content['mempelai']['pria']['ibu'] ?? '...' }}</p>

                    @if(!empty($invitation->content['mempelai']['pria']['instagram']))
                    <a href="https://instagram.com/{{ $invitation->content['mempelai']['pria']['instagram'] }}" target="_blank" class="relative z-10 inline-block mt-4 text-[#D4AF37] hover:text-white"><i class="ph ph-instagram-logo text-xl"></i></a>
                    @endif
                </div>

                <div class="text-3xl font-script text-[#D4AF37] opacity-80">&</div>

                <div class="glass-card p-6 w-full max-w-xs relative overflow-hidden group">
                    <div class="absolute inset-0 bg-[#D4AF37]/5 transform scale-x-0 group-hover:scale-x-100 transition origin-right duration-500"></div>
                    <img src="{{ asset($invitation->content['mempelai']['wanita']['foto'] ?? 'https://via.placeholder.com/150') }}" class="w-28 h-28 mx-auto rounded-full border border-[#D4AF37] p-1 mb-4 object-cover relative z-10">
                    <h3 class="font-royal text-2xl text-white relative z-10">{{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Mempelai Wanita' }}</h3>
                    <p class="text-[10px] uppercase tracking-widest text-[#D4AF37] mt-1 relative z-10">The Bride</p>
                    <p class="text-xs text-gray-300 mt-3 relative z-10">Putri dari<br>{{ $invitation->content['mempelai']['wanita']['ayah'] ?? '...' }} & {{ $invitation->content['mempelai']['wanita']['ibu'] ?? '...' }}</p>

                    @if(!empty($invitation->content['mempelai']['wanita']['instagram']))
                    <a href="https://instagram.com/{{ $invitation->content['mempelai']['wanita']['instagram'] }}" target="_blank" class="relative z-10 inline-block mt-4 text-[#D4AF37] hover:text-white"><i class="ph ph-instagram-logo text-xl"></i></a>
                    @endif
                </div>
            </div>

            <p class="font-script text-lg text-gray-500 mt-12">"{{ $invitation->content['quote'] ?? 'Mohon doa restu...' }}"</p>
        </div>
    </section>

    <section id="story" class="page-section scrollable px-6">
        <div class="max-w-3xl mx-auto pb-8">
            <h2 class="font-royal text-3xl text-center text-[#D4AF37] mb-12">Our Journey</h2>
            <div class="relative">
                <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-transparent via-[#D4AF37]/50 to-transparent"></div>

                @if(isset($invitation->content['love_stories']) && is_array($invitation->content['love_stories']))
                    @foreach($invitation->content['love_stories'] as $index => $story)
                    @if(!empty($story['title'])) <div class="relative flex flex-col md:flex-row items-center mb-10">
                            <div class="{{ $index % 2 == 0 ? 'md:w-1/2 md:pr-10 pl-12 md:pl-0 md:text-right' : 'md:w-1/2 md:pl-10 pl-12 md:order-2' }} w-full">
                                <div class="glass-card p-5 border-l-2 border-l-[#D4AF37] {{ $index % 2 == 0 ? 'md:border-l-0 md:border-r-2 md:border-r-[#D4AF37]' : '' }}">
                                    <span class="text-[#D4AF37] font-bold text-xs tracking-widest uppercase">{{ $story['year'] ?? '' }}</span>
                                    <h3 class="font-royal text-lg mt-1 text-white">{{ $story['title'] ?? '' }}</h3>
                                    <p class="text-xs text-gray-300 mt-2 leading-relaxed">"{{ $story['story'] ?? '' }}"</p>
                                </div>
                            </div>
                            <div class="absolute left-4 md:left-1/2 w-2 h-2 bg-[#D4AF37] rounded-full transform -translate-x-[3px] shadow-[0_0_10px_#D4AF37]"></div>
                        </div>
                    @endif
                    @endforeach
                @endif
            </div>
             <p class="font-script text-lg text-center text-gray-500 mt-12">"Every love story is beautiful, but ours is my favorite."</p>
        </div>
    </section>

    <section id="event" class="page-section scrollable px-6">
        <div class="max-w-3xl mx-auto text-center pb-8">
            <h2 class="font-royal text-3xl text-[#D4AF37] mb-2">Save The Date</h2>
            <p class="font-script text-2xl text-white mb-8">
                {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
            </p>

            <div class="flex justify-center gap-3 mb-10">
                <div class="glass-card p-3 w-16"><span id="days" class="block text-xl font-bold text-[#D4AF37]">00</span><span class="text-[9px] uppercase tracking-widest text-gray-400">Hari</span></div>
                <div class="glass-card p-3 w-16"><span id="hours" class="block text-xl font-bold text-[#D4AF37]">00</span><span class="text-[9px] uppercase tracking-widest text-gray-400">Jam</span></div>
                <div class="glass-card p-3 w-16"><span id="minutes" class="block text-xl font-bold text-[#D4AF37]">00</span><span class="text-[9px] uppercase tracking-widest text-gray-400">Menit</span></div>
                <div class="glass-card p-3 w-16"><span id="seconds" class="block text-xl font-bold text-[#D4AF37]">00</span><span class="text-[9px] uppercase tracking-widest text-gray-400">Detik</span></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="glass-card p-6 border-l-4 border-l-[#D4AF37] text-left">
                    <h3 class="font-royal text-lg text-white">{{ $invitation->content['acara']['akad']['judul'] ?? 'Akad Nikah' }}</h3>
                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('H:i') }} WIB - Selesai</p>
                    <p class="text-xs text-gray-300 mt-2 font-bold">{{ $invitation->content['acara']['akad']['tempat'] ?? 'Lokasi Akad' }}</p>
                    <p class="text-[10px] text-gray-500 mt-1">{{ $invitation->content['acara']['akad']['alamat'] ?? '' }}</p>
                    @php
                        $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                        $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                        $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
                    @endphp
                    @if($akadL1)<p class="text-[10px] text-gray-500 mt-0">{{ $akadL1 }}</p>@endif
                    @if($akadL2)<p class="text-[10px] text-gray-500 mt-0 mb-1">{{ $akadL2 }}</p>@endif
                    @if(!empty($invitation->content['acara']['akad']['maps']))
                    <a href="{{ $invitation->content['acara']['akad']['maps'] }}" target="_blank" class="inline-flex items-center gap-1 mt-3 text-[#D4AF37] text-[10px] uppercase tracking-widest hover:text-white transition"><i class="ph ph-map-pin"></i> Google Maps</a>
                    @endif
                </div>

                <div class="glass-card p-6 border-l-4 border-l-[#D4AF37] text-left">
                    <h3 class="font-royal text-lg text-white">{{ $invitation->content['acara']['resepsi']['judul'] ?? 'Resepsi' }}</h3>
                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->format('H:i') }} WIB - Selesai</p>
                    <p class="text-xs text-gray-300 mt-2 font-bold">{{ $invitation->content['acara']['resepsi']['tempat'] ?? 'Lokasi Resepsi' }}</p>
                    <p class="text-[10px] text-gray-500 mt-1">{{ $invitation->content['acara']['resepsi']['alamat'] ?? '' }}</p>
                    @php
                        $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                        $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                        $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
                    @endphp
                    @if($resepsiL1)<p class="text-[10px] text-gray-500 mt-0">{{ $resepsiL1 }}</p>@endif
                    @if($resepsiL2)<p class="text-[10px] text-gray-500 mt-0 mb-1">{{ $resepsiL2 }}</p>@endif
                    @if(!empty($invitation->content['acara']['resepsi']['maps']))
                    <a href="{{ $invitation->content['acara']['resepsi']['maps'] }}" target="_blank" class="inline-flex items-center gap-1 mt-3 text-[#D4AF37] text-[10px] uppercase tracking-widest hover:text-white transition"><i class="ph ph-map-pin"></i> Google Maps</a>
                    @endif
                </div>
            </div>

            <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Wedding+{{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Groom' }}+%26+{{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Bride' }}" target="_blank"
               class="bg-[#D4AF37] text-black px-6 py-3 rounded-full font-bold text-[10px] uppercase tracking-[0.2em] hover:bg-white transition inline-flex items-center gap-2 shadow-[0_0_15px_#D4AF37]">
               <i class="ph ph-calendar-plus"></i> Simpan di Kalender
            </a>
        </div>
    </section>

    <section id="gallery" class="page-section scrollable px-4">
        <div class="max-w-5xl mx-auto text-center pb-8">
            <h2 class="font-royal text-3xl text-[#D4AF37] mb-2">Gallery</h2>
            <p class="text-[10px] uppercase tracking-widest text-gray-500 mb-8">Memories Captured in Time</p>

            <div class="columns-2 md:columns-3 gap-3 space-y-3">
                @if(isset($invitation->content['media']['gallery']) && is_array($invitation->content['media']['gallery']))
                    @foreach($invitation->content['media']['gallery'] as $photo)
                    <div class="glass p-1 rounded-xl break-inside-avoid hover:scale-[1.02] transition duration-500">
                        <img src="{{ asset($photo) }}" class="w-full rounded-lg" loading="lazy">
                    </div>
                    @endforeach
                @endif
            </div>
            <p class="font-script text-lg text-center text-gray-500 mt-12">"Collecting moments, not things."</p>
        </div>
    </section>

    <section id="gift" class="page-section scrollable px-6">
        <div class="max-w-xl mx-auto text-center pb-8">
            <h2 class="font-royal text-3xl text-[#D4AF37] mb-4">Wedding Gift</h2>
            <p class="text-xs text-gray-400 mb-8 max-w-xs mx-auto">Doa restu Anda merupakan karunia terindah. Namun jika ingin memberikan tanda kasih:</p>

            <div class="space-y-4 mb-8">
                @if(!empty($invitation->content['amplop']['bank_name']))
                <div class="glass-card p-5 flex items-center justify-between text-left relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-24 h-24 bg-[#D4AF37] opacity-10 rounded-full blur-xl pointer-events-none"></div>

                    <div class="relative z-10">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Bank {{ $invitation->content['amplop']['bank_name'] }}</p>
                        <p id="rek1" class="font-royal text-xl text-white tracking-widest">{{ $invitation->content['amplop']['account_number'] ?? '0000' }}</p>
                        <p class="text-[10px] text-gray-500 mt-1">a.n {{ $invitation->content['amplop']['account_holder'] ?? '' }}</p>
                    </div>

                    <button onclick="copyText('rek1')" class="relative z-10 bg-[#222] hover:bg-[#D4AF37] hover:text-black w-8 h-8 rounded-full flex items-center justify-center transition text-[#D4AF37] active:scale-90">
                        <i class="ph ph-copy text-sm"></i>
                    </button>
                </div>
                @endif
            </div>

            <div class="glass-card p-6 text-center border-dashed border border-gray-700">
                <i class="ph ph-gift text-2xl text-[#D4AF37] mb-2"></i>
                <p class="text-sm font-bold text-white">Kirim Kado Fisik</p>
                <p class="text-xs text-gray-400 mt-1 mb-4">{{ $invitation->content['amplop']['alamat_kado'] ?? 'Alamat belum diisi' }}</p>

                @if(!empty($invitation->content['amplop']['maps_kado']))
                <a href="{{ $invitation->content['amplop']['maps_kado'] }}" target="_blank" class="bg-white/5 border border-white/10 text-white px-4 py-2 rounded-full text-[10px] uppercase tracking-widest hover:bg-[#D4AF37] hover:text-black hover:border-[#D4AF37] transition">
                    Lihat Alamat
                </a>
                @endif
            </div>
             <p class="font-script text-lg text-center text-gray-500 mt-12">"Generosity is the best investment."</p>
        </div>
    </section>

    <section id="rsvp" class="page-section scrollable px-6">
        <div class="max-w-xl mx-auto pb-8">
            <h2 class="font-royal text-3xl text-center text-[#D4AF37] mb-8">Wishes</h2>

            @if(session('success'))
                <div class="glass-card bg-green-900/30 border-green-500/30 text-green-200 px-4 py-3 rounded-lg mb-6 text-center text-xs">
                    <i class="ph ph-check-circle text-lg mb-1 block"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('kirim.ucapan') }}" method="POST" class="glass-card p-6 space-y-4 mb-8">
                @csrf
                <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">

                <input type="text" name="nama" required placeholder="Nama Anda" class="w-full bg-black/40 border border-white/10 rounded-lg p-3 text-white text-xs focus:border-[#D4AF37] outline-none">

                <select name="kehadiran" class="w-full bg-black/40 border border-white/10 rounded-lg p-3 text-white focus:border-[#D4AF37] outline-none text-xs" required>
                    <option value="" disabled selected class="text-black">Konfirmasi Kehadiran</option>
                    <option value="hadir" class="text-black">Hadir</option>
                    <option value="tidak_hadir" class="text-black">Tidak Hadir</option>
                    <option value="ragu" class="text-black">Ragu-ragu</option>
                </select>
                <textarea name="ucapan" rows="3" required placeholder="Tulis doa & ucapan..." class="w-full bg-black/40 border border-white/10 rounded-lg p-3 text-white text-xs focus:border-[#D4AF37] outline-none"></textarea>

                <button type="submit" class="w-full bg-[#D4AF37] text-black font-bold py-3 rounded-lg hover:bg-white transition uppercase text-[10px] tracking-widest shadow-[0_0_15px_#D4AF37]/50">
                    Kirim Ucapan
                </button>
            </form>

            <div class="space-y-3 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                @if($invitation->comments->count() > 0)
                    @foreach($invitation->comments->sortByDesc('created_at') as $comment)
                        <div class="glass-card p-3 flex gap-3 items-start animate-fade-in-up">
                            <div class="w-8 h-8 rounded-full
                                {{ $comment->rsvp_status == 'hadir' ? 'bg-green-600' : ($comment->rsvp_status == 'tidak_hadir' ? 'bg-red-600' : 'bg-gray-600') }}
                                text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-lg">
                                {{ substr($comment->name, 0, 1) }}
                            </div>

                            <div class="text-left w-full">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-[#F3E5AB] text-xs">
                                        {{ $comment->name }}
                                    </h4>

                                    <span class="text-[9px] text-gray-400 bg-black/30 px-2 py-0.5 rounded-full">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                @if($comment->rsvp_status == 'hadir')
                                    <span class="text-[9px] text-green-400 flex items-center gap-1 mb-1">
                                        <i class="ph ph-check-circle"></i> Hadir
                                    </span>
                                @elseif($comment->rsvp_status == 'tidak_hadir')
                                    <span class="text-[9px] text-red-400 flex items-center gap-1 mb-1">
                                        <i class="ph ph-x-circle"></i> Tidak Hadir
                                    </span>
                                @else
                                    <span class="text-[9px] text-yellow-400 flex items-center gap-1 mb-1">
                                        <i class="ph ph-question"></i> Ragu-ragu
                                    </span>
                                @endif

                                <p class="text-xs text-gray-300 italic">
                                    "{{ $comment->comment }}"
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4 glass-card border-dashed">
                        <p class="text-xs text-gray-500 italic">
                            Belum ada ucapan. Jadilah yang pertama!
                        </p>
                    </div>
                @endif
            </div>
             <p class="font-script text-lg text-center text-gray-500 mt-12">"Your presence is our present."</p>
        </div>
    </section>

    <div class="nav-wrapper" id="navWrapper">
        <div class="nav-items">
            <button class="nav-btn active" onclick="switchPage('home')" data-label="Home"><i class="ph ph-house-line text-sm"></i></button>
            <button class="nav-btn" onclick="switchPage('mempelai')" data-label="Couple"><i class="ph ph-heart text-sm"></i></button>
            <button class="nav-btn" onclick="switchPage('story')" data-label="Story"><i class="ph ph-book-bookmark text-sm"></i></button>
            <button class="nav-btn" onclick="switchPage('event')" data-label="Event"><i class="ph ph-calendar-check text-sm"></i></button>
            <button class="nav-btn" onclick="switchPage('gallery')" data-label="Gallery"><i class="ph ph-image text-sm"></i></button>
            <button class="nav-btn" onclick="switchPage('gift')" data-label="Gift"><i class="ph ph-gift text-sm"></i></button>
            <button class="nav-btn" onclick="switchPage('rsvp')" data-label="Wishes"><i class="ph ph-chat-circle-text text-sm"></i></button>
        </div>
        <button class="nav-trigger" onclick="toggleNav()"><i class="ph ph-plus font-bold"></i></button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const container = document.getElementById('ornaments-container');
            if(container) {
                for (let i = 0; i < 20; i++) {
                    const p = document.createElement('div');
                    p.classList.add('firefly');
                    p.style.left = Math.random() * 100 + 'vw';
                    p.style.top = Math.random() * 100 + 'vh';
                    p.style.width = Math.random() * 3 + 2 + 'px';
                    p.style.height = p.style.width;
                    p.style.animationDuration = Math.random() * 10 + 10 + 's';
                    p.style.animationDelay = Math.random() * 5 + 's';
                    container.appendChild(p);
                }
            }
        });

        function openInvitation() {
            document.getElementById('gate').classList.add('open');
            const audio = document.getElementById('bg-music');
            if(audio) {
                 audio.play().catch(error => console.log("Autoplay blocked"));
            }
        }

        function toggleMusic() {
            const audio = document.getElementById('bg-music');
            const btn = document.getElementById('musicBtn');
            if (audio.paused) {
                audio.play();
                btn.classList.add('animate-spin-slow');
                btn.innerHTML = '<i class="ph ph-music-notes text-sm"></i>';
            } else {
                audio.pause();
                btn.classList.remove('animate-spin-slow');
                btn.innerHTML = '<i class="ph ph-pause text-sm"></i>';
            }
        }

        function copyText(id) {
            navigator.clipboard.writeText(document.getElementById(id).innerText).then(() => alert('Nomor Rekening Disalin!'));
        }

        function toggleNav() {
            const wrapper = document.getElementById('navWrapper');
            const icon = wrapper.querySelector('.nav-trigger i');
            wrapper.classList.toggle('open');
            icon.classList.toggle('ph-plus', !wrapper.classList.contains('open'));
            icon.classList.toggle('ph-x', wrapper.classList.contains('open'));
        }

        function switchPage(pageId) {
            document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));
            const target = document.getElementById(pageId);
            target.classList.add('active');
            if(target.classList.contains('scrollable')) target.scrollTop = 0;
            document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`button[onclick="switchPage('${pageId}')"]`).classList.add('active');
            toggleNav();
        }

        const weddingDateStr = "{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('Y-m-d H:i:s') }}";
        const weddingDate = new Date(weddingDateStr).getTime();

        setInterval(() => {
            const now = new Date().getTime();
            const diff = weddingDate - now;

            if (diff < 0) {
                 document.getElementById("days").innerText = "00";
                 document.getElementById("hours").innerText = "00";
                 document.getElementById("minutes").innerText = "00";
                 document.getElementById("seconds").innerText = "00";
                 return;
            }

            document.getElementById("days").innerText = Math.floor(diff / (1000 * 60 * 60 * 24));
            document.getElementById("hours").innerText = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            document.getElementById("minutes").innerText = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            document.getElementById("seconds").innerText = Math.floor((diff % (1000 * 60)) / 1000);
        }, 1000);
    </script>
</body>
</html>