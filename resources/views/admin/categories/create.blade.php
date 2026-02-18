@extends('layouts.admin')

@section('title', 'Créer une Catégorie')

@section('content')
<div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
    <div class="mb-8">
        <a href="{{ route('admin.categories.index') }}" class="text-primary font-bold hover:underline flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined">arrow_back</span>
            Retour aux catégories
        </a>
        <h1 class="text-2xl font-black text-text-main-light">Créer une nouvelle catégorie</h1>
        <p class="text-text-sub-light">Ajoutez une nouvelle catégorie de cours</p>
    </div>

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-text-main-light mb-2">Nom de la catégorie *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                @error('name')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-text-main-light mb-2">Slug (optionnel)</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" placeholder="laisser-vide-pour-generation-auto">
                <p class="text-xs text-text-sub-light mt-1">Laisser vide pour générer automatiquement</p>
                @error('slug')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-text-main-light mb-2">Description</label>
            <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" placeholder="Décrivez cette catégorie...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-secondary text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="icon" class="block text-sm font-medium text-text-main-light mb-2">Icône (Material Icons)</label>
                <input type="text" name="icon" id="icon" value="{{ old('icon', 'category') }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" placeholder="category">
                <p class="text-xs text-text-sub-light mt-1">Nom de l'icône Material Icons</p>
                @error('icon')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-end">
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="size-5 rounded border-border-light text-primary focus:ring-primary/20">
                    <label for="is_active" class="text-sm font-medium text-text-main-light">Catégorie active</label>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-white border border-border-light text-text-main-light rounded-xl font-bold hover:bg-slate-50 transition-all">
                Annuler
            </a>
            <button type="submit" class="px-8 py-3 bg-secondary text-white rounded-xl font-bold hover:opacity-90 transition-all">
                Créer la catégorie
            </button>
        </div>
    </form>
</div>
@endsection
