@extends('layouts.instructor')

@section('title', 'Sheerpa Guide - Créer un cours')

@section('content')
            @if (session('status'))
                <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
                <div class="mb-8">
                    <h1 class="text-2xl font-black text-text-main-light">Créer un nouveau cours</h1>
                    <p class="text-text-sub-light">Remplissez les détails de votre nouveau cours</p>
                </div>

                <form method="POST" action="{{ route('instructor.courses.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-text-main-light mb-2">Titre du cours</label>
                        <input type="text" name="title" id="title" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" value="{{ old('title') }}" required autofocus>
                        @error('title')
                            <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-text-main-light mb-2">Description</label>
                        <textarea name="description" id="description" rows="5" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-text-main-light mb-2">Prix (€)</label>
                            <input type="number" step="0.01" name="price" id="price" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" value="{{ old('price') }}" required>
                            @error('price')
                                <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-text-main-light mb-2">Durée (minutes)</label>
                            <input type="number" name="duration" id="duration" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" value="{{ old('duration') }}" required>
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
                                <option value="débutant" {{ old('level') == 'débutant' ? 'selected' : '' }}>Débutant</option>
                                <option value="intermédiaire" {{ old('level') == 'intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                <option value="avancé" {{ old('level') == 'avancé' ? 'selected' : '' }}>Avancé</option>
                            </select>
                            @error('level')
                                <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-text-main-light mb-2">Catégorie</label>
                            <input type="text" name="category" id="category" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" value="{{ old('category') }}" required>
                            @error('category')
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
                        </div>
                    </div>

                    <!-- Course Time Slots -->
                    <div class="mb-8 bg-slate-50 rounded-2xl p-6 border border-border-light">
                        <h3 class="text-lg font-bold text-text-main-light mb-4">Créneaux horaires du cours</h3>
                        <p class="text-text-sub-light mb-4">Définissez les créneaux horaires disponibles pour ce cours</p>

                        <div id="time-slots-container">
                            <div class="time-slot-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-text-main-light mb-2">Date</label>
                                    <input type="date" name="course_slots[0][date]" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                                    @error('course_slots.0.date')
                                        <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-text-main-light mb-2">Heure de début</label>
                                    <input type="time" name="course_slots[0][start_time]" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                                    @error('course_slots.0.start_time')
                                        <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-text-main-light mb-2">Heure de fin</label>
                                    <input type="time" name="course_slots[0][end_time]" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                                    @error('course_slots.0.end_time')
                                        <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-end">
                                    <button type="button" class="remove-slot-btn px-4 py-3 bg-red-100 text-secondary rounded-lg font-bold hover:bg-red-200 transition-all" style="display: none;">
                                        Retirer
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="button" id="add-time-slot" class="px-4 py-2 bg-primary text-white rounded-lg font-bold hover:bg-primary/90 transition-all">
                                Ajouter un créneau
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <button type="submit" class="px-8 py-4 bg-secondary text-white rounded-2xl font-bold hover:opacity-90 transition-all">
                            Créer le cours
                        </button>
                    </div>
                </form>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let slotIndex = 1;

                    document.getElementById('add-time-slot').addEventListener('click', function() {
                        const container = document.getElementById('time-slots-container');

                        const slotDiv = document.createElement('div');
                        slotDiv.className = 'time-slot-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4';
                        slotDiv.innerHTML = `
                            <div>
                                <label class="block text-sm font-medium text-text-main-light mb-2">Date</label>
                                <input type="date" name="course_slots[${slotIndex}][date]" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" min="${new Date().toISOString().split('T')[0]}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main-light mb-2">Heure de début</label>
                                <input type="time" name="course_slots[${slotIndex}][start_time]" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main-light mb-2">Heure de fin</label>
                                <input type="time" name="course_slots[${slotIndex}][end_time]" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                            </div>

                            <div class="flex items-end">
                                <button type="button" class="remove-slot-btn px-4 py-3 bg-red-100 text-secondary rounded-lg font-bold hover:bg-red-200 transition-all">
                                    Retirer
                                </button>
                            </div>
                        `;

                        container.appendChild(slotDiv);

                        // Add event listener to the new remove button
                        slotDiv.querySelector('.remove-slot-btn').addEventListener('click', function() {
                            container.removeChild(slotDiv);
                        });

                        slotIndex++;

                        // Show remove buttons if we have more than one slot
                        updateRemoveButtons();
                    });

                    // Add event listeners to existing remove buttons
                    document.querySelectorAll('.remove-slot-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const slotItem = this.closest('.time-slot-item');
                            slotItem.parentNode.removeChild(slotItem);
                            updateRemoveButtons();
                        });
                    });

                    function updateRemoveButtons() {
                        const slots = document.querySelectorAll('.time-slot-item');
                        slots.forEach((slot, index) => {
                            const removeBtn = slot.querySelector('.remove-slot-btn');
                            if (slots.length > 1) {
                                removeBtn.style.display = 'block';
                            } else {
                                removeBtn.style.display = 'none';
                            }
                        });
                    }

                    // Initialize remove button visibility
                    updateRemoveButtons();
                });
            </script>
@endsection