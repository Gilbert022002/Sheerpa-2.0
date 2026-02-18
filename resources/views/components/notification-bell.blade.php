@props([
    'unreadCount' => 0,
])

<div class="relative" x-data="notificationBell()" x-init="init()" @click.away="open = false">
    <button 
        type="button"
        @click="toggle()" 
        class="relative flex items-center justify-center p-2 rounded-lg hover:bg-primary/10 hover:text-primary transition-all cursor-pointer"
        aria-haspopup="true"
        :aria-expanded="open"
    >
        <span class="material-symbols-outlined text-xl">notifications</span>
        <span 
            x-show="unreadCount > 0"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-50"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-50"
            class="absolute -top-1 -right-1 min-w-[1.25rem] h-5 bg-secondary text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow-md"
            x-text="unreadCount > 9 ? '9+' : unreadCount"
        ></span>
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
                <button 
                    x-show="unreadCount > 0"
                    @click="markAllAsRead()"
                    class="text-xs font-bold text-primary hover:text-primary/80 transition-colors"
                >
                    Tout marquer comme lu
                </button>
            </div>
        </div>

        <div class="max-h-96 overflow-y-auto" id="notificationsList">
            <template x-if="notifications.length === 0">
                <div class="p-8 text-center text-text-sub-light">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">notifications_none</span>
                    <p class="text-sm font-bold">Aucune notification</p>
                </div>
            </template>

            <template x-for="notification in notifications" :key="notification.id">
                <a :href="notification.url" class="block p-4 hover:bg-slate-50 transition-colors" :class="notification.is_unread ? 'bg-primary/5' : ''">
                    <div class="flex items-start gap-3">
                        <div class="size-10 rounded-full" :class="notification.color" flex items-center justify-center flex-shrink-0>
                            <span class="material-symbols-outlined text-sm" x-text="notification.icon"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-sm text-text-main-light truncate" x-text="notification.title"></h4>
                                <span x-show="notification.is_unread" class="size-2 bg-primary rounded-full flex-shrink-0"></span>
                            </div>
                            <p class="text-xs text-text-sub-light line-clamp-2" x-text="notification.message"></p>
                            <p class="text-[10px] text-text-sub-light mt-1" x-text="notification.created_at"></p>
                        </div>
                    </div>
                </a>
            </template>
        </div>

        <div class="p-4 border-t border-border-light">
            <a href="{{ route('notifications.index') }}" class="block text-center text-sm font-bold text-primary hover:text-primary/80 transition-colors">
                Voir toutes les notifications
            </a>
        </div>
    </div>
</div>

<script>
function notificationBell() {
    return {
        open: false,
        unreadCount: @js($unreadCount),
        notifications: [],
        pollingInterval: null,
        
        init() {
            // Load initial notifications
            this.loadNotifications();
            
            // Start polling for new notifications every 30 seconds
            this.startPolling();
            
            // Listen for page visibility changes to pause/resume polling
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    this.stopPolling();
                } else {
                    this.startPolling();
                    this.loadNotifications();
                }
            });
        },
        
        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.loadNotifications();
            }
        },
        
        startPolling() {
            if (this.pollingInterval) return;
            
            // Poll every 3 seconds for real-time updates
            this.pollingInterval = setInterval(() => {
                this.loadNotifications();
            }, 3000);
        },
        
        stopPolling() {
            if (this.pollingInterval) {
                clearInterval(this.pollingInterval);
                this.pollingInterval = null;
            }
        },
        
        async loadNotifications() {
            try {
                const response = await fetch('{{ route("api.notifications.recent") }}');
                const data = await response.json();
                
                // Update unread count with animation
                if (data.unread_count !== this.unreadCount) {
                    this.unreadCount = data.unread_count;
                    
                    // Play notification sound if new notifications arrived and dropdown is closed
                    if (data.unread_count > this.unreadCount && !this.open) {
                        this.playNotificationSound();
                    }
                }
                
                // Update notifications list
                this.notifications = data.notifications;
            } catch (error) {
                console.error('Error loading notifications:', error);
            }
        },
        
        async markAllAsRead() {
            try {
                const response = await fetch('{{ route("notifications.read-all") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.unreadCount = 0;
                    this.notifications.forEach(n => n.is_unread = false);
                }
            } catch (error) {
                console.error('Error marking notifications as read:', error);
            }
        },
        
        playNotificationSound() {
            // Optional: Play a subtle notification sound
            // Uncomment to enable sound notification
            /*
            const audio = new Audio('/sounds/notification.mp3');
            audio.volume = 0.3;
            audio.play().catch(e => console.log('Sound play failed:', e));
            */
        }
    }
}
</script>
