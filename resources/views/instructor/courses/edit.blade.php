@extends('layouts.instructor')

@section('title', 'Sheerpa Guide - Modifier un cours')

@section('content')
            @if (session('status'))
                <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
                <div class="mb-8">
                    <h1 class="text-2xl font-black text-text-main-light">Modifier le cours</h1>
                    <p class="text-text-sub-light">Mettez à jour les détails de votre cours</p>
                </div>

                <form method="POST" action="{{ route('instructor.courses.update', $course) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-text-main-light mb-2">Titre du cours</label>
                        <input type="text" name="title" id="title" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" value="{{ old('title', $course->title) }}" required autofocus>
                        @error('title')
                            <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-text-main-light mb-2">Description</label>
                        <textarea name="description" id="description" rows="5" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-text-main-light mb-2">Prix (€)</label>
                            <input type="number" step="0.01" name="price" id="price" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" value="{{ old('price', $course->price) }}" required>
                            @error('price')
                                <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-text-main-light mb-2">Durée (minutes)</label>
                            <input type="number" name="duration" id="duration" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" value="{{ old('duration', $course->duration) }}" required>
                            @error('duration')
                                <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Level -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label for="level" class="block text-sm font-medium text-text-main-light mb-2">Niveau</label>
                            <select name="level" id="level" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                                <option value="débutant" {{ old('level', $course->level) == 'débutant' ? 'selected' : '' }}>Débutant</option>
                                <option value="intermédiaire" {{ old('level', $course->level) == 'intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                <option value="avancé" {{ old('level', $course->level) == 'avancé' ? 'selected' : '' }}>Avancé</option>
                            </select>
                            @error('level')
                                <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-text-main-light mb-2">Catégorie *</label>
                            <select name="category_id" id="category_id" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                                <option value="">Sélectionner une catégorie</option>
                                @foreach(\App\Models\Category::active()->get() as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Thumbnail Upload -->
                        <div>
                            <label for="thumbnail" class="block text-sm font-medium text-text-main-light mb-2">Miniature du cours (optionnel)</label>
                            <input type="file" name="thumbnail" id="thumbnail" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" accept="image/*">
                            @error('thumbnail')
                                <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                            @enderror

                            @if($course->thumbnail)
                                <div class="mt-2">
                                    <p class="text-sm text-text-sub-light">Miniature actuelle:</p>
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Current thumbnail" class="mt-1 h-24 object-cover rounded-lg">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <button type="submit" class="px-8 py-4 bg-secondary text-white rounded-2xl font-bold hover:opacity-90 transition-all">
                            Mettre à jour le cours
                        </button>
                    </div>
                </form>
            </div>
@endsection