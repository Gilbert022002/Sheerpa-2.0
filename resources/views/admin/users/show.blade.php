@extends('layouts.admin')

@section('title', 'Profil Utilisateur - ' . $user->name)

@section('content')
<div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
    <div class="flex justify-between items-start mb-8">
        <div>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-text-sub-light hover:text-primary transition-colors mb-4">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Retour à la liste
            </a>
            <h1 class="text-2xl font-black text-text-main-light">Profil Utilisateur</h1>
            <p class="text-text-sub-light">Détails de l'utilisateur</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:opacity-90 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined">edit</span>
                Modifier
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-xl font-bold mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Profile Card --}}
        <div class="md:col-span-1">
            <div class="bg-slate-50 rounded-2xl p-6 text-center">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" class="size-24 rounded-full mx-auto mb-4 object-cover shadow-md" alt="{{ $user->name }}">
                @else
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $user->id }}" class="size-24 rounded-full mx-auto mb-4 bg-slate-100" alt="{{ $user->name }}">
                @endif
                <h2 class="text-xl font-black text-text-main-light">{{ $user->name }}</h2>
                <p class="text-sm text-text-sub-light font-medium">{{ $user->email }}</p>
                
                <div class="mt-4 flex flex-wrap gap-2 justify-center">
                    @if($user->role === 'admin')
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 text-[10px] font-black rounded-full uppercase">Admin</span>
                    @elseif($user->role === 'instructor')
                        @if($user->instructor_status === 'approved')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase">Guide Certifié</span>
                        @elseif($user->instructor_status === 'pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-black rounded-full uppercase">En attente</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-black rounded-full uppercase">Rejeté</span>
                        @endif
                    @else
                        <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-black rounded-full uppercase">Utilisateur</span>
                    @endif
                </div>

                <div class="mt-6 pt-6 border-t border-border-light space-y-3">
                    <div class="flex items-center justify-center gap-2 text-sm text-text-sub-light">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        <span>Inscrit le {{ $user->created_at->isoFormat('DD MMMM YYYY') }}</span>
                    </div>
                    @if($user->phone)
                        <div class="flex items-center justify-center gap-2 text-sm text-text-sub-light">
                            <span class="material-symbols-outlined text-sm">phone</span>
                            <span>{{ $user->phone }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- User Details --}}
        <div class="md:col-span-2 space-y-6">
            <div class="bg-slate-50 rounded-2xl p-6">
                <h3 class="text-lg font-black mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    Informations personnelles
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mb-1">Nom complet</p>
                        <p class="text-sm font-bold text-text-main-light">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mb-1">Email</p>
                        <p class="text-sm font-bold text-text-main-light">{{ $user->email }}</p>
                    </div>
                    @if($user->phone)
                        <div>
                            <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mb-1">Téléphone</p>
                            <p class="text-sm font-bold text-text-main-light">{{ $user->phone }}</p>
                        </div>
                    @endif
                    @if($user->specialty)
                        <div>
                            <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mb-1">Spécialité</p>
                            <p class="text-sm font-bold text-text-main-light">{{ $user->specialty }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mb-1">Rôle</p>
                        <p class="text-sm font-bold text-text-main-light capitalize">{{ ucfirst($user->role) }}</p>
                    </div>
                    @if($user->role === 'instructor')
                        <div>
                            <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mb-1">Statut Guide</p>
                            <p class="text-sm font-bold text-text-main-light capitalize">{{ ucfirst($user->instructor_status) }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($user->bio || $user->experience)
                <div class="bg-slate-50 rounded-2xl p-6">
                    <h3 class="text-lg font-black mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">description</span>
                        À propos
                    </h3>
                    @if($user->bio)
                        <div class="mb-4">
                            <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mb-2">Bio</p>
                            <p class="text-sm text-text-main-light leading-relaxed">{{ $user->bio }}</p>
                        </div>
                    @endif
                    @if($user->experience)
                        <div>
                            <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mb-2">Expérience</p>
                            <p class="text-sm text-text-main-light leading-relaxed">{{ $user->experience }}</p>
                        </div>
                    @endif
                </div>
            @endif

            @if($user->role === 'instructor')
                <div class="bg-slate-50 rounded-2xl p-6">
                    <h3 class="text-lg font-black mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">account_balance</span>
                        Informations de paiement
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($user->stripe_account_id)
                            <div>
                                <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mb-1">Stripe ID</p>
                                <p class="text-sm font-mono text-text-main-light">{{ $user->stripe_account_id }}</p>
                            </div>
                        @endif
                        @if($user->presentation_video_url)
                            <div>
                                <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mb-1">Vidéo de présentation</p>
                                <a href="{{ $user->presentation_video_url }}" target="_blank" class="text-sm text-primary font-bold hover:underline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">play_circle</span>
                                    Voir la vidéo
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 rounded-2xl p-4 text-center">
                    <p class="text-2xl font-black text-primary">{{ $user->bookings->count() }}</p>
                    <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mt-1">Réservations</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4 text-center">
                    <p class="text-2xl font-black text-secondary">{{ $user->receivedBookings->count() }}</p>
                    <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mt-1">Sessions données</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4 text-center">
                    <p class="text-2xl font-black text-blue-500">{{ $user->favorites->count() }}</p>
                    <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mt-1">Favoris</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4 text-center">
                    <p class="text-2xl font-black text-green-500">{{ $user->courses->count() }}</p>
                    <p class="text-[10px] text-text-sub-light font-bold uppercase tracking-widest mt-1">Cours créés</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
