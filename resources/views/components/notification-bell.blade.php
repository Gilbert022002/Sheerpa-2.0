@props([
    'unreadCount' => 0,
])

<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button 
        type="button"
        @click="open = !open" 
        class="relative flex items-center justify-center p-2 rounded-lg hover:bg-primary/10 hover:text-primary transition-all cursor-pointer"
        aria-haspopup="true"
        :aria-expanded="open"
    >
        <span class="material-symbols-outlined text-xl">notifications</span>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 min-w-[1.25rem] h-5 bg-secondary text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow-md">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-96 max-w-[calc(100vw-2rem)] rounded-2xl bg-white shadow-xl border border-border-light z-50"
        style="display: none;"
    >
        <div class="p-4 border-b border-border-light">
            <div class="flex justify-between items-center">
                <h3 class="font-black text-lg text-text-main-light">Notifications</h3>
                @if($unreadCount > 0)
                    <form action="{{ route('notifications.read-all') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-primary hover:text-primary/80 transition-colors">
                            Tout marquer comme lu
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="max-h-96 overflow-y-auto">
            @php
                $notifications = auth()->user()->notifications()->latest()->take(5)->get();
            @endphp

            @forelse($notifications as $notification)
                @php
                    $linkUrl = route('notifications.index');
                    if (isset($notification->data['course_id'])) {
                        $linkUrl = route('user.courses.show', $notification->data['course_id']);
                    } elseif (isset($notification->data['booking_id'])) {
                        $linkUrl = route('user.bookings.index');
                    }
                @endphp
                
                <a href="{{ $linkUrl }}" class="block p-4 hover:bg-slate-50 transition-colors {{ $notification->isUnread() ? 'bg-primary/5' : '' }}">
                    <div class="flex items-start gap-3">
                        <div class="size-10 rounded-full {{ $notification->color }} flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-sm">{{ $notification->icon }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-sm text-text-main-light truncate">{{ $notification->title }}</h4>
                                @if($notification->isUnread())
                                    <span class="size-2 bg-primary rounded-full flex-shrink-0"></span>
                                @endif
                            </div>
                            <p class="text-xs text-text-sub-light line-clamp-2">{{ $notification->message }}</p>
                            <p class="text-[10px] text-text-sub-light mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-text-sub-light">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">notifications_none</span>
                    <p class="text-sm font-bold">Aucune notification</p>
                </div>
            @endforelse
        </div>

        <div class="p-4 border-t border-border-light">
            <a href="{{ route('notifications.index') }}" class="block text-center text-sm font-bold text-primary hover:text-primary/80 transition-colors">
                Voir toutes les notifications
            </a>
        </div>
    </div>
</div>
