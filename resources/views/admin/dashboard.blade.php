@extends('layouts.admin')

@section('title', 'Sheerpa Admin - Dashboard')

@section('content')

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

    <section class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-text-main-light">Dashboard Administrateur 👋</h2>
            <p class="text-text-sub-light font-medium">Voici les statistiques de la plateforme.</p>
        </div>
    </section>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-primary/10 text-primary rounded-lg italic">
                    <span class="material-symbols-outlined">people</span>
                </div>
            </div>
            <p class="text-text-sub-light text-xs font-bold uppercase tracking-widest">Total Utilisateurs</p>
            <h3 class="text-2xl font-black mt-1">{{ $totalUsers }}</h3>
        </div>

        <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-secondary/10 text-secondary rounded-lg">
                    <span class="material-symbols-outlined">school</span>
                </div>
            </div>
            <p class="text-text-sub-light text-xs font-bold uppercase tracking-widest">Total Cours</p>
            <h3 class="text-2xl font-black mt-1">{{ $totalCourses }}</h3>
        </div>

        <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                    <span class="material-symbols-outlined">calendar_month</span>
                </div>
            </div>
            <p class="text-text-sub-light text-xs font-bold uppercase tracking-widest">Meetings ce mois</p>
            <h3 class="text-2xl font-black mt-1">{{ $meetingsThisMonth }}</h3>
        </div>

        <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                    <span class="material-symbols-outlined">person_check</span>
                </div>
            </div>
            <p class="text-text-sub-light text-xs font-bold uppercase tracking-widest">Guides certifiés</p>
            <h3 class="text-2xl font-black mt-1">{{ $approvedInstructors }}</h3>
        </div>
    </div>

    <section class="space-y-4">
        <h3 class="text-lg font-black px-2 flex items-center gap-2">
            <span class="size-2 bg-secondary rounded-full animate-pulse"></span>
            Guides en attente de validation
        </h3>
        @if($pendingInstructors->count() > 0)
            <div class="bg-card-light rounded-3xl border border-border-light overflow-hidden soft-shadow">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 text-text-sub-light text-[10px] font-black uppercase tracking-widest border-b border-border-light">
                                <th class="px-6 py-5">Guide</th>
                                <th class="px-6 py-5">Email</th>
                                <th class="px-6 py-5">Expérience</th>
                                <th class="px-6 py-5">Date demande</th>
                                <th class="px-6 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-light">
                            @foreach($pendingInstructors as $instructor)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $instructor->id }}" class="size-10 rounded-full bg-slate-100 shadow-sm" alt="{{ $instructor->name }}">
                                        <div>
                                            <p class="font-bold text-sm text-text-main-light">{{ $instructor->name }}</p>
                                            @if($instructor->specialty)
                                                <p class="text-[10px] text-text-sub-light font-bold uppercase mt-0.5">{{ $instructor->specialty }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-medium">{{ $instructor->email }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm text-text-main-light line-clamp-2 max-w-xs">{{ Str::limit($instructor->experience, 100) }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-bold">{{ $instructor->updated_at->isoFormat('DD MMM YYYY') }}</p>
                                    <p class="text-xs text-text-sub-light font-medium">{{ $instructor->updated_at->format('H:i') }}</p>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('admin.instructors.approve', $instructor) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Approuver">
                                                <span class="material-symbols-outlined text-lg">check_circle</span>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.instructors.reject', $instructor) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Rejeter">
                                                <span class="material-symbols-outlined text-lg">cancel</span>
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.users.show', $instructor) }}" class="p-2 text-text-sub-light hover:text-primary transition-colors hover:bg-primary/5 rounded-lg" title="Voir le profil">
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-card-light p-8 rounded-3xl border border-border-light soft-shadow relative overflow-hidden">
                <div class="relative z-10 text-center py-8">
                    <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">check_circle</span>
                    <h4 class="text-xl font-bold text-text-main-light mb-2">Aucune demande en attente</h4>
                    <p class="text-text-sub-light">Toutes les demandes de guides ont été traitées</p>
                </div>
            </div>
        @endif
    </section>

    <section class="space-y-4">
        <h3 class="text-lg font-black px-2">Derniers cours ajoutés</h3>
        <div class="bg-card-light rounded-3xl border border-border-light overflow-hidden soft-shadow">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-text-sub-light text-[10px] font-black uppercase tracking-widest border-b border-border-light">
                            <th class="px-6 py-5">Cours</th>
                            <th class="px-6 py-5">Guide</th>
                            <th class="px-6 py-5">Catégorie</th>
                            <th class="px-6 py-5">Prix</th>
                            <th class="px-6 py-5">Date création</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-light">
                        @forelse($recentCourses as $course)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    @if($course->thumbnail)
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="size-12 rounded-lg object-cover shadow-sm" alt="{{ $course->title }}">
                                    @else
                                        <div class="size-12 rounded-lg bg-primary/10 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-primary">school</span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-sm text-text-main-light group-hover:text-primary transition-colors">{{ $course->title }}</p>
                                        <p class="text-[10px] text-text-sub-light font-bold uppercase mt-0.5">{{ $course->level }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-medium">{{ $course->guide->name }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-black rounded-full uppercase">
                                    {{ $course->category }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-bold">{{ number_format($course->price, 2, ',', ' ') }} €</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-bold">{{ $course->created_at->isoFormat('DD MMM YYYY') }}</p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-3">school</span>
                                <p class="text-text-sub-light text-sm font-medium">Aucun cours disponible</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
>>>>>>> ed51202 (feat: admin updates before branch switch)
@endsection
