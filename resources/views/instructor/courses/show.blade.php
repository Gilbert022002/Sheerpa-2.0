<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sheerpa Guide - Détails du cours</title>
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
                <span class="bg-primary/10 text-primary text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest">Espace Guide</span>
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
        <aside class="w-64 hidden lg:flex flex-col gap-2 p-6 border-r border-border-light">
            <nav class="flex flex-col gap-1">
                <a href="{{ route('instructor.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary font-bold transition-all">
                    <span class="material-symbols-outlined">dashboard</span> Tableau de bord
                </a>
                <a href="{{ route('instructor.courses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">school</span> Mes Cours
                </a>
                <a href="{{ route('instructor.availabilities.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">event_available</span> Mes Disponibilités
                </a>
                <a href="{{ route('instructor.one-time-slots.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">video_library</span> Mes Meetings
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">groups</span> Participants
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">payments</span> Revenus
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">settings</span> Paramètres
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-border-light">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full rounded-xl text-secondary font-bold hover:bg-secondary/5 transition-all">
                        <span class="material-symbols-outlined">logout</span> Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">
            @if (session('status'))
                <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
                <div class="mb-8">
                    <h1 class="text-2xl font-black text-text-main-light">Détails du cours : {{ $course->title }}</h1>
                    <p class="text-text-sub-light">Informations complètes sur votre cours</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 p-4 rounded-xl">
                        <h3 class="text-lg font-medium text-blue-800">Total des réservations</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalBookings }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-xl">
                        <h3 class="text-lg font-medium text-green-800">Réservations confirmées</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $confirmedBookings }}</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-xl">
                        <h3 class="text-lg font-medium text-yellow-800">Réservations en attente</h3>
                        <p class="text-3xl font-bold text-yellow-600">{{ $pendingBookings }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-text-main-light mb-4">Informations du cours</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-white rounded-xl border border-border-light">
                            <p class="text-sm text-text-sub-light font-bold">Titre</p>
                            <p class="font-bold text-text-main-light">{{ $course->title }}</p>
                        </div>
                        <div class="p-4 bg-white rounded-xl border border-border-light">
                            <p class="text-sm text-text-sub-light font-bold">Niveau</p>
                            <p class="font-bold text-text-main-light">{{ ucfirst($course->level) }}</p>
                        </div>
                        <div class="p-4 bg-white rounded-xl border border-border-light">
                            <p class="text-sm text-text-sub-light font-bold">Catégorie</p>
                            <p class="font-bold text-text-main-light">{{ $course->category }}</p>
                        </div>
                        <div class="p-4 bg-white rounded-xl border border-border-light">
                            <p class="text-sm text-text-sub-light font-bold">Durée</p>
                            <p class="font-bold text-text-main-light">{{ $course->duration }} minutes</p>
                        </div>
                        <div class="p-4 bg-white rounded-xl border border-border-light">
                            <p class="text-sm text-text-sub-light font-bold">Prix</p>
                            <p class="font-bold text-text-main-light">{{ number_format($course->price, 2) }} €</p>
                        </div>
                        <div class="p-4 bg-white rounded-xl border border-border-light">
                            <p class="text-sm text-text-sub-light font-bold">Date de création</p>
                            <p class="font-bold text-text-main-light">{{ $course->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-white rounded-xl border border-border-light">
                        <p class="text-sm text-text-sub-light font-bold">Description</p>
                        <p class="mt-2 text-text-main-light">{{ $course->description }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-text-main-light mb-4">Sessions à venir</h3>
                    @if($upcomingBookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-sub-light uppercase tracking-wider">Utilisateur</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-sub-light uppercase tracking-wider">Date/Heure</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-sub-light uppercase tracking-wider">Statut</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-sub-light uppercase tracking-wider">Lien de réunion</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($upcomingBookings as $booking)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $booking->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $booking->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($booking->meeting_link)
                                                    <a href="{{ $booking->meeting_link }}" target="_blank" class="text-primary hover:text-primary/80 font-bold">Rejoindre</a>
                                                @else
                                                    Non disponible
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-text-sub-light">Aucune session à venir pour ce cours.</p>
                    @endif
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-main-light mb-4">Sessions passées</h3>
                    @if($pastBookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-sub-light uppercase tracking-wider">Utilisateur</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-sub-light uppercase tracking-wider">Date/Heure</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-sub-light uppercase tracking-wider">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pastBookings as $booking)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $booking->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ $booking->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-text-sub-light">Aucune session passée pour ce cours.</p>
                    @endif
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-medium text-text-main-light mb-4">Créneaux horaires du cours</h3>
                    
                    @if (session('status') && str_contains(session('status'), 'Créneau'))
                        <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold mb-4">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="bg-white p-6 rounded-xl border border-border-light">
                        <h4 class="font-bold text-text-main-light mb-4">Ajouter un nouveau créneau</h4>
                        <form method="POST" action="{{ route('instructor.courses.slots.store', $course) }}" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Start Date Time -->
                                <div>
                                    <label for="start_datetime" class="block text-sm font-medium text-text-main-light mb-2">Date et heure de début</label>
                                    <input type="datetime-local" name="start_datetime" id="start_datetime" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required min="{{ now()->format('Y-m-d\TH:i') }}">
                                    @error('start_datetime')
                                        <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- End Date Time -->
                                <div>
                                    <label for="end_datetime" class="block text-sm font-medium text-text-main-light mb-2">Date et heure de fin</label>
                                    <input type="datetime-local" name="end_datetime" id="end_datetime" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                                    @error('end_datetime')
                                        <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="px-6 py-3 bg-secondary text-white rounded-xl font-bold hover:opacity-90 transition-all">
                                    Ajouter le créneau
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-6 bg-white p-6 rounded-xl border border-border-light">
                        <h4 class="font-bold text-text-main-light mb-4">Créneaux existants</h4>
                        @if($course->courseSlots->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Date/Heure de début</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Date/Heure de fin</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Statut</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($course->courseSlots as $slot)
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ \Carbon\Carbon::parse($slot->start_datetime)->format('d/m/Y H:i') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ \Carbon\Carbon::parse($slot->end_datetime)->format('d/m/Y H:i') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $slot->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $slot->is_available ? 'Disponible' : 'Indisponible' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <form action="{{ route('instructor.courses.slots.destroy', $slot) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-4 py-2 bg-red-100 text-secondary rounded-lg font-bold hover:bg-red-200 transition-all" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce créneau ?')">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-text-sub-light">Aucun créneau horaire défini pour ce cours.</p>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>