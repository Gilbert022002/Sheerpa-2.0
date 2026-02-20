@extends('layouts.user')

@section('title', 'Sheerpa - Mon Profil')

@section('content')
    <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
        <div class="flex flex-col md:flex-row items-start gap-8">
            <div class="relative">
                @if(auth()->user()->profile_image)
                    <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) . '?' . time() : asset('images/default/profile-default.jpg') }}" class="size-28 rounded-full bg-primary/5 object-cover" alt="Profile">
                @else
                    <div class="size-28 rounded-full bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-5xl">person</span>
                    </div>
                @endif
                <button type="button" onclick="openProfileModal()" class="absolute bottom-0 right-0 bg-white p-2 rounded-full border border-border-light text-primary hover:text-secondary shadow-sm">
                    <span class="material-symbols-outlined text-sm">edit</span>
                </button>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-2xl font-black">{{ auth()->user()->name }}</h2>
                <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-2 text-text-sub-light text-sm font-medium">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-base">mail</span> {{ auth()->user()->email }}</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-base">person</span> {{ auth()->user()->role }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow">
                <h3 class="font-bold text-lg mb-4">Informations personnelles</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Nom complet</span>
                        <span class="font-medium">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Email</span>
                        <span class="font-medium">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Téléphone</span>
                        <span class="font-medium">{{ auth()->user()->phone ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Spécialité</span>
                        <span class="font-medium">{{ auth()->user()->specialty ?? 'Non renseigné' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow">
                <h3 class="font-bold text-lg mb-4">Biographie</h3>
                <p class="text-text-sub-light">
                    {{ auth()->user()->bio ?? 'Aucune description fournie. Ajoutez une brève description de votre expérience et de vos compétences.' }}
                </p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="font-bold text-lg mb-4">Paramètres du profil</h3>
            <div class="flex flex-wrap gap-4">
                <button type="button" onclick="openEditProfileModal()" class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all">
                    Modifier le profil
                </button>
                <button class="px-6 py-3 bg-white border border-border-light text-text-main-light rounded-xl font-bold hover:bg-slate-50 transition-all">
                    Changer mot de passe
                </button>
                <button class="px-6 py-3 bg-white border border-border-light text-secondary rounded-xl font-bold hover:bg-secondary/5 transition-all">
                    Supprimer le compte
                </button>
            </div>
        </div>
        
        <!-- Modal for editing profile information -->
        <div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 relative">
                <h3 class="text-xl font-bold text-text-main-light mb-4">Modifier les informations du profil</h3>

                <form id="profileInfoForm" method="POST" action="{{ route('user.profile.update.info') }}">
                    @csrf
                    @method('POST')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-text-main-light mb-2">Nom complet</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-text-main-light mb-2">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-text-main-light mb-2">Téléphone</label>
                        <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-text-main-light mb-2">Spécialité</label>
                        <input type="text" name="specialty" value="{{ auth()->user()->specialty ?? '' }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-text-main-light">Biographie</label>
                            <span class="text-xs text-text-sub-light" id="bioCounter">0/100</span>
                        </div>
                        <textarea name="bio" rows="3" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" maxlength="100" oninput="updateCounter(this, 'bioCounter')">{{ auth()->user()->bio ?? '' }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeEditProfileModal(event)" class="px-4 py-2 border border-border-light text-text-main-light rounded-lg font-bold hover:bg-slate-50 transition-all">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 bg-secondary text-white rounded-lg font-bold hover:opacity-90 transition-all">
                            Enregistrer
                        </button>
                    </div>
                </form>

                <button type="button" onclick="closeEditProfileModal(event)" class="absolute top-4 right-4 text-text-sub-light hover:text-text-main-light">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <!-- Modal pour la mise à jour de la photo de profil -->
    <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 relative">
            <h3 class="text-xl font-bold text-text-main-light mb-4">Mettre à jour la photo de profil</h3>
            
            <form id="profileImageForm" method="POST" action="{{ route('user.profile.update.picture') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-text-main-light mb-2">Choisissez une nouvelle photo</label>
                    <input type="file" name="profile_image" accept="image/*" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeProfileModal(event)" class="px-4 py-2 border border-border-light text-text-main-light rounded-lg font-bold hover:bg-slate-50 transition-all">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-secondary text-white rounded-lg font-bold hover:opacity-90 transition-all">
                        Enregistrer
                    </button>
                </div>
            </form>
            
            <button type="button" onclick="closeProfileModal(event)" class="absolute top-4 right-4 text-text-sub-light hover:text-text-main-light">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>

    <script>
        function openProfileModal() {
            document.getElementById('profileModal').classList.remove('hidden');
        }

        function closeProfileModal(e) {
            e.stopPropagation();
            document.getElementById('profileModal').classList.add('hidden');
        }
        
        function openEditProfileModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
        }

        function closeEditProfileModal(e) {
            e.stopPropagation();
            document.getElementById('editProfileModal').classList.add('hidden');
        }
        
        function updateCounter(textarea, counterId) {
            const counter = document.getElementById(counterId);
            counter.textContent = textarea.value.length + '/100';
        }
        
        // Initialize counters when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            const bioTextarea = document.querySelector('textarea[name="bio"]');
            if (bioTextarea) {
                updateCounter(bioTextarea, 'bioCounter');
            }
        });
    </script>
@endsection