<nav class="flex flex-col gap-1">
    <a href="{{ route('user.courses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.courses.index') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">school</span> Explorer les cours
    </a>
    <a href="{{ route('user.bookings.one-to-one.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.bookings.one-to-one.index') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">schedule</span> Réserver un RDV
    </a>
    <a href="{{ route('user.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.bookings.index') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">calendar_today</span> Mes réservations
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all">
        <span class="material-symbols-outlined">groups</span> Mes mentors
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all">
        <span class="material-symbols-outlined">payments</span> Paiements
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all">
        <span class="material-symbols-outlined">settings</span> Paramètres
    </a>
</nav>