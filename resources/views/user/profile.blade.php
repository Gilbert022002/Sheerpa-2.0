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
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">Informations personnelles</h3>
                    <button type="button" id="togglePersonalInfoEdit" class="text-primary font-bold hover:underline text-sm">Modifier</button>
                </div>
                <form id="personalInfoForm" method="POST" action="{{ route('user.profile.update.info') }}">
                    @csrf
                    @method('POST')
                    <div id="personalInfoView" class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-text-sub-light">Nom complet</span>
                            <span id="nameDisplay" class="font-medium">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-sub-light">Email</span>
                            <span id="emailDisplay" class="font-medium">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-sub-light">Téléphone</span>
                            <span id="phoneDisplay" class="font-medium">{{ auth()->user()->phone ?? 'Non renseigné' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-sub-light">Spécialité</span>
                            <span id="specialtyDisplay" class="font-medium">{{ auth()->user()->specialty ?? 'Non renseigné' }}</span>
                        </div>
                    </div>
                    <div id="personalInfoEdit" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-text-sub-light mb-1">Nom complet</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-sub-light mb-1">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-sub-light mb-1">Téléphone</label>
                            <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-sub-light mb-1">Spécialité</label>
                            <input type="text" name="specialty" value="{{ auth()->user()->specialty ?? '' }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                        </div>
                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" id="cancelPersonalInfoEdit" class="px-4 py-2 border border-border-light text-text-main-light rounded-lg font-bold hover:bg-slate-50 transition-all">
                                Annuler
                            </button>
                            <button type="submit" class="px-4 py-2 bg-secondary text-white rounded-lg font-bold hover:opacity-90 transition-all">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">À propos de moi</h3>
                    <button type="button" id="toggleBioEdit" class="text-primary font-bold hover:underline text-sm">Modifier</button>
                </div>
                <form id="bioForm" method="POST" action="{{ route('user.profile.update.info') }}">
                    @csrf
                    @method('POST')
                    <div id="bioView">
                        <p id="bioDisplay" class="text-text-sub-light">
                            {{ auth()->user()->bio ?? 'Aucune description fournie. Ajoutez une brève description de votre expérience et de vos compétences.' }}
                        </p>
                    </div>
                    <div id="bioEdit" class="hidden">
                        <label class="block text-sm font-medium text-text-sub-light mb-1">À propos de moi</label>
                        <textarea name="bio" rows="4" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">{{ auth()->user()->bio ?? '' }}</textarea>
                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" id="cancelBioEdit" class="px-4 py-2 border border-border-light text-text-main-light rounded-lg font-bold hover:bg-slate-50 transition-all">
                                Annuler
                            </button>
                            <button type="submit" class="px-4 py-2 bg-secondary text-white rounded-lg font-bold hover:opacity-90 transition-all">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="font-bold text-lg mb-4">Paramètres du profil</h3>
            <div class="flex flex-wrap gap-4">
                <button class="px-6 py-3 bg-white border border-border-light text-text-main-light rounded-xl font-bold hover:bg-slate-50 transition-all">
                    Changer mot de passe
                </button>
                <button class="px-6 py-3 bg-white border border-border-light text-secondary rounded-xl font-bold hover:bg-secondary/5 transition-all">
                    Supprimer le compte
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

        // Toggle personal info edit mode
        document.getElementById('togglePersonalInfoEdit').addEventListener('click', function() {
            const viewDiv = document.getElementById('personalInfoView');
            const editDiv = document.getElementById('personalInfoEdit');

            viewDiv.classList.toggle('hidden');
            editDiv.classList.toggle('hidden');
        });

        // Cancel personal info edit
        document.getElementById('cancelPersonalInfoEdit').addEventListener('click', function() {
            const viewDiv = document.getElementById('personalInfoView');
            const editDiv = document.getElementById('personalInfoEdit');

            viewDiv.classList.toggle('hidden');
            editDiv.classList.toggle('hidden');
        });

        // Toggle bio edit mode
        document.getElementById('toggleBioEdit').addEventListener('click', function() {
            const viewDiv = document.getElementById('bioView');
            const editDiv = document.getElementById('bioEdit');

            viewDiv.classList.toggle('hidden');
            editDiv.classList.toggle('hidden');
        });

        // Cancel bio edit
        document.getElementById('cancelBioEdit').addEventListener('click', function() {
            const viewDiv = document.getElementById('bioView');
            const editDiv = document.getElementById('bioEdit');

            viewDiv.classList.toggle('hidden');
            editDiv.classList.toggle('hidden');
        });

        // Handle form submission for personal info
        document.getElementById('personalInfoForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);

            // Create a new FormData object with only the required fields and token
            const personalInfoData = new FormData();
            personalInfoData.append('name', formData.get('name'));
            personalInfoData.append('email', formData.get('email'));
            personalInfoData.append('phone', formData.get('phone'));
            personalInfoData.append('specialty', formData.get('specialty'));
            personalInfoData.append('_token', document.querySelector('input[name="_token"]').value);

            // Send AJAX request
            fetch('{{ route('user.profile.update.info') }}', {
                method: 'POST',
                body: personalInfoData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if(data.success) {
                    // Update displayed values
                    document.getElementById('nameDisplay').textContent = formData.get('name');
                    document.getElementById('emailDisplay').textContent = formData.get('email');
                    document.getElementById('phoneDisplay').textContent = formData.get('phone') || 'Non renseigné';
                    document.getElementById('specialtyDisplay').textContent = formData.get('specialty') || 'Non renseigné';

                    // Switch back to view mode
                    document.getElementById('personalInfoView').classList.remove('hidden');
                    document.getElementById('personalInfoEdit').classList.add('hidden');

                    // Show success message
                    alert('Profil mis à jour avec succès!');
                } else {
                    alert('Erreur lors de la mise à jour du profil.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue lors de la mise à jour du profil.');
            });
        });

        // Handle form submission for bio
        document.getElementById('bioForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);

            // Create a new FormData object with only the bio field and token
            const bioData = new FormData();
            bioData.append('bio', formData.get('bio'));
            bioData.append('_token', document.querySelector('input[name="_token"]').value);

            // Send AJAX request
            fetch('{{ route('user.profile.update.info') }}', {
                method: 'POST',
                body: bioData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if(data.success) {
                    // Update displayed value
                    const bioValue = formData.get('bio') || 'Aucune description fournie. Ajoutez une brève description de votre expérience et de vos compétences.';
                    document.getElementById('bioDisplay').textContent = bioValue;

                    // Switch back to view mode
                    document.getElementById('bioView').classList.remove('hidden');
                    document.getElementById('bioEdit').classList.add('hidden');

                    // Show success message
                    alert('Profil mis à jour avec succès!');
                } else {
                    alert('Erreur lors de la mise à jour du profil.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue lors de la mise à jour du profil.');
            });
        });
    </script>
@endsection
