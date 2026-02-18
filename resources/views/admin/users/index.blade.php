@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-text-main-light">Gestion des Utilisateurs</h1>
            <p class="text-text-sub-light">Gérez tous les utilisateurs de la plateforme</p>
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

    {{-- Search and Filter --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="md:col-span-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un utilisateur..." class="w-full pl-12 pr-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-text-sub-light">search</span>
                </div>
            </div>
            <div class="flex gap-2">
                <select name="role" class="flex-1 px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                    <option value="">Tous les rôles</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                    <option value="instructor" {{ request('role') == 'instructor' ? 'selected' : '' }}>Instructeur</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <button type="submit" class="px-4 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">filter_list</span>
                </button>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-3 bg-white border border-border-light text-text-main-light rounded-xl font-bold hover:bg-slate-50 transition-all flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-border-light">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Utilisateur</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Rôle</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Statut Instructeur</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->id }}" class="size-10 rounded-full" alt="{{ $user->name }}">
                                <div>
                                    <div class="font-bold text-text-main-light">{{ $user->name }}</div>
                                    <div class="text-sm text-text-sub-light">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role === 'instructor' ? 'bg-primary/10 text-primary' : 'bg-slate-100 text-slate-800') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->role === 'instructor')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->instructor_status === 'approved' ? 'bg-green-100 text-green-800' : ($user->instructor_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($user->instructor_status) }}
                                </span>
                            @else
                                <span class="text-text-sub-light">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-primary/10 text-primary rounded-lg font-bold hover:bg-primary/20 transition-all">
                                    Modifier
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-100 text-secondary rounded-lg font-bold hover:bg-red-200 transition-all">
                                            Supprimer
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-text-sub-light">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-4">people</span>
                                <p class="text-lg font-bold">Aucun utilisateur trouvé</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
