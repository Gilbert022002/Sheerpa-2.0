@extends('layouts.admin')

@section('title', 'Modifier le Cours')

@section('content')
<div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
    <div class="mb-8">
        <a href="{{ route('admin.courses.index') }}" class="text-primary font-bold hover:underline flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined">arrow_back</span>
            Retour aux cours
        </a>
        <h1 class="text-2xl font-black text-text-main-light">Modifier le cours</h1>
        <p class="text-text-sub-light">Modifiez les informations du cours</p>
    </div>

    <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-text-main-light mb-2">Titre du cours *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                @error('title')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-text-main-light mb-2">Description *</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-text-main-light mb-2">Prix (€) *</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $course->price) }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                @error('price')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="duration" class="block text-sm font-medium text-text-main-light mb-2">Durée (minutes) *</label>
                <input type="number" name="duration" id="duration" value="{{ old('duration', $course->duration) }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                @error('duration')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="level" class="block text-sm font-medium text-text-main-light mb-2">Niveau *</label>
                <select name="level" id="level" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                    <option value="débutant" {{ old('level', $course->level) == 'débutant' ? 'selected' : '' }}>Débutant</option>
                    <option value="intermédiaire" {{ old('level', $course->level) == 'intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                    <option value="avancé" {{ old('level', $course->level) == 'avancé' ? 'selected' : '' }}>Avancé</option>
                </select>
                @error('level')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-text-main-light mb-2">Catégorie *</label>
                <select name="category_id" id="category_id" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="thumbnail" class="block text-sm font-medium text-text-main-light mb-2">Miniature du cours</label>
                @if($course->thumbnail)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Current thumbnail" class="h-32 object-cover rounded-xl">
                    </div>
                @endif
                <input type="file" name="thumbnail" id="thumbnail" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" accept="image/*">
                <p class="text-xs text-text-sub-light mt-1">Laisser vide pour conserver l'image actuelle</p>
                @error('thumbnail')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.courses.index') }}" class="px-6 py-3 bg-white border border-border-light text-text-main-light rounded-xl font-bold hover:bg-slate-50 transition-all">
                Annuler
            </a>
            <button type="submit" class="px-8 py-3 bg-secondary text-white rounded-xl font-bold hover:opacity-90 transition-all">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
