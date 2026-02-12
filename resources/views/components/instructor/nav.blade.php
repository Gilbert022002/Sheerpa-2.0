<nav class="flex flex-col gap-1">
    <a href="{{ route('instructor.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('instructor.dashboard') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">dashboard</span> Tableau de bord
    </a>
    <a href="{{ route('instructor.courses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('instructor.courses.*') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">school</span> Mes Cours
    </a>
    <a href="{{ route('instructor.availabilities.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('instructor.availabilities.*') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">event_available</span> Mes Disponibilités
    </a>
    <a href="{{ route('instructor.meetings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('instructor.meetings.*') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">video_library</span> Mes Meetings
    </a>
    <a href="{{ route('instructor.one-time-slots.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('instructor.one-time-slots.*') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">event_note</span> Créneaux ponctuels
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all">
        <span class="material-symbols-outlined">groups</span> Participants
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all">
        <span class="material-symbols-outlined">payments</span> Revenus
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all">
        <span class="material-symbols-outlined">settings</span> Paramètres
    </a>
</nav>