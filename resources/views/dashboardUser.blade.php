@extends('layouts.user')

@section('title', 'Sherpa Profile - Dashboard')
    
@section('content')


        <section class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light flex flex-col md:flex-row items-center gap-8">
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
            <div class="flex justify-between items-center mb-4 px-2">
                <h3 class="text-lg font-black">Cours disponibles</h3>
                <a href="{{ route('user.courses.index') }}" class="text-sm text-primary font-bold hover:underline">Voir tous les cours</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses ?? [] as $course)
                    <article class="bg-card-light rounded-3xl border border-border-light overflow-hidden soft-shadow transition-transform hover:-translate-y-1">
                        <div class="h-40 bg-slate-100 relative">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center opacity-20">
                                    <span class="material-symbols-outlined text-6xl">school</span>
                                </div>
                            @endif
                            <button class="absolute top-4 right-4 bg-white p-2 rounded-full text-secondary hover:bg-slate-50 transition-colors">
                                <span class="material-symbols-outlined fill" style="font-variation-settings: 'FILL' 1">favorite</span>
                            </button>
                        </div>
                        <div class="p-5">
                            <h4 class="font-black text-base mb-2 leading-tight">{{ $course->title }}</h4>
                            <p class="text-sm text-text-sub-light mb-4 line-clamp-2">{{ Str::limit($course->description, 80) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-primary">{{ $course->price }} €</span>
                                <span class="text-sm text-text-sub-light">{{ $course->duration }} min</span>
                            </div>
                            <div class="flex items-center gap-3 pt-4 border-t border-border-light mt-4">
                                <img src="{{ $course->guide->profile_image ? asset('storage/' . $course->guide->profile_image) : asset('images/default/profile-default.jpg') }}" class="size-8 rounded-full">
                                <a href="{{ route('user.tutors.show', $course->guide) }}" class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors">{{ $course->guide->name }} <span class="text-primary">• Guide</span></a>
                            </div>
                            <a href="{{ route('user.courses.show', $course) }}" class="mt-4 block px-4 py-2 bg-primary text-white rounded-xl text-center font-bold hover:bg-primary/90 transition-all text-sm">
                                Réserver
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-text-sub-light">Aucun cours disponible pour le moment.</p>
                    </div>
                @endforelse
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
    </script>
@endsection