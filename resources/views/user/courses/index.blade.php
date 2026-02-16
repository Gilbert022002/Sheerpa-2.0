@extends('layouts.user')

@section('title', 'Sheerpa - Nos Cours')

@section('content')
<div class="flex flex-1 w-full max-w-[1280px] mx-auto">
    <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">
        <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
            
            <div class="mb-8">
                <h1 class="text-2xl font-black text-text-main-light">Nos Cours</h1>
                <p class="text-text-sub-light">Parcourez tous les cours disponibles</p>
            </div>

            @if (session('status'))
                <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold mb-4">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl font-bold mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($courses as $course)
                    <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow flex flex-col h-full">
                        
                        {{-- Thumbnail (Gilbert) --}}
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                                 alt="Thumbnail" 
                                 class="w-full h-40 object-cover rounded-xl mb-4">
                        @else
                            <div class="bg-slate-200 border-2 border-dashed rounded-xl w-full h-40 flex items-center justify-center mb-4">
                                <span class="text-slate-500 text-sm">Aucune miniature</span>
                            </div>
                        @endif

                        <h4 class="font-black text-lg mb-2 text-text-main-light">
                            {{ $course->title }}
                        </h4>

                        <p class="text-sm text-text-sub-light mb-4 flex-grow">
                            {{ Str::limit($course->description, 100) }}
                        </p>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-bold text-primary">
                                {{ $course->price }} €
                            </span>
                            <span class="text-sm text-text-sub-light">
                                {{ $course->duration }} min
                            </span>
                        </div>

                        {{-- Guide avec image profil (fusion des 2 versions) --}}
                        <div class="flex items-center gap-2 pt-4 border-t border-border-light">
                            <img
                                src="{{ $course->guide->profile_image
                                        ? asset('storage/' . $course->guide->profile_image)
                                        : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $course->guide->id }}"
                                class="size-8 rounded-full">
                            <a href="{{ route('user.tutors.show', $course->guide) }}" class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors">
                                {{ $course->guide->name }}
                            </a>
                        </div>

                        <a href="{{ route('user.courses.show', $course) }}" 
                           class="mt-4 px-4 py-3 bg-primary text-white rounded-xl text-center font-bold hover:bg-primary/90 transition-all">
                            Voir les détails et réserver
                        </a>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-8 rounded-2xl border border-border-light soft-shadow text-center text-text-sub-light">
                        <div class="flex flex-col items-center justify-center">
                            <span class="material-symbols-outlined text-4xl text-slate-300 mb-4">
                                school
                            </span>
                            <p class="text-lg font-bold">
                                Aucun cours disponible pour le moment
                            </p>
                            <p class="mt-2">
                                Revenez bientôt pour découvrir de nouveaux cours
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
                {{ $courses->links() }}
            </div>

        </div>
    </main>
</div>
@endsection
