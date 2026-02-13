@extends('layouts.user')

@section('title', 'Sheerpa - My Profile')

@section('content')
    <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
        <div class="flex flex-col md:flex-row items-start gap-8">
            <div class="relative">
                <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) . '?' . time() : asset('images/default/profile-default.jpg') }}" class="size-28 rounded-full bg-primary/5 object-cover" alt="Profile">
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
                <h3 class="font-bold text-lg mb-4">À propos de moi</h3>
                <p class="text-text-sub-light">
                    {{ auth()->user()->bio ?? 'Aucune description fournie. Ajoutez une brève description de votre expérience et de vos compétences.' }}
                </p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="font-bold text-lg mb-4">Paramètres du profil</h3>
            <div class="flex flex-wrap gap-4">
                <button class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all">
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

        <div class="mt-8">
            <h3 class="font-bold text-lg mb-4">Photo de profil</h3>
            <form method="POST" action="{{ route('profile.update.picture') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="flex items-center gap-6">
                    <div class="relative">
                        <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . auth()->user()->id }}" class="size-24 rounded-full bg-primary/5 object-cover" alt="Profile Preview">
                    </div>
                    <div class="flex-1">
                        <input type="file" name="profile_image" accept="image/*" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all mb-3">
                        <button type="submit" class="px-6 py-3 bg-secondary text-white rounded-xl font-bold hover:opacity-90 transition-all">
                            Mettre à jour la photo
                        </button>
                    </div>
                </div>
            </form>
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
    </script>
@endsection