@extends('layouts.user')

@section('title', $tutor->name . ' - Sheerpa Tutor')

@section('content')
    <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
        <div class="flex flex-col md:flex-row items-start gap-8">
            <div class="relative">
                <img src="{{ $tutor->profile_image ? asset('storage/' . $tutor->profile_image) . '?' . time() : asset('images/default/profile-default.jpg') }}" class="size-28 rounded-full bg-primary/5 object-cover" alt="{{ $tutor->name }}">
            </div>
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-2xl font-black">{{ $tutor->name }}</h2>
                <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-2 text-text-sub-light text-sm font-medium">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-base">mail</span> {{ $tutor->email }}</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-base">person</span> {{ $tutor->role }}</span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">grade</span>
                        @if($tutor->instructor_status === 'approved')
                            <span class="text-green-600">Tuteur certifié</span>
                        @elseif($tutor->instructor_status === 'pending')
                            <span class="text-yellow-600">En attente de vérification</span>
                        @elseif($tutor->instructor_status === 'rejected')
                            <span class="text-red-600">Demande rejetée</span>
                        @else
                            <span>Statut inconnu</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow">
                <h3 class="font-bold text-lg mb-4">Informations personnelles</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Nom complet</span>
                        <span class="font-medium">{{ $tutor->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Email</span>
                        <span class="font-medium">{{ $tutor->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Téléphone</span>
                        <span class="font-medium">{{ $tutor->phone ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Spécialité</span>
                        <span class="font-medium">{{ $tutor->specialty ?? 'Non renseigné' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow">
                <h3 class="font-bold text-lg mb-4">À propos de moi</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-text-sub-light font-medium mb-1">Biographie :</p>
                        <p class="text-text-sub-light">
                            {{ $tutor->bio ?? 'Aucune description fournie. Ce tuteur n\'a pas encore ajouté de biographie.' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-text-sub-light font-medium mb-1">Expérience :</p>
                        <p class="text-text-sub-light">
                            {{ $tutor->experience ?? 'Aucune information sur l\'expérience fournie.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-black mb-4">Cours de {{ $tutor->name }}</h3>
            @if($courses->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($courses as $course)
                        <article class="bg-card-light rounded-3xl border border-border-light overflow-hidden soft-shadow transition-transform hover:-translate-y-1">
                            <div class="h-40 bg-slate-100 relative">
                                <div class="absolute inset-0 flex items-center justify-center opacity-20">
                                    <span class="material-symbols-outlined text-6xl">school</span>
                                </div>
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                                @endif
                            </div>
                            <div class="p-5">
                                <h4 class="font-black text-base mb-2 leading-tight">{{ $course->title }}</h4>
                                <p class="text-sm text-text-sub-light mb-4 line-clamp-2">{{ Str::limit($course->description, 80) }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-primary">{{ $course->price }} €</span>
                                    <span class="text-sm text-text-sub-light">{{ $course->duration }} min</span>
                                </div>
                                <div class="flex items-center gap-3 pt-4 border-t border-border-light mt-4">
                                    <img src="{{ $tutor->profile_image ? asset('storage/' . $tutor->profile_image) : asset('images/default/profile-default.jpg') }}" class="size-8 rounded-full">
                                    <span class="text-sm font-bold text-text-sub-light">{{ $tutor->name }} <span class="text-primary">• Tuteur</span></span>
                                </div>
                                <a href="{{ route('user.courses.show', $course) }}" class="mt-4 block px-4 py-2 bg-primary text-white rounded-xl text-center font-bold hover:bg-primary/90 transition-all text-sm">
                                    Voir le cours
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-text-sub-light">Ce tuteur n'a pas encore publié de cours.</p>
                </div>
            @endif
        </div>
    </div>
@endsection