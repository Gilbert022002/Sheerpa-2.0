@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-text-main-light">Gestion des Catégories</h1>
            <p class="text-text-sub-light">Gérez les catégories de cours</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="px-6 py-3 bg-secondary text-white rounded-2xl font-bold hover:opacity-90 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">add</span>
            Nouvelle catégorie
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-xl font-bold mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded-xl font-bold mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-2xl border border-border-light">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Icône</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Nom</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Slug</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Description</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Cours</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Statut</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="material-symbols-outlined text-primary">{{ $category->icon }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-text-main-light">{{ $category->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-text-sub-light">{{ $category->slug }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-text-sub-light max-w-xs truncate">{{ Str::limit($category->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary/10 text-primary">
                                {{ $category->courses_count }} cours
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="px-4 py-2 bg-primary/10 text-primary rounded-lg font-bold hover:bg-primary/20 transition-all">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-100 text-secondary rounded-lg font-bold hover:bg-red-200 transition-all">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-text-sub-light">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-4">category</span>
                                <p class="text-lg font-bold">Aucune catégorie</p>
                                <p class="mt-2">Commencez par créer votre première catégorie</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
