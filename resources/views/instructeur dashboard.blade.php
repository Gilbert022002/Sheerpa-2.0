<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sheerpa Guide - Dashboard</title>
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

<header class="flex items-center justify-between border-b border-solid border-border-light bg-card-light px-6 py-3 sticky top-0 z-50">
    <div class="flex items-center gap-8 w-full max-w-[1280px] mx-auto">
        <div class="flex items-center gap-4">
            <img src="logo-bleu-sheerpa.png" alt="Sheerpa Logo" class="h-12 w-auto object-contain">
            <span class="bg-primary/10 text-primary text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest">Espace Guide</span>
        </div>
        <div class="flex flex-1 justify-end gap-6 items-center">
            <div class="hidden md:flex items-center gap-6">
                <a class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors" href="#">Explorer</a>
                <a class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors" href="#">Aide</a>
            </div>
            <div class="flex items-center gap-3 pl-6 border-l border-border-light">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-black">Alex Rivers</p>
                    <p class="text-[10px] text-text-sub-light font-bold">Guide Certifié</p>
                </div>
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" class="size-10 rounded-full bg-primary/5 object-cover" alt="Profile">
            </div>
        </div>
    </div>
</header>

<div class="flex flex-1 w-full max-w-[1280px] mx-auto">
    <aside class="w-64 hidden lg:flex flex-col gap-2 p-6 border-r border-border-light">
        <nav class="flex flex-col gap-1">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary font-bold transition-all">
                <span class="material-symbols-outlined">dashboard</span> Tableau de bord
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                <span class="material-symbols-outlined">video_library</span> Mes Meetings
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                <span class="material-symbols-outlined">groups</span> Participants
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                <span class="material-symbols-outlined">payments</span> Revenus
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-sub-light hover:bg-white hover:text-primary transition-all font-medium">
                <span class="material-symbols-outlined">settings</span> Paramètres
            </a>
        </nav>
        <div class="mt-auto pt-6 border-t border-border-light">
            <button class="flex items-center gap-3 px-4 py-3 w-full rounded-xl text-secondary font-bold hover:bg-secondary/5 transition-all">
                <span class="material-symbols-outlined">logout</span> Déconnexion
            </button>
        </div>
    </aside>

    <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">
        
        <section class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-black text-text-main-light">Bonjour, Alex 👋</h2>
                <p class="text-text-sub-light font-medium">Voici l'activité de vos sessions aujourd'hui.</p>
            </div>
            <button class="flex items-center gap-2 px-6 py-4 bg-secondary text-white rounded-2xl font-bold hover:scale-[1.02] active:scale-[0.98] transition-all soft-shadow">
                <span class="material-symbols-outlined">add_box</span>
                Créer un meeting
            </button>
        </section>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-primary/10 text-primary rounded-lg italic">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div>
                    <span class="text-green-500 text-xs font-black">+12.5%</span>
                </div>
                <p class="text-text-sub-light text-xs font-bold uppercase tracking-wider">Revenus cumulés</p>
                <h3 class="text-2xl font-black mt-1">1 240,50 €</h3>
            </div>

            <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-secondary/10 text-secondary rounded-lg">
                        <span class="material-symbols-outlined">calendar_month</span>
                    </div>
                </div>
                <p class="text-text-sub-light text-xs font-bold uppercase tracking-wider">Meetings à venir</p>
                <h3 class="text-2xl font-black mt-1">4</h3>
            </div>

            <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                        <span class="material-symbols-outlined">person_add</span>
                    </div>
                </div>
                <p class="text-text-sub-light text-xs font-bold uppercase tracking-wider">Nouveaux inscrits</p>
                <h3 class="text-2xl font-black mt-1">28</h3>
            </div>

            <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                        <span class="material-symbols-outlined">grade</span>
                    </div>
                </div>
                <p class="text-text-sub-light text-xs font-bold uppercase tracking-wider">Note Guide</p>
                <div class="flex items-center gap-1 mt-1">
                    <h3 class="text-2xl font-black">4.9</h3>
                    <span class="text-text-sub-light text-sm font-bold">/ 5</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <section class="lg:col-span-2 space-y-4">
                <h3 class="text-lg font-black px-2 flex items-center gap-2">
                    <span class="size-2 bg-secondary rounded-full animate-pulse"></span>
                    Prochaine Session en Direct
                </h3>
                <div class="bg-card-light p-8 rounded-3xl border border-primary/20 bg-gradient-to-br from-white to-primary/5 soft-shadow relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="px-3 py-1 bg-white border border-border-light text-secondary text-[10px] font-black rounded-full uppercase tracking-tighter shadow-sm">
                                Demain • 14:00 (60 min)
                            </span>
                        </div>
                        <h4 class="text-2xl font-black mt-2 mb-3 leading-tight">Architecture logicielle : <br/>Maîtriser le pattern MVC avec Laravel</h4>
                        <div class="flex items-center gap-4 text-text-sub-light mb-8">
                            <span class="flex items-center gap-1 text-xs font-bold">
                                <span class="material-symbols-outlined text-sm">group</span> 12 inscrits
                            </span>
                            <span class="flex items-center gap-1 text-xs font-bold">
                                <span class="material-symbols-outlined text-sm">layers</span> Niveau Intermédiaire
                            </span>
                        </div>
                        
                        <div class="flex flex-wrap gap-4">
                            <button class="px-8 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:opacity-90 transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined">videocam</span> Lancer le meeting
                            </button>
                            <button class="px-6 py-3 bg-white border border-border-light text-text-main-light rounded-xl font-bold text-sm hover:bg-slate-50 transition-colors">
                                Gérer les ressources
                            </button>
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -right-6 -bottom-6 text-[180px] text-primary/10 group-hover:scale-110 transition-transform duration-500">
                        cast_for_education
                    </span>
                </div>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg font-black px-2">Derniers Avis</h3>
                <div class="space-y-4">
                    <div class="bg-card-light p-5 rounded-2xl border border-border-light soft-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex text-secondary gap-0.5">
                                <span class="material-symbols-outlined text-[14px] fill" style="font-variation-settings: 'FILL' 1">star</span>
                                <span class="material-symbols-outlined text-[14px] fill" style="font-variation-settings: 'FILL' 1">star</span>
                                <span class="material-symbols-outlined text-[14px] fill" style="font-variation-settings: 'FILL' 1">star</span>
                                <span class="material-symbols-outlined text-[14px] fill" style="font-variation-settings: 'FILL' 1">star</span>
                                <span class="material-symbols-outlined text-[14px] fill" style="font-variation-settings: 'FILL' 1">star</span>
                            </div>
                            <span class="text-[9px] font-black text-text-sub-light uppercase">Il y a 2h</span>
                        </div>
                        <p class="text-xs font-medium text-text-main-light leading-relaxed">"Explications limpides sur le routing Laravel. Alex prend vraiment le temps de répondre aux questions."</p>
                        <div class="mt-3 pt-3 border-t border-border-light flex items-center gap-2">
                            <div class="size-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-black">TL</div>
                            <p class="text-[10px] text-text-sub-light font-bold">Thomas L. • Développeur Junior</p>
                        </div>
                    </div>
                </div>
                <button class="w-full py-3 text-sm font-bold text-primary hover:bg-primary/5 rounded-xl transition-all">
                    Lire tous les avis
                </button>
            </section>
        </div>

        <section class="space-y-4">
            <div class="flex justify-between items-center px-2">
                <h3 class="text-lg font-black">Historique des meetings</h3>
                <div class="flex gap-2">
                    <button class="p-2 bg-white border border-border-light rounded-lg text-text-sub-light">
                        <span class="material-symbols-outlined text-sm">filter_list</span>
                    </button>
                    <button class="p-2 bg-white border border-border-light rounded-lg text-text-sub-light">
                        <span class="material-symbols-outlined text-sm">download</span>
                    </button>
                </div>
            </div>
            <div class="bg-card-light rounded-3xl border border-border-light overflow-hidden soft-shadow">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 text-text-sub-light text-[10px] font-black uppercase tracking-widest border-b border-border-light">
                                <th class="px-6 py-5">Meeting / Catégorie</th>
                                <th class="px-6 py-5">Date & Heure</th>
                                <th class="px-6 py-5">Audience</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-light">
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <p class="font-bold text-sm text-text-main-light group-hover:text-primary transition-colors">Débuter avec React et Tailwind</p>
                                        <p class="text-[10px] text-text-sub-light font-bold uppercase mt-0.5">Développement Front-end</p>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-bold">10 Fév 2026</p>
                                    <p class="text-xs text-text-sub-light font-medium">10:00 - 11:30</p>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex -space-x-2">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=A" class="size-7 rounded-full border-2 border-white bg-slate-100 shadow-sm">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=B" class="size-7 rounded-full border-2 border-white bg-slate-100 shadow-sm">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=C" class="size-7 rounded-full border-2 border-white bg-slate-100 shadow-sm">
                                        <div class="size-7 rounded-full border-2 border-white bg-primary text-white text-[9px] flex items-center justify-center font-black shadow-sm">+15</div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase">
                                        <span class="size-1.5 bg-green-500 rounded-full"></span> Terminé
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="p-2 text-text-sub-light hover:text-primary transition-colors hover:bg-primary/5 rounded-lg">
                                        <span class="material-symbols-outlined text-lg">analytics</span>
                                    </button>
                                    <button class="p-2 text-text-sub-light hover:text-secondary transition-colors hover:bg-secondary/5 rounded-lg">
                                        <span class="material-symbols-outlined text-lg">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <p class="font-bold text-sm text-text-main-light group-hover:text-primary transition-colors">Freelance : Bien fixer ses prix</p>
                                        <p class="text-[10px] text-text-sub-light font-bold uppercase mt-0.5">Entrepreneuriat</p>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-bold">04 Fév 2026</p>
                                    <p class="text-xs text-text-sub-light font-medium">15:00 - 16:00</p>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex -space-x-2">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=D" class="size-7 rounded-full border-2 border-white bg-slate-100 shadow-sm">
                                        <div class="size-7 rounded-full border-2 border-white bg-primary text-white text-[9px] flex items-center justify-center font-black shadow-sm">+42</div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase">
                                        <span class="size-1.5 bg-green-500 rounded-full"></span> Terminé
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="p-2 text-text-sub-light hover:text-primary transition-colors hover:bg-primary/5 rounded-lg">
                                        <span class="material-symbols-outlined text-lg">analytics</span>
                                    </button>
                                    <button class="p-2 text-text-sub-light hover:text-secondary transition-colors hover:bg-secondary/5 rounded-lg">
                                        <span class="material-symbols-outlined text-lg">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>
</div>

</body>
</html>