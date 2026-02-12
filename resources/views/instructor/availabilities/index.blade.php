<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sheerpa Guide - Mes Disponibilités</title>
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
                    <h1 class="text-2xl font-black text-text-main-light">Mes Disponibilités</h1>
                    <p class="text-text-sub-light">Gérez vos disponibilités récurrentes et ponctuelles</p>
                </div>

                <div class="mb-12 bg-slate-50 rounded-2xl p-6 border border-border-light">
                    <h2 class="text-lg font-bold text-text-main-light mb-4">Ajouter une nouvelle disponibilité récurrente</h2>
                    <form method="POST" action="{{ route('instructor.availabilities.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Day of Week -->
                            <div>
                                <label for="day_of_week" class="block text-sm font-medium text-text-main-light mb-2">Jour de la semaine</label>
                                <select name="day_of_week" id="day_of_week" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                                    <option value="0">Dimanche</option>
                                    <option value="1">Lundi</option>
                                    <option value="2">Mardi</option>
                                    <option value="3">Mercredi</option>
                                    <option value="4">Jeudi</option>
                                    <option value="5">Vendredi</option>
                                    <option value="6">Samedi</option>
                                </select>
                                @error('day_of_week')
                                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Time -->
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-text-main-light mb-2">Heure de début</label>
                                <input type="time" name="start_time" id="start_time" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" value="{{ old('start_time') }}" required>
                                @error('start_time')
                                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Time -->
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-text-main-light mb-2">Heure de fin</label>
                                <input type="time" name="end_time" id="end_time" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" value="{{ old('end_time') }}" required>
                                @error('end_time')
                                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="px-6 py-3 bg-secondary text-white rounded-xl font-bold hover:opacity-90 transition-all">
                                Ajouter la disponibilité
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mb-12">
                    <h2 class="text-lg font-bold text-text-main-light mb-4">Disponibilités actuelles (Liste)</h2>
                    <div class="overflow-x-auto rounded-2xl border border-border-light">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Jour</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Début</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Fin</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($availabilities as $availability)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">
                                            @php
                                                $days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                                echo $days[$availability->day_of_week];
                                            @endphp
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ \Carbon\Carbon::parse($availability->start_time)->format('H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ \Carbon\Carbon::parse($availability->end_time)->format('H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $availability->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $availability->is_active ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('instructor.availabilities.destroy', $availability) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-100 text-secondary rounded-lg font-bold hover:bg-red-200 transition-all" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette disponibilité ?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-text-sub-light">
                                            <div class="flex flex-col items-center justify-center">
                                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-4">event_available</span>
                                                <p class="text-lg font-bold">Aucune disponibilité définie</p>
                                                <p class="mt-2">Commencez par ajouter vos disponibilités récurrentes</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mb-12">
                    <h2 class="text-lg font-bold text-text-main-light mb-4">Calendrier des Disponibilités</h2>
                    <div id='calendar' class="bg-white p-4 rounded-xl border border-border-light"></div>
                </div>

                <div>
                    <h2 class="text-lg font-bold text-text-main-light mb-4">Créneaux ponctuels</h2>
                    <p class="mb-4 text-text-sub-light">En plus des disponibilités récurrentes ci-dessus, vous pouvez définir des créneaux ponctuels pour des sessions One-to-One.</p>
                    <a href="{{ route('instructor.one-time-slots.index') }}" class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all inline-flex items-center gap-2">
                        <span class="material-symbols-outlined">event_note</span>
                        Gérer les créneaux ponctuels
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script> <!-- Added FullCalendar JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                // Events will be fetched from a route later
                events: []
            });
            calendar.render();
        });
    </script>
</body>
</html>

