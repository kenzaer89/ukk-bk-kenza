@php($user = Auth::user())
<div x-data="notificationDropdown()" x-init="updateCount()" class="relative inline-block text-left">
    <button @click="toggle()" class="relative inline-flex items-center justify-center p-2 bg-transparent rounded-full hover:bg-gray-700 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <span x-show="count > 0" x-text="count" class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"></span>
    </button>

    <div x-show="open" x-cloak @click.away="close()" class="origin-top-right absolute right-0 mt-2 w-96 rounded-md shadow-lg bg-brand-gray border border-brand-light/10 z-50">
        <div class="p-4">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-bold text-brand-light">Notifikasi</h4>
                <div class="text-xs text-brand-light/60">
                    <button @click="markAllAsRead()" class="text-brand-teal hover:underline">Tandai semua</button>
                </div>
            </div>

            <template x-if="notifications.length == 0">
                <div class="text-xs text-brand-light/60">Tidak ada notifikasi</div>
            </template>

            <div class="space-y-2 max-h-64 overflow-y-auto">
                <template x-for="notif in notifications" :key="notif.id">
                    <div class="bg-brand-dark/50 rounded-lg p-3 border border-brand-light/5 flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm text-brand-light" x-text="notif.message"></p>
                            <p class="text-xs text-brand-light/60 mt-1" x-text="timeAgo(notif.created_at)"></p>
                        </div>
                        <div class="ml-3 w-6 flex flex-col items-center gap-2">
                            <button @click.stop="markAsRead(notif.id)" class="text-xs px-2 py-1 rounded bg-brand-teal text-white" x-show="notif.status == 'unread'">✓</button>
                            <button @click.stop="deleteNotif(notif.id)" class="text-xs text-red-400 hover:text-red-500">🗑️</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notificationDropdown', () => ({
            open: false,
            notifications: [],
            count: 0,
            initialized: false,
            
            toggle() { 
                this.open = !this.open; 
                if(this.open) this.fetchNotifications(); 
            },
            
            close() { 
                this.open = false; 
            },
            
            fetchNotifications() {
                fetch('/notifications/list', { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .then(data => { 
                        this.notifications = data.notifications || []; 
                    })
                    .catch(err => console.error('Fetch notifications error:', err));
            },
            
            updateCount() {
                fetch('/notifications/count', { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .then(data => { 
                        const newCount = data.count || 0;
                        if (this.initialized && newCount > this.count) {
                            window.showGlobalToast('Notifikasi Baru', 'Anda memiliki pesan baru di menu Bimbingan Konseling.');
                            // Optional: play sound
                            if (window.playNotificationSound) window.playNotificationSound();
                        }
                        this.count = newCount;
                        this.initialized = true;
                    })
                    .catch(err => console.error('Fetch count error:', err));
            },

            init() {
                this.updateCount();
                // Polling setiap 15 detik
                setInterval(() => {
                    this.updateCount();
                }, 15000);
            },
            
            markAsRead(id) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch('/notifications/mark-read', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ id })
                })
                .then(r => r.json())
                .then(() => { 
                    this.fetchNotifications(); 
                    this.updateCount(); 
                });
            },
            
            markAllAsRead() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch('/notifications/mark-all-read', { 
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
                })
                .then(r => r.json())
                .then(() => { 
                    this.fetchNotifications(); 
                    this.updateCount(); 
                });
            },
            
            deleteNotif(id) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch('/notifications/delete', { 
                    method: 'DELETE', 
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }, 
                    body: JSON.stringify({ id })
                })
                .then(r => r.json())
                .then(() => { 
                    this.fetchNotifications(); 
                    this.updateCount(); 
                });
            },
            
            timeAgo(dateStr) {
                try {
                    const date = new Date(dateStr);
                    const diff = Math.floor((Date.now() - date) / 1000);
                    if (diff < 60) return diff + ' detik lalu';
                    if (diff < 3600) return Math.floor(diff / 60) + ' menit lalu';
                    if (diff < 86400) return Math.floor(diff / 3600) + ' jam lalu';
                    return Math.floor(diff / 86400) + ' hari lalu';
                } catch (e) { return 'baru saja'; }
            }
        }));
    });
</script>
@endpush
