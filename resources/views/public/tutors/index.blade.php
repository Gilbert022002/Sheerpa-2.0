@extends('layouts.user')

@section('title', 'Trouver un tuteur - Sheerpa')

@section('content')
    <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-text-main-light">Trouver un tuteur</h1>
            <p class="text-text-sub-light">Parcourez notre liste de tuteurs certifiés</p>
        </div>

        @if($tutors->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tutors as $tutor)
                    <article class="bg-card-light rounded-3xl border border-border-light overflow-hidden soft-shadow transition-transform hover:-translate-y-1">
                        <div class="h-40 bg-slate-100 relative">
                            @if($tutor->profile_image)
                                <img src="{{ asset('storage/' . $tutor->profile_image) . '?' . time() }}" class="w-full h-full object-cover" alt="{{ $tutor->name }}">
                            @else
                                <div class="w-full h-full bg-primary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-6xl text-primary">person</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h4 class="font-black text-lg mb-2 leading-tight">{{ $tutor->name }}</h4>
                            <p class="text-sm text-text-sub-light mb-4">{{ $tutor->specialty ?? 'Spécialité non spécifiée' }}</p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm font-bold text-primary">{{ $tutor->courses_count }} cours</span>
                                <span class="text-sm text-text-sub-light">
                                    @if($tutor->instructor_status === 'approved')
                                        <span class="text-green-600">Certifié</span>
                                    @else
                                        <span class="text-yellow-600">Non certifié</span>
                                    @endif
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-3 pt-4 border-t border-border-light">
                                <img src="{{ $tutor->profile_image ? asset('storage/' . $tutor->profile_image) : asset('images/default/profile-default.jpg') }}" class="size-8 rounded-full">
                                <span class="text-sm font-bold text-text-sub-light">{{ $tutor->name }}</span>
                            </div>
                            
                            <a href="{{ route('user.tutors.show', $tutor) }}" class="mt-4 block px-4 py-2 bg-primary text-white rounded-xl text-center font-bold hover:bg-primary/90 transition-all text-sm">
                                Voir le profil
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">groups</span>
                <h3 class="text-xl font-bold text-text-main-light mb-2">Aucun tuteur trouvé</h3>
                <p class="text-text-sub-light">Nous n'avons pas encore de tuteurs certifiés disponibles.</p>
            </div>
        @endif
    </div>
@endsection