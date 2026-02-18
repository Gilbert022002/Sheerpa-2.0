<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sheerpa Guide - Dashboard')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    @yield('styles')
</head>
<body class="bg-background-light text-text-main-light min-h-screen flex flex-col">
    <header class="flex items-center justify-between border-b border-solid border-border-light bg-card-light px-6 py-3 sticky top-0 z-50">
        <div class="flex items-center gap-8 w-full max-w-[1280px] mx-auto">
            <div class="flex items-center gap-4">
                <a href="{{ route('instructor.dashboard') }}">
                    <img src="{{ asset('images/logo-bleu-sheerpa.png') }}" alt="Sheerpa Logo" class="h-12 w-auto object-contain">
                </a>
                <span class="bg-primary/10 text-primary text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest">Espace Guide</span>
            </div>
            <div class="flex flex-1 justify-end gap-6 items-center">
                <div class="hidden md:flex items-center gap-6">
                    <a class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors" href="#">Explorer</a>
                    <a class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors" href="#">Aide</a>
                </div>

                {{-- Notification Bell --}}
                <x-notification-bell :unread-count="auth()->user()->unreadNotificationsCount()" />

                <div class="flex items-center gap-3 pl-6 border-l border-border-light">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-text-sub-light font-bold">{{ auth()->user()->role }}</p>
                    </div>
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) . '?' . time() }}" class="size-10 rounded-full bg-primary/5 object-cover" alt="Profile">
                    @else
                        <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-sm">person</span>
                        </div>
                    @endif
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center overflow-hidden rounded-lg h-9 px-5 bg-primary hover:opacity-90 transition-opacity text-white text-sm font-bold leading-normal tracking-[0.015em]">
                        <span class="truncate">Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="flex flex-1 w-full max-w-[1280px] mx-auto">
        <aside class="w-64 hidden lg:flex flex-col gap-2 p-6 border-r border-border-light">
            @include('components.instructor.nav')
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
            @yield('content')
        </main>
    </div>
    
    @yield('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mesCoursLink = document.querySelector('a[href$="/guide/courses"]');
            if (mesCoursLink) {
                mesCoursLink.addEventListener('click', function(e) {
                    // Check if we're navigating to the courses page
                    if (!this.classList.contains('top-navigation-mode')) {
                        // Add the top navigation mode class to body
                        document.body.classList.add('top-navigation-mode');
                        
                        // Move the sidebar navigation to the top
                        const sidebar = document.querySelector('aside');
                        const mainContent = document.querySelector('main');
                        const navContainer = document.createElement('div');
                        navContainer.className = 'top-navigation-container bg-card-light border-b border-border-light p-4 mb-6';
                        navContainer.id = 'top-navigation';
                        
                        // Clone the navigation
                        const navClone = document.querySelector('aside nav').cloneNode(true);
                        navClone.classList.add('flex', 'flex-row', 'gap-2', 'overflow-x-auto', 'pb-2');
                        navClone.classList.remove('flex-col', 'gap-1');
                        
                        // Update the cloned navigation items to be horizontal
                        const navItems = navClone.querySelectorAll('a');
                        navItems.forEach(item => {
                            item.classList.remove('rounded-xl', 'px-4', 'py-3');
                            item.classList.add('px-3', 'py-2', 'rounded-lg', 'whitespace-nowrap');
                        });
                        
                        navContainer.appendChild(navClone);
                        
                        // Insert the navigation at the top of the main content
                        mainContent.insertBefore(navContainer, mainContent.firstChild);
                        
                        // Hide the sidebar
                        sidebar.style.display = 'none';
                    }
                });
            }
            
            // Check if we're already on a courses page and should show top navigation
            if (window.location.pathname.includes('/guide/courses')) {
                document.body.classList.add('top-navigation-mode');
                
                // Delay execution to ensure DOM is fully loaded
                window.setTimeout(() => {
                    const sidebar = document.querySelector('aside');
                    const mainContent = document.querySelector('main');
                    if (sidebar && mainContent && !document.getElementById('top-navigation')) {
                        const navContainer = document.createElement('div');
                        navContainer.className = 'top-navigation-container bg-card-light border-b border-border-light p-4 mb-6';
                        navContainer.id = 'top-navigation';
                        
                        // Clone the navigation
                        const navClone = document.querySelector('aside nav').cloneNode(true);
                        navClone.classList.add('flex', 'flex-row', 'gap-2', 'overflow-x-auto', 'pb-2');
                        navClone.classList.remove('flex-col', 'gap-1');
                        
                        // Update the cloned navigation items to be horizontal
                        const navItems = navClone.querySelectorAll('a');
                        navItems.forEach(item => {
                            item.classList.remove('rounded-xl', 'px-4', 'py-3');
                            item.classList.add('px-3', 'py-2', 'rounded-lg', 'whitespace-nowrap');
                        });
                        
                        navContainer.appendChild(navClone);
                        
                        // Insert the navigation at the top of the main content
                        mainContent.insertBefore(navContainer, mainContent.firstChild);
                        
                        // Hide the sidebar
                        sidebar.style.display = 'none';
                    }
                }, 100);
            }
        });
    </script>
    
    <style>
        body.top-navigation-mode main {
            padding-top: 0;
        }
        
        .top-navigation-container {
            position: sticky;
            top: 0;
            z-index: 40;
            max-height: 80px;
            overflow: auto;
        }
        
        .top-navigation-container nav {
            display: flex;
            flex-wrap: nowrap;
        }
    </style>
</body>
</html>