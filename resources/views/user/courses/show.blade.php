<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sheerpa - Détails du cours</title>
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
            @if (session('status'))
                <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl font-bold mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
                <div class="mb-8">
                    <h1 class="text-2xl font-black text-text-main-light">{{ $course->title }}</h1>
                    <p class="text-text-sub-light">{{ $course->description }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="p-4 bg-white rounded-xl border border-border-light">
                        <p class="text-sm text-text-sub-light font-bold">Prix</p>
                        <p class="font-bold text-text-main-light">{{ $course->price }} €</p>
                    </div>
                    <div class="p-4 bg-white rounded-xl border border-border-light">
                        <p class="text-sm text-text-sub-light font-bold">Durée</p>
                        <p class="font-bold text-text-main-light">{{ $course->duration }} minutes</p>
                    </div>
                    <div class="p-4 bg-white rounded-xl border border-border-light">
                        <p class="text-sm text-text-sub-light font-bold">Instructeur</p>
                        <p class="font-bold text-text-main-light">{{ $course->guide->name }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-black text-text-main-light mb-4">Réserver un créneau</h2>
                    <p class="text-text-sub-light mb-4">Sélectionnez une date et une heure pour réserver ce cours.</p>

                    <form method="POST" action="{{ route('user.courses.book', $course) }}">
                        @csrf
                        <div class="mb-6">
                            <label for="start_datetime" class="block text-sm font-medium text-text-main-light mb-2">Date et heure du rendez-vous</label>
                            <input type="datetime-local" name="start_datetime" id="start_datetime" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                            @error('start_datetime')
                                <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="px-6 py-3 bg-secondary text-white rounded-xl font-bold hover:opacity-90 transition-all">
                            Réserver maintenant
                        </button>
                    </form>
                </div>

                <div>
                    <h2 class="text-xl font-black text-text-main-light mb-4">Disponibilités de l'instructeur</h2>
                    <div id="calendar" class="bg-white p-4 rounded-xl border border-border-light"></div>
                </div>
            </div>
        </main>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                selectable: true,
                selectMirror: true,
                select: function(info) {
                    // Format the selected time for the input field
                    const startFormatted = info.startStr.replace('T', ' ').substring(0, 16);
                    
                    // Update the hidden input field with the selected time
                    document.getElementById('start_datetime').value = startFormatted;
                    
                    // Highlight the selected slot
                    calendar.unselect(); // Clear selection
                },
                events: [
                    @foreach($availableSlots as $slot)
                    {
                        title: 'Créneau disponible',
                        start: '{{ $slot->toISOString() }}',
                        end: '{{ $slot->addMinutes($course->duration)->toISOString() }}',
                        backgroundColor: '#48bb78', // Green color for available slots
                        borderColor: '#38a169'
                    },
                    @endforeach
                ],
                eventClick: function(info) {
                    // When clicking on an event, set the input field to the event's start time
                    const startFormatted = info.event.start.toISOString().replace('T', ' ').substring(0, 16);
                    document.getElementById('start_datetime').value = startFormatted;
                },
                height: 650,
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5], // Monday to Friday
                    startTime: '08:00',
                    endTime: '18:00'
                },
                dayHeaderDidMount: function(info) {
                    // Highlight weekends
                    if ([0, 6].includes(info.date.getDay())) { // Sunday = 0, Saturday = 6
                        info.el.style.backgroundColor = '#f0fdf4';
                    }
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>
