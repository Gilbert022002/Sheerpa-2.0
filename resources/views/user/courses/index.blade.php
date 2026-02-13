<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sheerpa - Nos Cours</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#7ec9df", // Bleu Sheerpa
                        "secondary": "#ef5e21", // Orange Sheerpa
                        "background-light": "#f6f6f8",
                        "card-light": "#ffffff",
                        "text-main-light": "#121118",
                        "text-sub-light": "#686189",
                        "border-light": "#f1f0f4",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "xl": "1rem",
                        "2xl": "1.5rem",
                        "3xl": "2rem"
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-shadow {
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-background-light text-text-main-light min-h-screen flex flex-col">
    <header class="flex items-center justify-between border-b border-solid border-border-light bg-card-light px-6 py-3 sticky top-0 z-50">
        <div class="flex items-center gap-8 w-full max-w-[1280px] mx-auto">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-bleu-sheerpa.png') }}" alt="Sheerpa Logo" class="h-12 w-auto object-contain">
                <span class="bg-primary/10 text-primary text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest">Plateforme Sheerpa</span>
            </div>
            <div class="flex flex-1 justify-end gap-6 items-center">
                <div class="hidden md:flex items-center gap-6">
                    <a class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors" href="#">Explorer</a>
                    <a class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors" href="#">Aide</a>
                </div>
                <div class="flex items-center gap-3 pl-6 border-l border-border-light">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-text-sub-light font-bold">{{ auth()->user()->role }}</p>
                    </div>
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ auth()->user()->id }}" class="size-10 rounded-full bg-primary/5 object-cover" alt="Profile">
                </div>
            </div>
        </div>
    </header>

    <div class="flex flex-1 w-full max-w-[1280px] mx-auto">
        <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">
            <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
                <div class="mb-8">
                    <h1 class="text-2xl font-black text-text-main-light">Nos Cours</h1>
                    <p class="text-text-sub-light">Parcourez tous les cours disponibles</p>
                </div>

                @if (session('status'))
                    <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold mb-4">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl font-bold mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($courses as $course)
                        <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow flex flex-col h-full">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail" class="w-full h-40 object-cover rounded-xl mb-4">
                            @else
                                <div class="bg-slate-200 border-2 border-dashed rounded-xl w-full h-40 flex items-center justify-center mb-4">
                                    <span class="text-slate-500 text-sm">Aucune miniature</span>
                                </div>
                            @endif
                            <h4 class="font-black text-lg mb-2 text-text-main-light">{{ $course->title }}</h4>
                            <p class="text-sm text-text-sub-light mb-4 flex-grow">{{ Str::limit($course->description, 100) }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm font-bold text-primary">{{ $course->price }} €</span>
                                <span class="text-sm text-text-sub-light">{{ $course->duration }} min</span>
                            </div>
                            <div class="flex items-center gap-2 pt-4 border-t border-border-light">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $course->guide->id }}" class="size-8 rounded-full">
                                <span class="text-sm font-bold text-text-sub-light">{{ $course->guide->name }}</span>
                            </div>
                            <a href="{{ route('user.courses.show', $course) }}" class="mt-4 px-4 py-3 bg-primary text-white rounded-xl text-center font-bold hover:bg-primary/90 transition-all">
                                Voir les détails et réserver
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full bg-white p-8 rounded-2xl border border-border-light soft-shadow text-center text-text-sub-light">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-4">school</span>
                                <p class="text-lg font-bold">Aucun cours disponible pour le moment</p>
                                <p class="mt-2">Revenez bientôt pour découvrir de nouveaux cours</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8 flex justify-center">
                    {{ $courses->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
