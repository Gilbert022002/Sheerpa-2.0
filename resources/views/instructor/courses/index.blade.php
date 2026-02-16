@extends('layouts.instructor')

@section('title', 'Sheerpa Guide - Mes Cours')

@section('content')
            @if (session('status'))
                <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-2xl font-black text-text-main-light">Mes Cours</h1>
                        <p class="text-text-sub-light">Gérez vos cours et formations</p>
                    </div>
                    <a href="{{ route('instructor.courses.create') }}" class="px-6 py-3 bg-secondary text-white rounded-2xl font-bold hover:opacity-90 transition-all">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined">add_box</span>
                            Créer un cours
                        </span>
                    </a>
                </div>

                <div class="overflow-x-auto rounded-2xl border border-border-light">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Miniature</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Titre</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Prix</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Durée (min)</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Réservations</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($courses as $course)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($course->thumbnail)
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail" class="h-16 w-16 object-cover rounded-lg">
                                        @else
                                            <div class="bg-slate-200 border-2 border-dashed rounded-xl w-16 h-16 flex items-center justify-center">
                                                <span class="text-slate-500 text-xs">Aucune</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-text-main-light">{{ $course->title }}</div>
                                        <div class="text-sm text-text-sub-light">{{ Str::limit($course->description, 60) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-text-main-light font-bold">{{ $course->price }} €</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ $course->duration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ $course->bookings_count }} réservations</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('instructor.courses.show', $course) }}" class="px-4 py-2 bg-primary/10 text-primary rounded-lg font-bold hover:bg-primary/20 transition-all">
                                                Détails
                                            </a>
                                            <a href="{{ route('instructor.courses.edit', $course) }}" class="px-4 py-2 bg-slate-100 text-text-main-light rounded-lg font-bold hover:bg-slate-200 transition-all">
                                                Modifier
                                            </a>
                                            <form action="{{ route('instructor.courses.destroy', $course) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-100 text-secondary rounded-lg font-bold hover:bg-red-200 transition-all" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-text-sub-light">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="material-symbols-outlined text-4xl text-slate-300 mb-4">school</span>
                                            <p class="text-lg font-bold">Aucun cours créé pour le moment</p>
                                            <p class="mt-2">Commencez par créer votre premier cours</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
@endsection
