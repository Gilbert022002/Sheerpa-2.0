@extends('layouts.user')

@section('title', 'Mes Notifications')

@section('content')
<div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-text-main-light">Mes Notifications</h1>
            <p class="text-text-sub-light">Restez informé des dernières activités</p>
        </div>
        @if($notifications->first()?->isUnread())
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all">
                    Tout marquer comme lu
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-xl font-bold mb-6">
            {{ session('success') }}
        </div>
    @endif

    @forelse($notifications as $notification)
        <div class="p-4 mb-4 rounded-2xl border border-border-light {{ $notification->isUnread() ? 'bg-primary/5' : 'bg-white' }} transition-colors">
            <div class="flex items-start gap-4">
                <div class="size-12 rounded-full {{ $notification->color }} flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined">{{ $notification->icon }}</span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-text-main-light">{{ $notification->title }}</h3>
                            @if($notification->isUnread())
                                <span class="size-2 bg-primary rounded-full"></span>
                            @endif
                        </div>
                        <span class="text-xs text-text-sub-light">{{ $notification->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    <p class="text-sm text-text-sub-light mb-3">{{ $notification->message }}</p>
                    
                    @if($notification->data)
                        <div class="flex gap-2">
                            @if(isset($notification->data['booking_id']))
                                <a href="{{ route('user.bookings.index') }}" class="text-xs font-bold text-primary hover:text-primary/80 transition-colors">
                                    Voir la réservation
                                </a>
                            @endif
                            @if(isset($notification->data['course_id']))
                                <a href="{{ route('user.courses.show', $notification->data['course_id']) }}" class="text-xs font-bold text-primary hover:text-primary/80 transition-colors">
                                    Voir le cours
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    @if($notification->isUnread())
                        <form action="{{ route('notifications.read', $notification) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs px-3 py-1 bg-white border border-border-light rounded-lg font-bold hover:bg-slate-50 transition-all">
                                Marquer comme lu
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Supprimer cette notification ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs px-3 py-1 bg-white border border-border-light rounded-lg font-bold text-secondary hover:bg-red-50 transition-all">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">notifications_none</span>
            <h3 class="text-lg font-bold text-text-main-light mb-2">Aucune notification</h3>
            <p class="text-text-sub-light">Vous n'avez pas de notifications pour le moment</p>
        </div>
    @endforelse

    @if($notifications->hasPages())
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
