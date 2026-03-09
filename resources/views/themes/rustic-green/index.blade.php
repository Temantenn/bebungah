<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Pinyon+Script&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 48 48%22><rect width=%2248%22 height=%2248%22 rx=%2212%22 fill=%22%234F46E5%22/><path d=%22M15 13h18v6h-6v17h-6v-17h-6v-6z%22 fill=%22white%22/></svg>">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite(['resources/css/rustic.css', 'resources/js/app.js'])
</head>
<body class="bg-texture text-charcoal font-sans antialiased overflow-x-hidden no-scroll" id="mainBody">
    @php

        function getFileUrl($path, $default = 'https://via.placeholder.com/300') {

            if (empty($path)) return $default;

            if (filter_var($path, FILTER_VALIDATE_URL)) return $path;

            if (strpos($path, 'storage/') === 0) {
                return asset($path);
            }

            if (strpos($path, 'assets/') === 0) {
                return asset($path);
            }

            return asset('storage/' . $path);
        }

        $userMusic = $invitation->content['media']['music'] ?? null;
        if ($userMusic) {

            $musicUrl = getFileUrl($userMusic, asset('assets/music/rustic-green.mp3'));
        } else {
            $musicUrl = asset('assets/music/rustic-green.mp3');
        }
    @endphp

    <div id="gate" class="fixed inset-0 z-[999] bg-texture flex flex-col items-center justify-center text-center p-6 transition-all duration-1000 bg-cover bg-center" style="background-image: url('{{ getFileUrl($invitation->content['media']['cover'] ?? null) }}');">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>
        <div class="relative z-10 text-cream animate-float">
            <p class="uppercase tracking-[0.3em] text-xs mb-4">The Wedding Of</p>
            <div class="flex justify-center -space-x-4 mb-6">
                <img src="{{ getFileUrl($invitation->content['mempelai']['pria']['foto'] ?? null) }}" class="w-20 h-20 rounded-full border-2 border-cream object-cover">
                <img src="{{ getFileUrl($invitation->content['mempelai']['wanita']['foto'] ?? null) }}" class="w-20 h-20 rounded-full border-2 border-cream object-cover">
            </div>
            <h1 class="font-rustic-script text-6xl mb-2">
                {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Romeo' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Juliet' }}
            </h1>
            <p class="font-serif italic mb-8 border-y border-white/50 py-2 inline-block">
                {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
            </p>

            <div class="glass-card text-charcoal px-6 py-4 rounded-xl mb-8 mx-auto max-w-xs bg-white/90">
                <p class="text-xs uppercase mb-1">Kepada Yth:</p>
                <h3 class="font-bold text-lg">{{ isset($guest) ? $guest->name : 'Tamu Undangan' }}</h3>
            </div>

            <button onclick="bukaUndangan()" class="bg-sage text-white px-8 py-3 rounded-full uppercase tracking-widest text-sm font-bold hover:bg-sage-dark transition shadow-lg flex items-center gap-2 mx-auto animate-pulse">
                <i class="ph-fill ph-envelope-open"></i> Buka Undangan
            </button>
        </div>
    </div>

    <button onclick="toggleMusic()" id="musicBtn" class="fixed bottom-4 right-4 z-50 bg-sage-dark text-white w-10 h-10 rounded-full shadow-xl flex items-center justify-center hidden border-2 border-cream">
        <i class="ph-fill ph-music-notes text-lg"></i>
    </button>
    <audio id="bg-music" loop>
        <source src="{{ $musicUrl }}" type="audio/mp3">
    </audio>

    <section class="relative min-h-screen w-full overflow-hidden flex flex-col items-center justify-center text-center px-4 pt-20">
        <div class="absolute inset-0 bg-cover bg-center opacity-100" style="background-image: url('{{ getFileUrl($invitation->content['media']['cover'] ?? null) }}');"></div>
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 mt-10 text-cream">
            <p class="font-sans tracking-[0.5em] text-xs uppercase mb-4 drop-shadow-md">Save The Date</p>
            <h1 class="font-rustic-script text-7xl md:text-9xl mb-2 text-cream drop-shadow-lg">
                {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Romeo' }} <span class="text-terracotta">&</span> {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Juliet' }}
            </h1>
            <div id="countdown" class="flex flex-wrap justify-center gap-4 mt-8 font-serif text-cream drop-shadow-md"></div>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-[#F9F9F2] to-transparent z-20"></div>
    </section>

    <section class="pt-12 pb-0 px-6 relative bg-texture">
        <div class="max-w-5xl mx-auto text-center relative z-10">
            <p class="text-terracotta font-bold tracking-widest text-xs uppercase mb-2">The Happy Couple</p>
            <h2 class="font-rustic-serif text-5xl text-gray-800 mb-16">Groom & Bride</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">

                <div class="group relative flex flex-col items-center">
                    <div class="relative w-full max-w-sm aspect-[3/4] mb-6">
                        <div class="absolute inset-0 bg-sage-dark rounded-t-[10rem] rounded-b-[2rem] transform rotate-3 transition duration-500"></div>
                        <img src="{{ getFileUrl($invitation->content['mempelai']['pria']['foto'] ?? null) }}" class="relative w-full h-full object-cover rounded-t-[10rem] rounded-b-[2rem] border-4 border-white shadow-xl transform -rotate-3 z-10">
                    </div>
                    <div class="relative z-20 text-center">
                        <h3 class="font-rustic-script text-5xl text-charcoal mb-1">{{ $invitation->content['mempelai']['pria']['nama'] ?? 'Mempelai Pria' }}</h3>
                        <p class="text-xs font-bold text-sage uppercase tracking-widest mb-3">Putra Bpk. {{ $invitation->content['mempelai']['pria']['ayah'] ?? '...' }} & Ibu {{ $invitation->content['mempelai']['pria']['ibu'] ?? '...' }}</p>

                        @if(!empty($invitation->content['mempelai']['pria']['instagram']))
                        <a href="https://instagram.com/{{ $invitation->content['mempelai']['pria']['instagram'] }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-white border border-sage px-3 py-1 rounded-full hover:bg-sage hover:text-white transition cursor-pointer z-30 relative text-sage-dark">
                            <i class="ph-fill ph-instagram-logo"></i> <span>Instagram</span>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="group relative flex flex-col items-center">
                    <div class="relative w-full max-w-sm aspect-[3/4] mb-6">
                        <div class="absolute inset-0 bg-terracotta/80 rounded-t-[10rem] rounded-b-[2rem] transform -rotate-3 transition duration-500"></div>
                        <img src="{{ getFileUrl($invitation->content['mempelai']['wanita']['foto'] ?? null) }}" class="relative w-full h-full object-cover rounded-t-[10rem] rounded-b-[2rem] border-4 border-white shadow-xl transform rotate-3 z-10">
                    </div>
                    <div class="relative z-20 text-center">
                        <h3 class="font-rustic-script text-5xl text-charcoal mb-1">{{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Mempelai Wanita' }}</h3>
                        <p class="text-xs font-bold text-sage uppercase tracking-widest mb-3">Putri Bpk. {{ $invitation->content['mempelai']['wanita']['ayah'] ?? '...' }} & Ibu {{ $invitation->content['mempelai']['wanita']['ibu'] ?? '...' }}</p>

                        @if(!empty($invitation->content['mempelai']['wanita']['instagram']))
                        <a href="https://instagram.com/{{ $invitation->content['mempelai']['wanita']['instagram'] }}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-white border border-sage px-3 py-1 rounded-full hover:bg-sage hover:text-white transition cursor-pointer z-30 relative text-sage-dark">
                            <i class="ph-fill ph-instagram-logo"></i> <span>Instagram</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="bg-texture py-2">
        <div class="section-divider">
            <svg width="100%" height="20" viewBox="0 0 500 20" preserveAspectRatio="none">
                <path d="M0,10 Q250,20 500,10" fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="5,5" />
                <circle cx="250" cy="15" r="4" fill="currentColor" />
            </svg>
        </div>
        <div class="flex justify-center -mt-8">
            <i class="ph-fill ph-flower-lotus text-2xl bg-texture px-2 relative z-10 text-sage"></i>
        </div>
    </div>

    @if(isset($invitation->content['love_stories']) && is_array($invitation->content['love_stories']))
    <section class="relative bg-texture pt-0 pb-32 px-6">
        <div class="max-w-3xl mx-auto relative z-10">
            <h2 class="font-rustic-script text-5xl text-center text-sage-dark mb-12">Our Love Story</h2>
            <div class="relative border-l-2 border-sage ml-6 md:ml-1/2 space-y-12 pl-8 md:pl-0">
                @foreach($invitation->content['love_stories'] as $index => $story)
                @if(!empty($story['title']))
                <div class="relative md:flex items-center justify-between group">
                    <div class="absolute -left-[39px] md:left-1/2 md:-ml-[9px] w-5 h-5 bg-terracotta rounded-full border-4 border-white z-10"></div>

                    <div class="md:w-[45%] {{ $index % 2 == 0 ? 'md:ml-auto md:text-left' : 'md:mr-auto md:text-right' }} bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition border-t-4 border-sage">
                        <span class="text-terracotta font-bold text-sm">{{ $story['year'] ?? '' }}</span>
                        <h3 class="font-serif text-xl font-bold mb-2">{{ $story['title'] ?? '' }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $story['story'] ?? '' }}</p>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>

        <div class="wave-wrapper wave-bukit text-sage-dark">
            <svg class="wave-svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
            </svg>
        </div>
    </section>
    @endif

    <section class="relative bg-sage-dark text-cream pt-12 pb-12 px-6">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">

            <div class="bg-white/5 p-8 border border-white/10 rounded-tr-[3rem] rounded-bl-[3rem] text-center transform hover:-translate-y-2 transition duration-300">
                <i class="ph-fill ph-hands-praying text-4xl mb-4 text-terracotta"></i>
                <h3 class="font-serif text-2xl mb-2">{{ $invitation->content['acara']['akad']['judul'] ?? 'Akad Nikah' }}</h3>
                <p class="text-3xl font-bold my-4 text-white">{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('H:i') }} WIB</p>
                <p class="opacity-80 mb-2">{{ $invitation->content['acara']['akad']['tempat'] ?? 'Lokasi Akad' }}</p>
                @php
                    $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                    $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                    $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
                @endphp
                @if($akadL1)<p class="text-xs opacity-60 mb-0">{{ $akadL1 }}</p>@endif
                @if($akadL2)<p class="text-xs opacity-60 mb-6">{{ $akadL2 }}</p>@else<span class="mb-6 block"></span>@endif
                @if(!empty($invitation->content['acara']['akad']['maps']))
                <a href="{{ $invitation->content['acara']['akad']['maps'] }}" target="_blank" class="inline-block border border-cream px-6 py-2 text-xs uppercase hover:bg-cream hover:text-sage-dark transition rounded-full relative z-40">Google Maps</a>
                @endif
            </div>

            <div class="bg-white/5 p-8 border border-white/10 rounded-tl-[3rem] rounded-br-[3rem] text-center transform hover:-translate-y-2 transition duration-300">
                <i class="ph-fill ph-wine text-4xl mb-4 text-terracotta"></i>
                <h3 class="font-serif text-2xl mb-2">{{ $invitation->content['acara']['resepsi']['judul'] ?? 'Resepsi' }}</h3>
                <p class="text-3xl font-bold my-4 text-white">{{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->format('H:i') }} WIB</p>
                <p class="opacity-80 mb-2">{{ $invitation->content['acara']['resepsi']['tempat'] ?? 'Lokasi Resepsi' }}</p>
                @php
                    $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                    $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                    $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
                @endphp
                @if($resepsiL1)<p class="text-xs opacity-60 mb-0">{{ $resepsiL1 }}</p>@endif
                @if($resepsiL2)<p class="text-xs opacity-60 mb-6">{{ $resepsiL2 }}</p>@else<span class="mb-6 block"></span>@endif
                @if(!empty($invitation->content['acara']['resepsi']['maps']))
                <a href="{{ $invitation->content['acara']['resepsi']['maps'] }}" target="_blank" class="inline-block border border-cream px-6 py-2 text-xs uppercase hover:bg-cream hover:text-sage-dark transition rounded-full relative z-40">Google Maps</a>
                @endif
            </div>
        </div>
    </section>

    <section class="relative bg-texture pt-32 pb-32 px-6">
        <div class="wave-wrapper wave-tetesan text-sage-dark">
            <svg class="wave-svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
            </svg>
        </div>

        <h2 class="font-rustic-script text-6xl text-center text-sage-dark mb-12">Gallery</h2>
        <div class="max-w-6xl mx-auto columns-2 md:columns-3 gap-6 space-y-6">
            @if(isset($invitation->content['media']['gallery']) && is_array($invitation->content['media']['gallery']))
                @foreach($invitation->content['media']['gallery'] as $index => $photo)
                    <div class="break-inside-avoid p-2 bg-white shadow-lg {{ $index % 2 == 0 ? 'rotate-1' : '-rotate-1' }} hover:rotate-0 transition duration-500">
                         <img src="{{ getFileUrl($photo) }}" class="w-full grayscale hover:grayscale-0 transition duration-700">
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <section class="relative bg-sage-dark text-cream pt-12 pb-12 px-6">
        <div class="max-w-2xl mx-auto text-center relative z-10">
            <h2 class="font-rustic-serif text-3xl mb-4">Wedding Gift</h2>
            <p class="text-sm opacity-80 mb-8">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Namun jika memberi adalah ungkapan tanda kasih Anda, kami menerima kado secara cashless.</p>

            @if(!empty($invitation->content['amplop']['bank_name']))
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-xl shadow-lg border border-white/20 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-terracotta"></div>
                <p class="text-sm uppercase tracking-widest opacity-70 mb-2">{{ $invitation->content['amplop']['bank_name'] }}</p>
                <h3 class="font-mono text-3xl mb-2 tracking-wider" id="noRek">{{ $invitation->content['amplop']['account_number'] ?? '0000' }}</h3>
                <p class="text-sm font-bold mb-6">a.n {{ $invitation->content['amplop']['account_holder'] ?? '' }}</p>
                <button onclick="copyToClipboard('noRek')" class="bg-terracotta text-white px-6 py-2 rounded-full text-xs font-bold uppercase hover:bg-[#b0604b] transition flex items-center gap-2 mx-auto">
                    <i class="ph-bold ph-copy"></i> Salin Rekening
                </button>
            </div>
            @endif

            <div class="mt-8 bg-white/10 backdrop-blur-sm p-6 rounded-xl shadow border border-white/20">
                <i class="ph-fill ph-gift text-3xl text-terracotta mb-2"></i>
                <p class="text-sm font-bold mb-1">Alamat Kirim Kado:</p>
                <p class="text-sm opacity-80 mb-4">{{ $invitation->content['amplop']['alamat_kado'] ?? 'Alamat belum diisi' }}</p>
            </div>
        </div>
    </section>

    <section class="relative bg-texture pt-32 pb-32 px-6">

        <div class="wave-wrapper wave-bukit text-sage-dark pointer-events-none" style="transform: rotate(180deg); top: -1px;">
             <svg class="wave-svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
            </svg>
        </div>

        <div class="max-w-3xl mx-auto relative z-20">
            <h2 class="font-rustic-serif text-4xl mb-2 text-center text-sage-dark">Wedding Wishes</h2>
            <p class="text-center text-sm text-gray-500 mb-10 italic">Berikan doa & ucapan terbaik untuk kami</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center text-sm">
                    <ul class="list-none">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                <div>
                    <form action="{{ route('kirim.ucapan') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">

                        <div class="relative z-30">
                            <input type="text" name="nama" placeholder="Nama Anda" class="w-full bg-white border-b-2 border-sage/30 p-3 text-sage-dark placeholder-gray-400 focus:outline-none focus:border-terracotta transition bg-transparent" required>
                        </div>

                        <div class="relative z-30">
                            <select name="kehadiran" class="w-full bg-white border-b-2 border-sage/30 p-3 text-sage-dark focus:outline-none focus:border-terracotta transition bg-transparent cursor-pointer" required>
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Berhalangan</option>
                                <option value="ragu">Masih Ragu</option>
                            </select>
                        </div>

                        <div class="relative z-30">
                            <textarea name="ucapan" placeholder="Tulis ucapan & doa..." rows="4" class="w-full bg-white border-2 border-sage/20 p-3 rounded-xl text-sage-dark placeholder-gray-400 focus:outline-none focus:border-terracotta focus:ring-0 transition resize-none" required></textarea>
                        </div>

                        <div class="relative z-30">
                            <button type="submit" class="w-full bg-sage-dark text-white font-bold py-3 rounded-full hover:bg-terracotta hover:shadow-lg transform hover:-translate-y-1 transition duration-300 tracking-widest text-sm cursor-pointer">
                                KIRIM UCAPAN
                            </button>
                        </div>
                    </form>
                </div>

                <div class="relative z-30">
                    <div class="rustic-scroll h-[400px] overflow-y-auto pr-2">
                        @if($invitation->comments->count() > 0)
                            @foreach($invitation->comments->sortByDesc('created_at') as $comment)
                                <div class="rustic-comment-card group bg-white/50 backdrop-blur-sm">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-bold text-sage-dark font-serif text-lg">{{ $comment->name }}</h4>
                                            <span class="text-[10px] text-gray-400 uppercase tracking-wider">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($comment->rsvp_status == 'hadir')
                                            <span class="bg-[#E6F4EA] text-[#1E8E3E] text-[10px] font-bold px-2 py-1 rounded-full border border-[#1E8E3E]/20">HADIR</span>
                                        @elseif($comment->rsvp_status == 'tidak_hadir')
                                            <span class="bg-[#FCE8E6] text-[#C5221F] text-[10px] font-bold px-2 py-1 rounded-full border border-[#C5221F]/20">MAAF</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded-full">RAGU</span>
                                        @endif
                                    </div>

                                    <p class="text-sm text-gray-600 italic leading-relaxed font-serif border-t border-dashed border-gray-200 pt-2 mt-2">
                                        "{{ $comment->comment }}"
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-10 opacity-60">
                                <i class="ph-duotone ph-pencil-simple-slash text-4xl mb-2 text-sage"></i>
                                <p class="text-sm">Belum ada ucapan.</p>
                                <p class="text-xs">Jadilah yang pertama menulis doa!</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <div class="wave-wrapper wave-bukit text-charcoal pointer-events-none">
            <svg class="wave-svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
            </svg>
        </div>
    </section>

    <footer class="bg-charcoal text-cream py-6 text-center text-xs tracking-widest uppercase relative z-10">
        {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const audio = document.getElementById('bg-music');
            const musicBtn = document.getElementById('musicBtn');
            const musicIcon = musicBtn ? musicBtn.querySelector('i') : null;

            window.bukaUndangan = function() {
                const gate = document.getElementById('gate');
                const body = document.getElementById('mainBody');

                gate.classList.add('slide-up');
                body.classList.remove('no-scroll');

                if (musicBtn) {
                    setTimeout(() => {
                        musicBtn.classList.remove('hidden');
                        musicBtn.classList.add('animate-spin-slow');
                    }, 1000);
                }

                playAudio();
            }

            function playAudio() {
                if(audio && musicBtn) {
                    audio.play().then(() => {
                        if(musicIcon) {
                            musicIcon.classList.remove('ph-music-notes');
                            musicIcon.classList.add('ph-pause');
                        }
                        musicBtn.classList.add('animate-spin-slow');
                    }).catch(error => {
                        console.log("Autoplay diblokir browser, menunggu interaksi user.");
                        musicBtn.classList.remove('hidden');
                    });
                }
            }

            function pauseAudio() {
                if(audio && musicBtn) {
                    audio.pause();
                    if(musicIcon) {
                        musicIcon.classList.remove('ph-pause');
                        musicIcon.classList.add('ph-music-notes');
                    }
                    musicBtn.classList.remove('animate-spin-slow');
                }
            }

            window.toggleMusic = function() {
                if (audio) {
                    if (audio.paused) {
                        playAudio();
                    } else {
                        pauseAudio();
                    }
                }
            }

            const akadDateStr = "{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('Y-m-d H:i:s') }}";
            const akadDate = new Date(akadDateStr).getTime();

            const timer = setInterval(function() {
                const now = new Date().getTime();
                const distance = akadDate - now;

                if (distance < 0) {
                    const el = document.getElementById("countdown");
                    if(el) el.innerHTML = "<span class='text-xl'>Acara Telah Selesai</span>";
                    clearInterval(timer);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                const boxClass = "bg-white/10 backdrop-blur-md border border-white/30 px-3 py-2 rounded text-center min-w-[60px] md:min-w-[70px]";
                const numClass = "text-xl md:text-2xl font-bold block";
                const labelClass = "text-[8px] md:text-[10px] uppercase tracking-widest opacity-80";

                const countdownEl = document.getElementById("countdown");
                if(countdownEl) {
                    countdownEl.innerHTML = `
                        <div class="${boxClass}"><span class="${numClass}">${days}</span><span class="${labelClass}">Hari</span></div>
                        <div class="${boxClass}"><span class="${numClass}">${hours}</span><span class="${labelClass}">Jam</span></div>
                        <div class="${boxClass}"><span class="${numClass}">${minutes}</span><span class="${labelClass}">Menit</span></div>
                        <div class="${boxClass}"><span class="${numClass}">${seconds}</span><span class="${labelClass}">Detik</span></div>
                    `;
                }
            }, 1000);

            window.copyToClipboard = function(elementId) {
                const el = document.getElementById(elementId);
                if(el) {
                    const text = el.innerText;
                    navigator.clipboard.writeText(text).then(() => { alert("Nomor Rekening Berhasil Disalin!"); });
                }
            }
        });
    </script>
</body>
</html>