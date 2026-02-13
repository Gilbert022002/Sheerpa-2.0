@extends('layouts.user')

@section('title', 'Sheerpa - Détails du cours')

@section('content')
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
            <div class="p-4 bg-white rounded-xl border border-border-light flex items-center gap-3">
                <img src="{{ $course->guide->profile_image ? asset('storage/' . $course->guide->profile_image) : asset('images/default/profile-default.jpg') }}" class="size-10 rounded-full">
                <div>
                    <p class="text-sm text-text-sub-light font-bold">Instructeur</p>
                    <p class="font-bold text-text-main-light">{{ $course->guide->name }}</p>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-black text-text-main-light mb-4">Créneaux disponibles</h2>
            <p class="text-text-sub-light mb-4">Voici les créneaux horaires disponibles pour ce cours. Cliquez sur "Réserver" pour le créneau qui vous convient.</p>

            @if(count($availableSlots) > 0)
                <div class="space-y-4">
                    @foreach($availableSlots as $slot)
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-border-light">
                            <div>
                                <p class="font-bold text-text-main-light">{{ \Carbon\Carbon::parse($slot->start_datetime)->format('d/m/Y H:i') }} - {{ \Carbon\Carbon::parse($slot->end_datetime)->format('H:i') }}</p>
                            </div>
                            <form method="POST" action="{{ route('user.courses.book', $course) }}">
                                @csrf
                                <input type="hidden" name="start_datetime" value="{{ $slot->start_datetime }}">
                                <button type="submit" class="px-4 py-2 bg-secondary text-white rounded-lg font-bold hover:opacity-90 transition-all">
                                    Réserver
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-6 bg-white rounded-xl border border-border-light text-center">
                    <p class="text-text-sub-light">Aucun créneau disponible pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
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
                        start: '{{ \Carbon\Carbon::parse($slot->start_datetime)->toISOString() }}',
                        end: '{{ \Carbon\Carbon::parse($slot->end_datetime)->toISOString() }}',
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
@endsection
