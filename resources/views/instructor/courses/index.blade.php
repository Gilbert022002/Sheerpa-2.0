@extends('layouts.instructor')

@section('title', 'Sheerpa Guide - Mes Cours')

@section('content')
    <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-black text-text-main-light">Mes Cours</h1>
                <p class="text-text-sub-light">Gérez vos cours et formations</p>
            </div>
            <a href="{{ route('instructor.courses.create') }}" class="flex items-center gap-2 px-6 py-4 bg-secondary text-white rounded-2xl font-bold hover:scale-[1.02] active:scale-[0.98] transition-all soft-shadow">
                <span class="material-symbols-outlined">add_box</span>
                Créer un cours
            </a>
        </div>

        @if (session('status'))
            <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold mb-4">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-2xl border border-border-light">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Cours</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Catégorie</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Prix</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Participants</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($courses as $course)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12 rounded-lg bg-slate-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-slate-500">school</span>
                                </div>
                                <div class="ml-4">
                                    <div class="font-bold text-sm text-text-main-light group-hover:text-primary transition-colors">{{ $course->title }}</div>
                                    <div class="text-xs text-text-sub-light">{{ $course->duration }} min</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-text-sub-light">
                            <div class="text-sm">{{ $course->category }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">
                            <div class="text-sm font-bold">{{ $course->price }} €</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">
                            <div class="text-sm">{{ $course->bookings_count }} inscrits</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Publié
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="{{ route('instructor.courses.show', $course) }}" class="p-2 text-text-sub-light hover:text-primary transition-colors hover:bg-primary/5 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                                <a href="{{ route('instructor.courses.edit', $course) }}" class="p-2 text-text-sub-light hover:text-secondary transition-colors hover:bg-secondary/5 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <form method="POST" action="{{ route('instructor.courses.destroy', $course) }}" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-text-sub-light hover:text-red-600 transition-colors hover:bg-red-50 rounded-lg" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-text-sub-light">
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
@endsection