<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sheerpa - Calendrier de Réservation</title>
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
        .time-slot {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .time-slot:hover {
            background-color: #e0f7fa;
            transform: translateY(-2px);
        }
        .time-slot.booked {
            background-color: #ffebee;
            color: #b71c1c;
            cursor: not-allowed;
        }
        .time-slot.available {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
    </style>
</head>
<body class="bg-background-light text-text-main-light min-h-screen flex flex-col">
    <header class="flex items-center justify-between border-b border-solid border-border-light bg-card-light px-6 py-3 sticky top-0 z-50">
        <div class="flex items-center gap-8 w-full max-w-[1280px] mx-auto">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-bleu-sheerpa.png') }}" alt="Sheerpa Logo" class="h-12 w-auto object-contain">
                <span class="bg-primary/10 text-primary text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest">RÉSERVER UN RDV</span>
            </div>
            <div class="flex items-center gap-3 pl-6 border-l border-border-light">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-black">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-text-sub-light font-bold">{{ auth()->user()->role }}</p>
                </div>
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ auth()->user()->id }}" class="size-10 rounded-full bg-primary/5 object-cover" alt="Profile">
            </div>
        </div>
    </header>

    <div class="flex flex-1 w-full max-w-[1280px] mx-auto">
        <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">
            <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
                <div class="mb-8">
                    <h1 class="text-2xl font-black text-text-main-light">Réserver un rendez-vous</h1>
                    <p class="text-text-sub-light">Sélectionnez un créneau disponible pour votre session de coaching</p>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-bold text-text-main-light mb-4">Sélectionnez un coach</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($guides as $guide)
                        <div class="border border-border-light rounded-xl p-4 flex items-center gap-4 hover:bg-primary/5 transition-all cursor-pointer guide-option {{ $loop->first ? 'selected' : '' }}" 
                             data-guide-id="{{ $guide->id }}">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $guide->id }}" class="size-12 rounded-full bg-primary/5 object-cover" alt="Profile">
                            <div>
                                <p class="font-bold text-text-main-light">{{ $guide->name }}</p>
                                <p class="text-xs text-text-sub-light">{{ $guide->experience }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-bold text-text-main-light mb-4">Sélectionnez une date</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-7 gap-2">
                        @for($i = 0; $i < 14; $i++)
                            @php
                                $date = \Carbon\Carbon::now()->addDays($i);
                                $isToday = $date->isToday();
                            @endphp
                            <div class="border border-border-light rounded-xl p-3 text-center cursor-pointer date-option {{ $i === 0 ? 'selected bg-primary/10 border-primary' : 'hover:bg-primary/5' }}"
                                 data-date="{{ $date->format('Y-m-d') }}">
                                <p class="text-xs font-bold text-text-sub-light">{{ $date->format('D') }}</p>
                                <p class="font-bold text-text-main-light">{{ $date->format('j') }}</p>
                                <p class="text-xs text-text-sub-light">{{ $date->format('M') }}</p>
                                @if($isToday)
                                <span class="text-[10px] text-primary font-bold">Aujourd'hui</span>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-bold text-text-main-light mb-4">Sélectionnez un créneau horaire</h2>
                    <div id="time-slots-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        <!-- Time slots will be loaded here via AJAX -->
                        <p class="col-span-full text-center text-text-sub-light py-8">Sélectionnez un coach et une date pour voir les créneaux disponibles</p>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button id="confirm-booking-btn" class="px-6 py-3 bg-secondary text-white rounded-xl font-bold hover:opacity-90 transition-all" disabled>
                        Confirmer la réservation
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Hidden form for booking submission -->
    <form id="booking-form" method="POST" action="{{ route('user.bookings.create') }}" style="display: none;">
        @csrf
        <input type="hidden" name="guide_id" id="form-guide-id" value="">
        <input type="hidden" name="start_datetime" id="form-start-datetime" value="">
        <input type="hidden" name="end_datetime" id="form-end-datetime" value="">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedGuideId = null;
            let selectedDate = null;
            let selectedTimeSlot = null;
            
            // Select guide
            const guideOptions = document.querySelectorAll('.guide-option');
            guideOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    guideOptions.forEach(opt => opt.classList.remove('selected'));
                    
                    // Add selected class to clicked option
                    this.classList.add('selected');
                    
                    // Set selected guide ID
                    selectedGuideId = this.getAttribute('data-guide-id');
                    
                    // Load time slots for selected date if date is already selected
                    if (selectedDate) {
                        loadTimeSlots(selectedGuideId, selectedDate);
                    }
                });
            });
            
            // Select date
            const dateOptions = document.querySelectorAll('.date-option');
            dateOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    dateOptions.forEach(opt => opt.classList.remove('selected', 'bg-primary/10', 'border-primary'));
                    
                    // Add selected class to clicked option
                    this.classList.add('selected', 'bg-primary/10', 'border-primary');
                    
                    // Set selected date
                    selectedDate = this.getAttribute('data-date');
                    
                    // Load time slots if guide is already selected
                    if (selectedGuideId) {
                        loadTimeSlots(selectedGuideId, selectedDate);
                    }
                });
            });
            
            // Confirm booking button
            const confirmBtn = document.getElementById('confirm-booking-btn');
            confirmBtn.addEventListener('click', function() {
                if (selectedGuideId && selectedDate && selectedTimeSlot) {
                    // Fill the hidden form with selected values
                    document.getElementById('form-guide-id').value = selectedGuideId;
                    document.getElementById('form-start-datetime').value = selectedTimeSlot.start_datetime;
                    document.getElementById('form-end-datetime').value = selectedTimeSlot.end_datetime;
                    
                    // Submit the form
                    document.getElementById('booking-form').submit();
                }
            });
            
            // Function to load time slots via AJAX
            function loadTimeSlots(guideId, date) {
                // Show loading state
                document.getElementById('time-slots-container').innerHTML = '<p class="col-span-full text-center text-text-sub-light py-8">Chargement des créneaux...</p>';
                
                // Make AJAX request to get available time slots
                fetch(`/api/available-slots/${guideId}/${date}`)
                    .then(response => response.json())
                    .then(data => {
                        displayTimeSlots(data.slots);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('time-slots-container').innerHTML = '<p class="col-span-full text-center text-secondary py-8">Erreur lors du chargement des créneaux</p>';
                    });
            }
            
            // Function to display time slots
            function displayTimeSlots(slots) {
                const container = document.getElementById('time-slots-container');
                
                if (slots.length === 0) {
                    container.innerHTML = '<p class="col-span-full text-center text-text-sub-light py-8">Aucun créneau disponible pour cette date</p>';
                    return;
                }
                
                container.innerHTML = '';
                
                slots.forEach(slot => {
                    const slotElement = document.createElement('div');
                    slotElement.className = `time-slot rounded-xl p-3 border text-center ${slot.is_booked ? 'booked border-red-200' : 'available border-green-200'}`;
                    slotElement.innerHTML = `
                        <p class="font-bold">${slot.time_range}</p>
                        <p class="text-xs mt-1">${slot.is_booked ? 'Occupé' : 'Disponible'}</p>
                    `;
                    
                    if (!slot.is_booked) {
                        slotElement.addEventListener('click', function() {
                            // Remove selected class from all time slots
                            document.querySelectorAll('.time-slot').forEach(ts => ts.classList.remove('ring-2', 'ring-primary'));
                            
                            // Add selected class to clicked time slot
                            this.classList.add('ring-2', 'ring-primary');
                            
                            // Set selected time slot
                            selectedTimeSlot = slot;
                            
                            // Enable confirm button
                            document.getElementById('confirm-booking-btn').disabled = false;
                        });
                    }
                    
                    container.appendChild(slotElement);
                });
            }
        });
    </script>
</body>
</html>