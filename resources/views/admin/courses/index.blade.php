@extends('layouts.admin')

@section('title', 'Gestion des Cours')

@section('content')
<div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-text-main-light">Gestion des Cours</h1>
            <p class="text-text-sub-light">Gérez tous les cours de la plateforme</p>
        </div>
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
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Miniature</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Titre</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Catégorie</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Instructeur</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Prix</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($courses as $course)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail" class="h-16 w-16 object-cover rounded-lg">
                            @else
                                <div class="bg-slate-200 border-2 border-dashed rounded-xl w-16 h-16 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-slate-400">school</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-text-main-light">{{ $course->title }}</div>
                            <div class="text-sm text-text-sub-light">{{ Str::limit($course->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($course->categoryModel)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary/10 text-primary">
                                    {{ $course->categoryModel->name }}
                                </span>
                            @else
                                <span class="text-text-sub-light">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ $course->guide->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light font-bold">{{ $course->price }} €</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.courses.edit', $course) }}" class="px-4 py-2 bg-primary/10 text-primary rounded-lg font-bold hover:bg-primary/20 transition-all">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">
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
                        <td colspan="6" class="px-6 py-12 text-center text-text-sub-light">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-4">school</span>
                                <p class="text-lg font-bold">Aucun cours trouvé</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($courses->hasPages())
        <div class="mt-6">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection
