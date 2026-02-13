<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sheerpa Admin - Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">
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
            <span class="bg-primary/10 text-primary text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest">Espace Admin</span>
        </div>
        <div class="flex flex-1 justify-end gap-6 items-center">
            <div class="flex items-center gap-3 pl-6 border-l border-border-light">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-black">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-text-sub-light font-bold">Administrateur</p>
                </div>
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=admin" class="size-10 rounded-full bg-primary/5 object-cover" alt="Profile">
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full rounded-xl text-secondary font-bold hover:bg-secondary/5 transition-all">
                    <span class="material-symbols-outlined">logout</span> Déconnexion
                </button>
            </form>
        </div>
    </div>
</header>

<div class="flex flex-1 w-full max-w-[1280px] mx-auto p-6 md:p-8 space-y-8 overflow-y-auto">
    <main class="flex-1 space-y-8">
        <h1 class="text-2xl font-black text-text-main-light">Tableau de bord Administrateur</h1>

        @if (session('status'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl font-bold">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl font-bold">
                {{ session('error') }}
            </div>
        @endif

        <section>
            <h2 class="text-lg font-black mb-4">Instructeurs en attente de validation</h2>
            @if($pendingInstructors->isEmpty())
                <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow text-center text-text-sub-light">
                    Aucun instructeur en attente de validation pour le moment.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pendingInstructors as $instructor)
                        <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow flex flex-col gap-4">
                            <div class="flex items-center gap-4">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $instructor->id }}" class="size-16 rounded-full bg-primary/5 object-cover" alt="Profile">
                                <div>
                                    <h3 class="text-lg font-black">{{ $instructor->name }}</h3>
                                    <p class="text-sm text-text-sub-light">{{ $instructor->email }}</p>
                                    <p class="text-xs font-bold uppercase text-secondary">{{ $instructor->instructor_status }}</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm text-text-main-light">
                                <p><span class="font-bold">Expérience:</span> {{ Str::limit($instructor->experience, 100) }}</p>
                                @if($instructor->stripe_account_id)
                                    <p><span class="font-bold">Stripe ID:</span> {{ $instructor->stripe_account_id }}</p>
                                @endif
                                @if($instructor->presentation_video_url)
                                    <p><span class="font-bold">Vidéo:</span> <a href="{{ $instructor->presentation_video_url }}" target="_blank" class="text-primary hover:underline">Voir la vidéo</a></p>
                                @endif
                            </div>
                            <div class="flex gap-2 mt-auto pt-4 border-t border-border-light">
                                <form method="POST" action="{{ route('admin.instructors.approve', $instructor) }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-xl font-bold text-sm hover:opacity-90 transition-all">
                                        Approuver
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.instructors.reject', $instructor) }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-xl font-bold text-sm hover:opacity-90 transition-all">
                                        Rejeter
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</div>

</body>
</html>
