<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sheerpa Guide - Créer un cours</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#7ec9df", // Bleu Sheerpa
                        "secondary": "#ef5e21", // Orange Sheerpa
                        "background-light": "#f6f6f8",
                        "card-light": "#ffffff",
                        "text-main-light": "#121118",
                        "text-sub-light": "#686189",
                        "border-light": "#f1f0f4",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "xl": "1rem",
                        "2xl": "1.5rem",
                        "3xl": "2rem"
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-shadow {
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-background-light text-text-main-light min-h-screen flex flex-col">
    <header class="flex items-center justify-between border-b border-solid border-border-light bg-card-light px-6 py-3 sticky top-0 z-50">
        <div class="flex items-center gap-8 w-full max-w-[1280px] mx-auto">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-bleu-sheerpa.png') }}" alt="Sheerpa Logo" class="h-12 w-auto object-contain">
                <span class="bg-primary/10 text-primary text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest">Espace Guide</span>
            </div>
            <div class="flex flex-1 justify-end gap-6 items-center">
                <div class="hidden md:flex items-center gap-6">
                    <a class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors" href="#">Explorer</a>
                    <a class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors" href="#">Aide</a>
                </div>
                <div class="flex items-center gap-3 pl-6 border-l border-border-light">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-text-sub-light font-bold">{{ auth()->user()->role }}</p>
                    </div>
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ auth()->user()->id }}" class="size-10 rounded-full bg-primary/5 object-cover" alt="Profile">
                </div>
            </div>
        </div>
    </header>

    <div class="flex flex-1 w-full max-w-[1280px] mx-auto">
        <aside class="w-64 hidden lg:flex flex-col gap-2 p-6 border-r border-border-light">
            <nav class="flex flex-col gap-1">
                <a href="{{ route('instructor.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary font-bold transition-all">
                    <span class="material-symbols-outlined">dashboard</span> Tableau de bord
                </a>
                <a href="{{ route('instructor.courses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">school</span> Mes Cours
                </a>
                <a href="{{ route('instructor.availabilities.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">event_available</span> Mes Disponibilités
                </a>
                <a href="{{ route('instructor.one-time-slots.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">video_library</span> Mes Meetings
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">groups</span> Participants
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">payments</span> Revenus
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                    <span class="material-symbols-outlined">settings</span> Paramètres
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-border-light">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full rounded-xl text-secondary font-bold hover:bg-secondary/5 transition-all">
                        <span class="material-symbols-outlined">logout</span> Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">
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
        </main>
    </div>
</body>
</html>
