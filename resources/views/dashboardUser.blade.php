<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sherpa Profile - Dashboard</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>
<body class="bg-background-light text-text-main-light min-h-screen flex flex-col">

<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-border-light bg-card-light px-6 py-3 sticky top-0 z-50">
    <div class="flex items-center gap-8 w-full max-w-[1280px] mx-auto">
        <div class="flex items-center gap-4 text-text-main-light">
            <img src="{{ asset('images/logo-bleu-sheerpa.png') }}" alt="Sheerpa Logo" class="h-16 w-auto object-contain">
        </div>
        <label class="hidden md:flex flex-col min-w-40 !h-10 max-w-64">
            <div class="flex w-full flex-1 items-stretch rounded-lg h-full group">
                <div class="text-text-sub-light flex border-none bg-background-light items-center justify-center pl-4 rounded-l-lg border-r-0">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </div>
                <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg rounded-l-none text-text-main-light focus:outline-0 focus:ring-0 border-none bg-background-light h-full placeholder:text-text-sub-light px-4 pl-2 text-sm font-normal leading-normal" placeholder="Search guides..." value=""/>
            </div>
        </label>
        <div class="flex flex-1 justify-end gap-6 items-center">
            <div class="hidden md:flex items-center gap-6">
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Become a Sheerpa</a>
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Find a Guide</a>
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Log In</a>
            </div>
            <button class="flex cursor-pointer items-center justify-center overflow-hidden rounded-lg h-9 px-5 bg-primary hover:opacity-90 transition-opacity text-white text-sm font-bold leading-normal tracking-[0.015em]">
                <span class="truncate">Sign Up</span>
            </button>
        </div>
    </div>
</header>

<div class="flex flex-1 w-full max-w-[1280px] mx-auto">
    <aside class="w-64 hidden lg:flex flex-col gap-2 p-6 border-r border-border-light">
        <nav class="flex flex-col gap-1">
            <a href="dashboardUser.html" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary font-bold">
                <span class="material-symbols-outlined">person</span> My Profile
            </a>
            <a href="myAspirations.html" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all">
                <span class="material-symbols-outlined">auto_awesome</span> My Aspirations
            </a>
            <a href="favoriteCourses.html" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all">
                <span class="material-symbols-outlined">favorite</span> Favorite Courses
            </a>
            <a href="myReservations.html" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all">
                <span class="material-symbols-outlined">calendar_today</span> My Reservations
            </a>
            <a href="invoicesUser.html" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all">
                <span class="material-symbols-outlined">receipt_long</span> Invoices
            </a>
        </nav>
        <div class="mt-auto pt-6 border-t border-border-light">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full rounded-xl text-secondary font-bold hover:bg-secondary/5 transition-all">
                    <span class="material-symbols-outlined">logout</span> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">
        
        <section class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light flex flex-col md:flex-row items-center gap-8">
            <div class="relative">
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" class="size-28 rounded-full bg-primary/5 object-cover" alt="Profile">
                <button class="absolute bottom-0 right-0 bg-white p-2 rounded-full border border-border-light text-primary hover:text-secondary shadow-sm">
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
        </section>

        <section>
            <h3 class="text-lg font-black mb-4 px-2">My Aspirations</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow flex items-start gap-4">
                    <div class="p-3 rounded-xl bg-primary/10 text-primary">
                        <span class="material-symbols-outlined">rocket_launch</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Become a web developer</h4>
                        <p class="text-sm text-text-sub-light mt-1">Focusing on React and Modern CSS Frameworks.</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow flex items-start gap-4">
                    <div class="p-3 rounded-xl bg-secondary/10 text-secondary">
                        <span class="material-symbols-outlined">forum</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Improve interview skills</h4>
                        <p class="text-sm text-text-sub-light mt-1">Practicing technical storytelling and soft skills.</p>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h3 class="text-lg font-black mb-4 px-2">Favorite Courses</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <article class="bg-card-light rounded-3xl border border-border-light overflow-hidden soft-shadow transition-transform hover:-translate-y-1">
                    <div class="h-40 bg-slate-100 relative">
                        <div class="absolute inset-0 flex items-center justify-center opacity-20">
                            <span class="material-symbols-outlined text-6xl">school</span>
                        </div>
                        <button class="absolute top-4 right-4 bg-white p-2 rounded-full text-secondary">
                            <span class="material-symbols-outlined fill" style="font-variation-settings: 'FILL' 1">favorite</span>
                        </button>
                    </div>
                    <div class="p-5">
                        <h4 class="font-black text-base mb-4 leading-tight">Mastering Tailwind CSS layouts</h4>
                        <div class="flex items-center gap-3 pt-4 border-t border-border-light">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Sara" class="size-8 rounded-full">
                            <span class="text-sm font-bold text-text-sub-light">Sara Ben <span class="text-primary">• Guide</span></span>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <section class="space-y-4">
                <h3 class="text-lg font-black px-2">Upcoming Sessions</h3>
                <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-xs font-black text-secondary uppercase mb-1">Tomorrow at 14:00</p>
                            <h4 class="font-bold text-lg">Introduction to UI Design</h4>
                        </div>
                        <span class="material-symbols-outlined text-slate-200 text-3xl">event_available</span>
                    </div>
                    <button disabled class="w-full py-3 bg-slate-100 text-slate-400 rounded-xl font-bold text-sm cursor-not-allowed">
                        Join session (Disabled until start)
                    </button>
                </div>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg font-black px-2">Invoices</h3>
                <div class="bg-card-light rounded-3xl border border-border-light overflow-hidden soft-shadow">
                    <div class="divide-y divide-border-light">
                        <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">description</span>
                                <div>
                                    <p class="text-sm font-bold">FEBRUARY_2026.pdf</p>
                                    <p class="text-xs text-text-sub-light">4 Feb 2026 • $45.00</p>
                                </div>
                            </div>
                            <button class="p-2 text-primary hover:bg-primary/10 rounded-lg">
                                <span class="material-symbols-outlined">download</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <section class="bg-secondary/5 rounded-3xl p-8 border border-secondary/10">
            <h3 class="text-lg font-black mb-2">Rate your recent guides</h3>
            <p class="text-sm text-text-sub-light mb-6">Your feedback helps the community grow.</p>
            <div class="flex gap-2">
                <button class="size-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-200 hover:text-secondary transition-colors">
                    <span class="material-symbols-outlined text-3xl">star</span>
                </button>
                <button class="size-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-200 hover:text-secondary transition-colors">
                    <span class="material-symbols-outlined text-3xl">star</span>
                </button>
                <button class="size-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-200 hover:text-secondary transition-colors">
                    <span class="material-symbols-outlined text-3xl">star</span>
                </button>
                <button class="size-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-200 hover:text-secondary transition-colors">
                    <span class="material-symbols-outlined text-3xl">star</span>
                </button>
                <button class="size-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-200 hover:text-secondary transition-colors">
                    <span class="material-symbols-outlined text-3xl">star</span>
                </button>
            </div>
        </section>

    </main>
</div>

<script>
    // Would you like me to add real search functionality or dynamic course cards?
</script>
</body>
</html>