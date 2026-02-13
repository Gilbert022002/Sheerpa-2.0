<nav class="flex flex-col gap-1">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">person</span> My Profile
    </a>
    <a href="{{ route('user.aspirations') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.aspirations') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">auto_awesome</span> My Aspirations
    </a>
    <a href="{{ route('user.courses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.courses.index') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">school</span> Parcourir les cours
    </a>
    <a href="{{ route('user.bookings.one-to-one.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.bookings.one-to-one.index') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">schedule</span> Réserver un RDV
    </a>
    <a href="{{ route('user.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.bookings.index') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">calendar_today</span> Mes Réservations
    </a>
    <a href="{{ route('user.invoices') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.invoices') ? 'bg-primary/10 text-primary font-bold' : 'text-text-sub-light hover:bg-white hover:text-primary' }} transition-all">
        <span class="material-symbols-outlined">receipt_long</span> Invoices
    </a>
</nav>