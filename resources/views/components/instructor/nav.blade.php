<nav class="flex flex-col gap-1">
    <a href="{{ route('instructor.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('instructor.dashboard') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">dashboard</span> Tableau de bord
    </a>
    <a href="{{ route('instructor.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('instructor.profile') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">person</span> Mon Profil
    </a>
    <a href="{{ route('instructor.courses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('instructor.courses.index') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">school</span> Mes Cours
    </a>
    <a href="{{ route('instructor.availabilities.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('instructor.availabilities.index') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">event_available</span> Mes Disponibilités
    </a>
    <a href="{{ route('instructor.one-time-slots.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('instructor.one-time-slots.index') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">video_library</span> Mes Meetings
    </a>
</nav>