<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</title>
    
    <!-- Fonts: Playfair Display for elegant serif, Montserrat for clean sans-serif -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Great+Vibes&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sage': '#8BA295',
                        'sage-light': '#A5B9AD',
                        'sage-dark': '#6B8275',
                        'gold': '#BFA25D',
                        'gold-light': '#D4C5A0',
                        'gold-dark': '#8C773D',
                        'paper': '#FDFBF7',
                        'ink': '#2C3E35',
                    },
                    fontFamily: {
                        'serif': ['"Playfair Display"', 'serif'],
                        'sans': ['Montserrat', 'sans-serif'],
                        'script': ['"Great Vibes"', 'cursive'],
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FDFBF7; color: #2C3E35; }
        
        /* Gold Text Gradient */
        .text-gold-gradient {
            background: linear-gradient(135deg, #D4C5A0 0%, #BFA25D 50%, #8C773D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Gold Border Gradient */
        .border-gold-gradient {
            border-image: linear-gradient(135deg, #BFA25D, #8C773D) 1;
        }

        /* Glassmorphism for light mode */
        .glass-panel {
            background: rgba(253, 251, 247, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(191, 162, 93, 0.3);
            box-shadow: 0 8px 32px 0 rgba(107, 130, 117, 0.1);
            border-radius: 1rem;
        }

        /* Animations */
        @keyframes subtleZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.05); }
        }
        .bg-animate {
            animation: subtleZoom 20s infinite alternate linear;
        }

        @keyframes floatDust {
            0% { transform: translateY(0) translateX(0); opacity: 0; }
            50% { opacity: 0.8; }
            100% { transform: translateY(-100px) translateX(20px); opacity: 0; }
        }
        .gold-dust {
            position: absolute;
            background: radial-gradient(circle, #BFA25D 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            opacity: 0;
            animation: floatDust 8s infinite ease-in;
        }

        /* Reveal on scroll */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile Container Limit */
        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            position: relative;
            min-height: 100vh;
            background-color: #FDFBF7;
            overflow-x: hidden;
            box-shadow: 0 0 50px rgba(107, 130, 117, 0.15);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #FDFBF7; }
        ::-webkit-scrollbar-thumb { background: #BFA25D; border-radius: 10px; }

        /* Cover Overlay */
        #cover-page {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 50;
            transition: transform 1s cubic-bezier(0.77, 0, 0.175, 1);
        }
        #cover-page.open {
            transform: translateY(-100%);
        }
        
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23bfa25d' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Corner Floral decorations */
        .floral-corner {
            background-image: url("https://images.unsplash.com/photo-1541961017774-22349e4a1262?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"); /* Placeholder leaf pattern */
            background-size: cover;
            opacity: 0.15;
            position: absolute;
            width: 200px;
            height: 200px;
            pointer-events: none;
            mix-blend-mode: multiply;
        }
        .floral-tl { top: -50px; left: -50px; transform: rotate(0deg); }
        .floral-br { bottom: -50px; right: -50px; transform: rotate(180deg); }
        .floral-tr { top: -50px; right: -50px; transform: rotate(90deg); }
        .floral-bl { bottom: -50px; left: -50px; transform: rotate(270deg); }

    </style>
</head>
<body class="font-sans antialiased text-ink">

    @php
        $guest = null;
        if (request()->has('to')) {
            $guest = \App\Models\Guest::where('slug', request()->query('to'))->first();
        }
        $guestName = $guest ? $guest->name : (request('to') ? str_replace('-', ' ', preg_replace('/-[a-zA-Z0-9]{4}$/', '', request('to'))) : 'Tamu Kehormatan');
        
        $coverImg = isset($invitation->content['media']['cover']) ? asset($invitation->content['media']['cover']) : 'https://placehold.co/1920x1080/111111/D4AF37/png?text=Wedding+Cover';
    @endphp

    <!-- COVER PAGE -->
    <div id="cover-page" class="w-full flex justify-center bg-sage">
        <div class="mobile-container w-full h-full relative overflow-hidden flex flex-col items-center justify-center text-center">
            
            <!-- Floral Borders -->
            <div class="floral-corner floral-tl"></div>
            <div class="floral-corner floral-br"></div>

            <!-- Background Image -->
            <div class="absolute inset-0 w-full h-full p-6">
                <div class="w-full h-full border-2 border-gold/30 rounded-3xl relative overflow-hidden">
                    <img src="{{ $coverImg }}" class="w-full h-full object-cover bg-animate opacity-60 mix-blend-multiply" alt="Cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-paper via-paper/80 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-b from-paper/40 to-transparent"></div>
                    
                    <!-- Inner Gold Border -->
                    <div class="absolute inset-4 border border-gold/40 rounded-2xl pointer-events-none"></div>
                </div>
            </div>

            <!-- Content -->
            <div class="relative z-10 px-8 w-full flex flex-col h-full py-16">
                <div class="flex-1 flex flex-col justify-center items-center">
                    <div class="w-16 h-16 border border-gold rounded-full flex items-center justify-center mb-6 bg-paper shadow-lg">
                        <span class="font-script text-2xl text-gold">{{ substr($invitation->content['mempelai']['pria']['panggilan'] ?? 'P', 0, 1) }}&{{ substr($invitation->content['mempelai']['wanita']['panggilan'] ?? 'W', 0, 1) }}</span>
                    </div>

                    <p class="text-sage-dark tracking-[0.3em] text-xs uppercase mb-4 font-semibold">The Wedding Of</p>
                    <h1 class="font-serif text-5xl md:text-6xl text-ink mb-2 leading-tight">
                        {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }}
                        <span class="block text-gold font-script text-4xl my-2">&amp;</span>
                        {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                    </h1>
                    
                    <div class="w-16 h-[1px] bg-gold mx-auto my-6"></div>
                    
                    @if(isset($invitation->content['acara']['resepsi']['waktu']))
                        <p class="text-sage-dark font-serif italic text-lg tracking-widest">
                            {{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'])->translatedFormat('d . m . Y') }}
                        </p>
                    @endif
                </div>

                <div class="mt-auto pt-8">
                    <p class="text-xs text-sage-dark uppercase tracking-widest mb-2 font-semibold">Dear,</p>
                    <p class="text-xl font-serif text-ink font-semibold mb-8">{{ $guestName }}</p>
                    
                    <button onclick="openInvitation()" class="inline-flex items-center gap-3 px-8 py-3 bg-gold text-paper hover:bg-gold-dark transition-all duration-500 uppercase tracking-widest text-xs font-bold group rounded-full shadow-lg">
                        <span>Buka Undangan</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </div>
            </div>
            
            <!-- Gold Dust Particles -->
            <div id="particles" class="absolute inset-0 pointer-events-none z-0"></div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <main id="main-content" class="w-full h-0 overflow-hidden flex justify-center bg-black">
        <div class="mobile-container w-full hero-pattern">
            
            <!-- Floating Music Button -->
            @if(isset($invitation->content['media']['music']))
            <button id="music-btn" class="fixed bottom-6 right-6 lg:right-[calc(50%-220px)] z-40 w-12 h-12 bg-onyx-lighter border border-gold/30 rounded-full flex items-center justify-center text-gold shadow-[0_0_15px_rgba(212,175,55,0.2)] hover:scale-110 transition-transform">
                <svg id="music-icon-play" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                <svg id="music-icon-pause" class="w-5 h-5 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
            </button>
            <audio id="bg-music" loop>
                <source src="{{ asset($invitation->content['media']['music']) }}" type="audio/mpeg">
            </audio>
            @endif

            <!-- 1. Hero Section -->
            <section class="relative h-screen flex items-center justify-center overflow-hidden bg-paper">
                <div class="absolute inset-0 p-4">
                    <div class="w-full h-full border border-gold/20 rounded-2xl relative overflow-hidden">
                        <img src="{{ $coverImg }}" class="w-full h-full object-cover opacity-10 mix-blend-multiply" alt="Hero">
                        <div class="absolute inset-0 bg-gradient-to-b from-paper/80 via-transparent to-paper"></div>
                    </div>
                </div>
                
                <div class="relative z-10 text-center px-6 w-full reveal">
                    <p class="font-script text-4xl text-sage-dark mb-4">We Are Getting Married</p>
                    <h2 class="font-serif text-4xl md:text-5xl text-ink mb-6 uppercase tracking-widest leading-snug">
                        {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }}<br>
                        <span class="text-3xl text-gold normal-case italic">&amp;</span><br>
                        {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                    </h2>
                    
                    <!-- Countdown -->
                    @if(isset($invitation->content['acara']['resepsi']['waktu']))
                    <div class="glass-panel mt-10 p-6 mx-auto flex justify-center gap-4 text-center rounded-sm max-w-[320px]">
                        <div class="flex-1">
                            <span id="c-days" class="block font-serif text-2xl text-gold">00</span>
                            <span class="text-[9px] uppercase tracking-widest text-gray-400">Hari</span>
                        </div>
                        <div class="w-px bg-gold/20"></div>
                        <div class="flex-1">
                            <span id="c-hours" class="block font-serif text-2xl text-gold">00</span>
                            <span class="text-[9px] uppercase tracking-widest text-gray-400">Jam</span>
                        </div>
                        <div class="w-px bg-gold/20"></div>
                        <div class="flex-1">
                            <span id="c-mins" class="block font-serif text-2xl text-gold">00</span>
                            <span class="text-[9px] uppercase tracking-widest text-gray-400">Mnt</span>
                        </div>
                        <div class="w-px bg-gold/20"></div>
                        <div class="flex-1">
                            <span id="c-secs" class="block font-serif text-2xl text-gold">00</span>
                            <span class="text-[9px] uppercase tracking-widest text-gray-400">Dtk</span>
                        </div>
                    </div>
                    @endif
                </div>
            </section>

            <!-- 2. Quote Section -->
            @if(isset($invitation->content['quote']))
            <section class="py-24 px-8 text-center bg-paper relative">
                <!-- Top Decorative Line -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-px bg-gradient-to-r from-transparent via-gold to-transparent"></div>
                
                <div class="reveal max-w-[320px] mx-auto relative z-10">
                    <div class="w-12 h-12 rounded-full border border-gold/30 flex items-center justify-center mx-auto mb-6 bg-sage/5">
                        <svg class="w-5 h-5 text-gold opacity-80" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    </div>
                    <p class="font-serif italic text-sm leading-loose text-sage-dark font-medium">
                        "{{ $invitation->content['quote'] }}"
                    </p>
                </div>
                
                <!-- Bottom Decorative Line -->
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-48 h-px bg-gradient-to-r from-transparent via-gold to-transparent"></div>
            </section>
            @endif

            <!-- 3. Couple Section -->
            <section class="py-24 px-6 bg-[#F5F7F5] relative">
                <!-- Subtle botanical pattern background -->
                <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l.83.83-1.66 1.66-.83-.83.83-.83zM58.33 3.704l.83.83-1.66 1.66-.83-.83.83-.83z\' fill=\'%236B8275\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>

                <div class="text-center mb-16 reveal relative z-10">
                    <p class="text-sage-dark tracking-[0.2em] text-[10px] uppercase mb-2 font-semibold">Pasangan Berbahagia</p>
                    <h3 class="font-serif text-3xl text-ink">The Bride & Groom</h3>
                </div>

                <div class="space-y-16 relative z-10">
                    <!-- Groom -->
                    <div class="reveal text-center relative">
                        <div class="w-48 h-56 mx-auto mb-6 p-2 bg-white rounded-t-full shadow-lg border border-gold/20">
                            <div class="w-full h-full overflow-hidden rounded-t-full">
                                <img src="{{ isset($invitation->content['mempelai']['pria']['foto']) ? asset($invitation->content['mempelai']['pria']['foto']) : 'https://placehold.co/500x500/FDFBF7/BFA25D/png?text=Groom' }}" 
                                     class="w-full h-full object-cover filter grayscale hover:grayscale-0 transition duration-700" alt="Groom">
                            </div>
                        </div>
                        <h4 class="font-serif text-2xl text-ink font-semibold mb-2">{{ $invitation->content['mempelai']['pria']['nama'] ?? 'Nama Pria Lengkap' }}</h4>
                        <p class="text-xs text-sage-dark leading-relaxed font-medium tracking-wider">
                            Putra dari<br>
                            Bpk. {{ $invitation->content['mempelai']['pria']['ayah'] ?? '-' }} & Ibu {{ $invitation->content['mempelai']['pria']['ibu'] ?? '-' }}
                        </p>
                        @if(isset($invitation->content['mempelai']['pria']['instagram']))
                        <a href="https://instagram.com/{{ ltrim($invitation->content['mempelai']['pria']['instagram'], '@') }}" target="_blank" class="inline-block mt-4 text-[10px] tracking-widest text-gold hover:text-gold-dark border-b border-gold/30 pb-1 uppercase font-semibold">
                            Connect Instagram
                        </a>
                        @endif
                    </div>

                    <div class="flex justify-center reveal">
                        <span class="font-script text-5xl text-sage/40">&amp;</span>
                    </div>

                    <!-- Bride -->
                    <div class="reveal text-center relative">
                        <div class="w-48 h-56 mx-auto mb-6 p-2 bg-white rounded-t-full shadow-lg border border-gold/20">
                            <div class="w-full h-full overflow-hidden rounded-t-full">
                                <img src="{{ isset($invitation->content['mempelai']['wanita']['foto']) ? asset($invitation->content['mempelai']['wanita']['foto']) : 'https://placehold.co/500x500/FDFBF7/BFA25D/png?text=Bride' }}" 
                                     class="w-full h-full object-cover filter grayscale hover:grayscale-0 transition duration-700" alt="Bride">
                            </div>
                        </div>
                        <h4 class="font-serif text-2xl text-ink font-semibold mb-2">{{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Nama Wanita Lengkap' }}</h4>
                        <p class="text-xs text-sage-dark leading-relaxed font-medium tracking-wider">
                            Putri dari<br>
                            Bpk. {{ $invitation->content['mempelai']['wanita']['ayah'] ?? '-' }} & Ibu {{ $invitation->content['mempelai']['wanita']['ibu'] ?? '-' }}
                        </p>
                        @if(isset($invitation->content['mempelai']['wanita']['instagram']))
                        <a href="https://instagram.com/{{ ltrim($invitation->content['mempelai']['wanita']['instagram'], '@') }}" target="_blank" class="inline-block mt-4 text-[10px] tracking-widest text-gold hover:text-gold-dark border-b border-gold/30 pb-1 uppercase font-semibold">
                            Connect Instagram
                        </a>
                        @endif
                    </div>
                </div>
            </section>

            <!-- 4. Events Section -->
            <section class="py-24 px-6 bg-paper relative">
                <!-- Decorative branch -->
                <div class="absolute top-10 right-0 w-32 h-32 opacity-10 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M90,10 C70,30 80,60 50,80 C30,90 10,70 30,50 C50,30 60,10 90,10 Z\' fill=\'%236B8275\'/%3E%3C/svg%3E'); background-size: contain; background-repeat: no-repeat;"></div>

                <div class="text-center mb-16 reveal relative z-10">
                    <p class="text-sage-dark tracking-[0.2em] text-[10px] uppercase mb-2 font-semibold">Simpan Tanggalnya</p>
                    <h3 class="font-serif text-3xl text-ink">Wedding Events</h3>
                </div>

                <div class="space-y-8 relative z-10">
                    @foreach(['akad' => 'Holy Matrimony', 'resepsi' => 'Wedding Reception'] as $key => $defaultTitle)
                        @if(isset($invitation->content['acara'][$key]))
                        @php $acara = $invitation->content['acara'][$key]; @endphp
                        <div class="bg-white p-8 text-center reveal border-t-4 border-t-gold rounded-b-2xl shadow-[0_10px_40px_rgba(107,130,117,0.08)] relative overflow-hidden">
                            <!-- Subtle corner accent -->
                            <div class="absolute top-0 right-0 w-16 h-16 border-t border-r border-gold/20 mr-2 mt-2"></div>
                            <div class="absolute bottom-0 left-0 w-16 h-16 border-b border-l border-gold/20 ml-2 mb-2"></div>

                            <h4 class="text-sage-dark tracking-[0.2em] text-xs uppercase mb-6 font-bold">{{ $acara['judul'] ?? $defaultTitle }}</h4>
                            
                            @if(isset($acara['waktu']))
                            @php $date = \Carbon\Carbon::parse($acara['waktu']); @endphp
                            <div class="flex justify-center gap-4 items-center mb-6">
                                <div class="text-right">
                                    <span class="block text-sm uppercase text-ink font-semibold">{{ $date->translatedFormat('l') }}</span>
                                    <span class="block text-xs text-sage uppercase">{{ $date->translatedFormat('F') }}</span>
                                </div>
                                <div class="text-4xl font-serif text-gold border-x border-gold/20 px-4">
                                    {{ $date->format('d') }}
                                </div>
                                <div class="text-left">
                                    <span class="block text-sm text-ink font-semibold">{{ $date->format('Y') }}</span>
                                    <span class="block text-xs text-sage-dark">{{ $date->format('H:i') }} WIB</span>
                                </div>
                            </div>
                            @endif

                            <div class="mt-6 pt-6 border-t border-sage-light/20 mx-auto max-w-[250px]">
                                <p class="text-ink font-bold text-sm mb-1">{{ $acara['tempat'] ?? 'Lokasi Acara' }}</p>
                                <p class="text-xs text-sage-dark mb-1 leading-relaxed">{{ $acara['alamat'] ?? '' }}</p>
                                @php
                                    $acaraW = $acara['wilayah'] ?? [];
                                    $acaraL1 = collect([!empty($acaraW['village']) ? 'Kel. '.Str::title(strtolower($acaraW['village'])) : null, !empty($acaraW['district']) ? 'Kec. '.Str::title(strtolower($acaraW['district'])) : null])->filter()->implode(', ');
                                    $acaraL2 = collect([!empty($acaraW['regency']) ? Str::title(strtolower($acaraW['regency'])) : null, !empty($acaraW['province']) ? Str::title(strtolower($acaraW['province'])) : null])->filter()->implode(', ');
                                @endphp
                                @if($acaraL1)<p class="text-xs text-sage-dark mb-0 leading-relaxed">{{ $acaraL1 }}</p>@endif
                                @if($acaraL2)<p class="text-xs text-sage-dark mb-6 leading-relaxed">{{ $acaraL2 }}</p>@else<span class="mb-6 block"></span>@endif
                                
                                @if(isset($acara['maps']))
                                <a href="{{ $acara['maps'] }}" target="_blank" class="inline-block border border-gold text-gold px-6 py-2 text-[10px] tracking-widest uppercase hover:bg-gold hover:text-white transition rounded-full font-semibold">
                                    View Location
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- 5. Gallery Section -->
            @if(isset($invitation->content['media']['gallery']) && count($invitation->content['media']['gallery']) > 0)
            <section class="py-24 px-4 bg-[#F5F7F5] border-y border-sage-light/20">
                <div class="text-center mb-12 reveal">
                    <p class="text-sage-dark tracking-[0.2em] text-[10px] uppercase mb-2 font-semibold">Our Moments</p>
                    <h3 class="font-serif text-3xl text-ink">Gallery</h3>
                </div>
                
                <div class="grid grid-cols-2 gap-3 reveal px-2">
                    @foreach($invitation->content['media']['gallery'] as $index => $photo)
                        <div class="overflow-hidden bg-white p-1 shadow-sm rounded-lg group {{ $index == 0 ? 'col-span-2 aspect-video' : 'aspect-square' }}">
                            <img src="{{ asset($photo) }}" class="w-full h-full object-cover filter brightness-90 sepia-[.2] hover:brightness-100 hover:sepia-0 transition duration-700 transform group-hover:scale-105 rounded" alt="Gallery">
                        </div>
                    @endforeach
                </div>
                
                @if(isset($invitation->content['media']['video_link']))
                <div class="mt-10 reveal px-2">
                    <div class="aspect-video w-full bg-white p-2 shadow-sm rounded-lg">
                        <iframe class="w-full h-full rounded" src="{{ str_replace('watch?v=', 'embed/', $invitation->content['media']['video_link']) }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                @endif
            </section>
            @endif

            <!-- 6. RSVP & Amplop Section -->
            <section class="py-24 px-6 bg-cover bg-center relative" style="background-image: url('{{ $coverImg }}');">
                <div class="absolute inset-0 bg-paper/95 backdrop-blur-sm"></div>
                
                <div class="relative z-10 w-full">
                    <div class="text-center mb-12 reveal">
                        <p class="text-sage-dark tracking-[0.2em] text-[10px] uppercase mb-2 font-semibold">Kehadiran</p>
                        <h3 class="font-serif text-3xl text-ink">RSVP & Wishes</h3>
                    </div>

                    <div class="glass-panel p-6 mb-12 reveal">
                        <form action="{{ route('kirim.ucapan') }}" method="POST" class="space-y-5">
                            @csrf
                            <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">
                            
                            @if(session('success'))
                                <div class="bg-sage/10 border border-sage/30 text-sage-dark font-medium text-xs p-3 text-center mb-4 rounded">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div>
                                @if($guest)
                                    <input type="text" value="{{ $guest->name }}" readonly class="w-full bg-transparent border-b border-sage-dark/30 text-ink text-sm px-0 py-2 focus:outline-none focus:border-gold opacity-60 cursor-not-allowed">
                                    <input type="hidden" name="nama" value="{{ $guest->name }}">
                                @else
                                    <input type="text" name="nama" placeholder="Nama Anda" required class="w-full bg-transparent border-b border-sage-dark/30 text-ink text-sm px-0 py-2 focus:outline-none focus:border-gold placeholder-sage transition-colors">
                                @endif
                            </div>
                            <div>
                                <select name="kehadiran" required class="w-full bg-transparent border-b border-sage-dark/30 text-ink text-sm px-0 py-2 focus:outline-none focus:border-gold appearance-none cursor-pointer transition-colors">
                                    <option value="" class="text-gray-400">Konfirmasi Kehadiran...</option>
                                    <option value="hadir" {{ ($guest && $guest->rsvp_status == 'hadir') ? 'selected' : '' }}>Saya Akan Hadir</option>
                                    <option value="tidak_hadir" {{ ($guest && $guest->rsvp_status == 'tidak_hadir') ? 'selected' : '' }}>Maaf, Tidak Bisa Hadir</option>
                                    <option value="ragu" {{ ($guest && $guest->rsvp_status == 'ragu') ? 'selected' : '' }}>Masih Ragu</option>
                                </select>
                            </div>
                            <div>
                                <textarea name="ucapan" rows="3" placeholder="Tuliskan ucapan & doa..." required class="w-full bg-transparent border-b border-sage-dark/30 text-ink text-sm px-0 py-2 focus:outline-none focus:border-gold placeholder-sage resize-none transition-colors">{{ $guest ? $guest->comment : '' }}</textarea>
                            </div>
                            <button type="submit" class="w-full bg-gold text-white font-semibold text-xs tracking-[0.2em] uppercase py-4 mt-6 hover:bg-gold-dark transition rounded-lg shadow-md">
                                Kirim Ucapan & RSVP
                            </button>
                        </form>
                    </div>

                    <!-- Wishes Feed -->
                    @if(isset($comments) && $comments->count() > 0)
                    <div class="reveal mt-16 px-2">
                        <h4 class="font-serif text-xl text-ink text-center mb-8">Wishes Feed ({{ $comments->count() }})</h4>
                        <div class="max-h-[400px] overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                            @foreach($comments as $item)
                            <div class="bg-white p-5 rounded-xl shadow-sm border border-sage-light/20 relative">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-ink font-bold text-sm">{{ $item->name }}</span>
                                    <span class="text-[9px] text-sage tracking-wider uppercase font-semibold">{{ $item->updated_at->diffForHumans() }}</span>
                                </div>
                                <span class="inline-block text-[9px] uppercase tracking-widest bg-sage/10 text-sage-dark px-2 py-1 rounded mb-3 font-semibold">
                                    {{ $item->rsvp_status == 'hadir' ? 'Hadir' : ($item->rsvp_status == 'tidak_hadir' ? 'Absen' : 'Ragu') }}
                                </span>
                                <p class="text-xs text-ink/80 leading-relaxed italic">"{{ $item->comment }}"</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </section>

            <!-- Gift / Amplop -->
            @if(isset($invitation->content['amplop']))
            <section class="py-24 px-6 bg-[#EAEFEA] border-t border-sage-light/30 text-center relative">
                <!-- Top Decorative Leaf -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-gold/20 z-10">
                    <svg class="w-6 h-6 text-sage-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>

                <div class="reveal mb-12 mt-4 relative z-10">
                    <p class="text-sage-dark tracking-[0.2em] text-[10px] uppercase mb-2 font-semibold">Tanda Kasih</p>
                    <h3 class="font-serif text-3xl text-ink mb-4">Wedding Gift</h3>
                    <p class="text-xs text-sage-dark leading-relaxed max-w-[300px] mx-auto font-medium">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Namun jika Anda bermaksud memberikan tanda kasih, Anda dapat mengirimkannya melalui:</p>
                </div>

                @if(isset($invitation->content['amplop']['account_number']))
                <div class="bg-white p-8 max-w-[320px] mx-auto reveal mb-8 relative overflow-hidden rounded-2xl shadow-[0_10px_30px_rgba(107,130,117,0.1)] border border-gold/10">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-sage/5 rounded-bl-full pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-gold/5 rounded-tr-full pointer-events-none"></div>
                    
                    <p class="text-xs text-sage-dark uppercase tracking-widest mb-2 font-bold">{{ $invitation->content['amplop']['bank_name'] }}</p>
                    <h4 class="font-serif text-2xl text-ink mb-2">{{ $invitation->content['amplop']['account_number'] }}</h4>
                    <p class="text-xs text-sage-dark mb-6 font-medium">a.n {{ $invitation->content['amplop']['account_holder'] }}</p>
                    
                    <button onclick="copyText('{{ $invitation->content['amplop']['account_number'] }}', this)" class="border-2 border-gold text-gold text-[10px] font-bold tracking-widest uppercase px-6 py-2.5 hover:bg-gold hover:text-white transition rounded-full z-10 relative">
                        Copy Rekening
                    </button>
                </div>
                @endif

                @if(isset($invitation->content['amplop']['alamat_kado']))
                <div class="bg-white p-8 max-w-[320px] mx-auto reveal rounded-2xl shadow-[0_10px_30px_rgba(107,130,117,0.1)] border border-gold/10 relative">
                    <svg class="w-6 h-6 text-gold mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <p class="text-xs text-sage-dark uppercase tracking-widest mb-3 font-bold">Kirim Kado / Bunga</p>
                    <p class="text-xs text-ink leading-relaxed font-medium">{{ $invitation->content['amplop']['alamat_kado'] }}</p>
                </div>
                @endif
            </section>
            @endif

            <!-- Footer -->
            <footer class="py-14 bg-paper text-center border-t border-sage-light/30 relative">
                <!-- Floral corner accents for footer -->
                <div class="absolute bottom-0 left-0 w-24 h-24 opacity-10 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M10,90 C30,70 40,40 20,20 C40,10 60,30 40,50 C20,70 10,90 10,90 Z\' fill=\'%236B8275\'/%3E%3C/svg%3E'); background-size: contain; background-repeat: no-repeat;"></div>
                <div class="absolute bottom-0 right-0 w-24 h-24 opacity-10 pointer-events-none transform scale-x-[-1]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M90,90 C70,70 60,40 80,20 C60,10 40,30 60,50 C80,70 90,90 90,90 Z\' fill=\'%236B8275\'/%3E%3C/svg%3E'); background-size: contain; background-repeat: no-repeat;"></div>

                <div class="relative z-10">
                    <p class="font-script text-4xl text-sage mb-4">Thank You</p>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-sage-dark mb-8 font-semibold">
                        {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                    </p>
                    <div class="w-16 h-px bg-gold/40 mx-auto mb-8"></div>
                    <p class="text-[9px] text-sage-dark uppercase tracking-widest font-semibold">
                        Created with <span class="text-gold">&hearts;</span> by Temanten
                    </p>
                </div>
            </footer>
        </div>
    </main>

    <script>
        // Opening logic
        function openInvitation() {
            document.getElementById('cover-page').classList.add('open');
            document.getElementById('main-content').classList.remove('h-0');
            document.getElementById('main-content').classList.add('h-auto');
            document.body.style.overflowY = 'auto'; // allow scroll
            
            // Play music
            const audio = document.getElementById('bg-music');
            if (audio) {
                audio.play().catch(e => console.log('Audio autoplay blocked'));
            }
        }

        // Music control
        const musicBtn = document.getElementById('music-btn');
        const audio = document.getElementById('bg-music');
        const iconPlay = document.getElementById('music-icon-play');
        const iconPause = document.getElementById('music-icon-pause');
        
        if (musicBtn && audio) {
            musicBtn.addEventListener('click', () => {
                if (audio.paused) {
                    audio.play();
                    iconPlay.classList.add('hidden');
                    iconPause.classList.remove('hidden');
                } else {
                    audio.pause();
                    iconPause.classList.add('hidden');
                    iconPlay.classList.remove('hidden');
                }
            });
        }

        // Reveal Animation Observer
        const revealCallback = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        };
        const revealOptions = { threshold: 0.15, rootMargin: "0px 0px -50px 0px" };
        const revealObserver = new IntersectionObserver(revealCallback, revealOptions);
        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

        // Countdown Timer
        @if(isset($invitation->content['acara']['resepsi']['waktu']))
        const countDownDate = new Date("{{ $invitation->content['acara']['resepsi']['waktu'] }}").getTime();
        const x = setInterval(function() {
            const now = new Date().getTime();
            const distance = countDownDate - now;

            if (distance < 0) {
                clearInterval(x);
                return;
            }

            document.getElementById("c-days").innerText = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
            document.getElementById("c-hours").innerText = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
            document.getElementById("c-mins").innerText = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
            document.getElementById("c-secs").innerText = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
        }, 1000);
        @endif

        // Copy Text Function
        function copyText(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const originalText = btn.innerText;
                btn.innerText = 'Tersalin!';
                btn.classList.add('bg-gold', 'text-black');
                setTimeout(() => {
                    btn.innerText = originalText;
                    btn.classList.remove('bg-gold', 'text-black');
                }, 2000);
            });
        }

        // Generate Gold Dust Particles manually
        const container = document.getElementById('particles');
        for (let i = 0; i < 20; i++) {
            let div = document.createElement('div');
            div.className = 'gold-dust';
            // Random size 2px - 6px
            let size = Math.random() * 4 + 2;
            div.style.width = size + 'px';
            div.style.height = size + 'px';
            // Random position
            div.style.left = Math.random() * 100 + '%';
            div.style.top = Math.random() * 100 + '%';
            // Random animation delay
            div.style.animationDelay = (Math.random() * 5) + 's';
            div.style.animationDuration = (Math.random() * 5 + 5) + 's';
            container.appendChild(div);
        }
    </script>
</body>
</html>