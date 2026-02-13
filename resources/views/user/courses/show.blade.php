@extends('layouts.user')

@section('title', 'Sheerpa - Détails du cours')

@section('content')
<div class="flex flex-1 w-full max-w-[1280px] mx-auto">
    <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">

        @if (session('status'))
            <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl font-bold">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
            
            {{-- Thumbnail --}}
            @if($course->thumbnail)
                <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                     alt="Thumbnail" 
                     class="w-full h-64 object-cover rounded-xl mb-6">
            @else
                <div class="bg-slate-200 border-2 border-dashed rounded-xl w-full h-64 flex items-center justify-center mb-6">
                    <span class="text-slate-500 text-lg">Aucune miniature</span>
                </div>
            @endif

            <div class="mb-8">
                <h1 class="text-2xl font-black text-text-main-light">
                    {{ $course->title }}
                </h1>
                <p class="text-text-sub-light">
                    {{ $course->description }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="p-4 bg-white rounded-xl border border-border-light">
                    <p class="text-sm text-text-sub-light font-bold">Prix</p>
                    <p class="font-bold text-text-main-light">
                        {{ $course->price }} €
                    </p>
                </div>

                <div class="p-4 bg-white rounded-xl border border-border-light">
                    <p class="text-sm text-text-sub-light font-bold">Durée</p>
                    <p class="font-bold text-text-main-light">
                        {{ $course->duration }} minutes
                    </p>
                </div>

                <div class="p-4 bg-white rounded-xl border border-border-light flex items-center gap-3">
                    <img 
                        src="{{ $course->guide->profile_image 
                                ? asset('storage/' . $course->guide->profile_image) 
                                : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $course->guide->id }}" 
                        class="size-10 rounded-full">
                    <div>
                        <p class="text-sm text-text-sub-light font-bold">Instructeur</p>
                        <p class="font-bold text-text-main-light">
                            {{ $course->guide->name }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- Créneaux --}}
            <div class="mb-8">
                <h2 class="text-xl font-black text-text-main-light mb-4">
                    Créneaux disponibles
                </h2>

                <p class="text-text-sub-light mb-4">
                    Cliquez sur "Réserver" pour le créneau qui vous convient.
                </p>

                @if(count($availableSlots) > 0)
                    <div class="space-y-4">
                        @foreach($availableSlots as $slot)
                            <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-border-light">
                                <div>
                                    <p class="font-bold text-text-main-light">
                                        {{ \Carbon\Carbon::parse($slot->start_datetime)->format('d/m/Y H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($slot->end_datetime)->format('H:i') }}
                                    </p>
                                </div>

                                <form method="POST" action="{{ route('user.courses.book', $course) }}">
                                    @csrf
                                    <input type="hidden" name="start_datetime" value="{{ $slot->start_datetime }}">
                                    <button type="submit"
                                            class="px-4 py-2 bg-secondary text-white rounded-lg font-bold hover:opacity-90 transition-all">
                                        Réserver
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 bg-white rounded-xl border border-border-light text-center">
                        <p class="text-text-sub-light">
                            Aucun créneau disponible pour le moment.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </main>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'fr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        height: 650,
        slotMinTime: '08:00:00',
        slotMaxTime: '20:00:00',
        events: [
            @foreach($availableSlots as $slot)
            {
                title: 'Créneau disponible',
                start: '{{ \Carbon\Carbon::parse($slot->start_datetime)->toISOString() }}',
                end: '{{ \Carbon\Carbon::parse($slot->end_datetime)->toISOString() }}'
            },
            @endforeach
        ]
    });

    calendar.render();
});
</script>
@endsection
