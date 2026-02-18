@extends('layouts.admin')

@section('title', 'Modifier l\'Utilisateur')

@section('content')
<div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="text-primary font-bold hover:underline flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined">arrow_back</span>
            Retour aux utilisateurs
        </a>
        <h1 class="text-2xl font-black text-text-main-light">Modifier l'utilisateur</h1>
        <p class="text-text-sub-light">{{ $user->name }}</p>
    </div>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-text-main-light mb-2">Nom complet *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                @error('name')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-text-main-light mb-2">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                @error('email')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-text-main-light mb-2">Rôle *</label>
                <select name="role" id="role" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" required>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Utilisateur</option>
                    <option value="instructor" {{ old('role', $user->role) == 'instructor' ? 'selected' : '' }}>Instructeur</option>
                    @if(auth()->user()->role === 'admin')
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    @endif
                </select>
                @error('role')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if($user->role === 'instructor')
                <div>
                    <label for="instructor_status" class="block text-sm font-medium text-text-main-light mb-2">Statut Instructeur</label>
                    <select name="instructor_status" id="instructor_status" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                        <option value="pending" {{ old('instructor_status', $user->instructor_status) == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="approved" {{ old('instructor_status', $user->instructor_status) == 'approved' ? 'selected' : '' }}>Approuvé</option>
                        <option value="rejected" {{ old('instructor_status', $user->instructor_status) == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                    @error('instructor_status')
                        <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div>
                <label for="phone" class="block text-sm font-medium text-text-main-light mb-2">Téléphone</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                @error('phone')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="specialty" class="block text-sm font-medium text-text-main-light mb-2">Spécialité</label>
                <input type="text" name="specialty" id="specialty" value="{{ old('specialty', $user->specialty) }}" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                @error('specialty')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="bio" class="block text-sm font-medium text-text-main-light mb-2">Biographie</label>
                <textarea name="bio" id="bio" rows="3" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if($user->role === 'instructor')
                <div class="md:col-span-2">
                    <label for="experience" class="block text-sm font-medium text-text-main-light mb-2">Expérience</label>
                    <textarea name="experience" id="experience" rows="3" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">{{ old('experience', $user->experience) }}</textarea>
                    @error('experience')
                        <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            @if($user->role !== 'admin')
                <div class="md:col-span-2">
                    <label for="profile_image" class="block text-sm font-medium text-text-main-light mb-2">Photo de profil</label>
                    @if($user->profile_image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Current profile" class="h-32 w-32 object-cover rounded-full">
                        </div>
                    @endif
                    <input type="file" name="profile_image" id="profile_image" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all" accept="image/*">
                    @error('profile_image')
                        <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div>
                <label for="password" class="block text-sm font-medium text-text-main-light mb-2">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                <p class="text-xs text-text-sub-light mt-1">Laisser vide pour conserver le mot de passe actuel</p>
                @error('password')
                    <p class="text-secondary text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-text-main-light mb-2">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-white border border-border-light text-text-main-light rounded-xl font-bold hover:bg-slate-50 transition-all">
                Annuler
            </a>
            <button type="submit" class="px-8 py-3 bg-secondary text-white rounded-xl font-bold hover:opacity-90 transition-all">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
