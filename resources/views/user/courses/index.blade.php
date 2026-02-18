@extends('layouts.user-full-width')

@section('title', 'Sheerpa - Nos Cours')

@section('content')
<div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
            
            <div class="mb-8">
                <h1 class="text-2xl font-black text-text-main-light">Nos Cours</h1>
                <p class="text-text-sub-light">Parcourez tous les cours disponibles</p>
            </div>

            {{-- Search and Filter Form --}}
            <form method="GET" action="{{ route('user.courses.index') }}" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un cours..." class="w-full pl-12 pr-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-text-sub-light">search</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <select name="category" class="flex-1 px-4 py-3 bg-white border border-border-light rounded-xl focus:ring-primary focus:border-primary transition-all">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-4 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm">filter_list</span>
                        </button>
                        @if(request('search') || request('category'))
                            <a href="{{ route('user.courses.index') }}" class="px-4 py-3 bg-white border border-border-light text-text-main-light rounded-xl font-bold hover:bg-slate-50 transition-all flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            @if (session('status'))
                <div class="bg-primary/10 text-primary px-4 py-3 rounded-xl font-bold mb-4">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl font-bold mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($courses as $course)
                    <article class="bg-white rounded-2xl border border-border-light soft-shadow overflow-hidden flex flex-col transition-transform hover:-translate-y-1 cursor-pointer group" onclick="window.location.href='{{ route('user.courses.show', $course) }}'">

                        {{-- Thumbnail --}}
                        <div class="relative h-48 overflow-hidden">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                     alt="{{ $course->title }}"
                                     class="w-full h-full object-cover transition-transform hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-6xl text-slate-300">school</span>
                                </div>
                            @endif
                            <button class="favorite-btn absolute top-3 right-3 bg-white p-2 rounded-full shadow-md hover:bg-slate-50 transition-all transform hover:scale-110 {{ $course->isFavoritedBy(auth()->id()) ? 'favorited text-red-500' : 'text-secondary' }}" data-course-id="{{ $course->id }}" onclick="event.stopPropagation();">
                                <span class="material-symbols-outlined fill transition-all" style="font-variation-settings: 'FILL' {{ $course->isFavoritedBy(auth()->id()) ? '1' : '0' }}">favorite</span>
                            </button>
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            {{-- Category Badge --}}
                            @if($course->categoryModel)
                                <div class="mb-3">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full">
                                        <span class="material-symbols-outlined text-xs">{{ $course->categoryModel->icon }}</span>
                                        {{ $course->categoryModel->name }}
                                    </span>
                                </div>
                            @endif

                            <h4 class="font-black text-lg mb-2 text-text-main-light line-clamp-2 group-hover:text-primary transition-colors">
                                {{ $course->title }}
                            </h4>

                            <p class="text-sm text-text-sub-light mb-4 line-clamp-2 flex-grow">
                                {{ Str::limit($course->description, 120) }}
                            </p>

                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-border-light">
                                <span class="text-lg font-black text-primary">
                                    {{ $course->price }} €
                                </span>
                                <div class="flex items-center gap-1 text-sm text-text-sub-light">
                                    <span class="material-symbols-outlined text-sm">schedule</span>
                                    {{ $course->duration }} min
                                </div>
                            </div>

                            {{-- Guide avec image profil --}}
                            <div class="flex items-center gap-3 mb-4">
                                <img
                                    src="{{ $course->guide->profile_image
                                            ? asset('storage/' . $course->guide->profile_image)
                                            : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $course->guide->id }}"
                                    class="size-10 rounded-full border-2 border-border-light"
                                    alt="{{ $course->guide->name }}">
                                <div class="flex-grow min-w-0">
                                    <p class="text-xs text-text-sub-light font-bold">Instructeur</p>
                                    <a href="{{ route('user.tutors.show', $course->guide) }}" class="text-sm font-bold text-text-main-light hover:text-primary transition-colors truncate block" onclick="event.stopPropagation();">
                                        {{ $course->guide->name }}
                                    </a>
                                </div>
                            </div>

                            <a href="{{ route('user.courses.show', $course) }}"
                               class="w-full px-4 py-3 bg-primary text-white rounded-xl text-center font-bold hover:bg-primary/90 transition-all flex items-center justify-center gap-2"
                               onclick="event.stopPropagation();">
                                <span class="material-symbols-outlined text-sm">calendar_month</span>
                                Réserver
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full bg-white p-8 rounded-2xl border border-border-light soft-shadow text-center text-text-sub-light">
                        <div class="flex flex-col items-center justify-center">
                            <span class="material-symbols-outlined text-4xl text-slate-300 mb-4">
                                school
                            </span>
                            <p class="text-lg font-bold">
                                Aucun cours disponible pour le moment
                            </p>
                            <p class="mt-2">
                                Revenez bientôt pour découvrir de nouveaux cours
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($courses->hasPages())
                <div class="mt-8 flex justify-center overflow-x-auto">
                    {{ $courses->links() }}
                </div>
            @endif

        </div>
</div>

<script>
    // Favorite button functionality
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const courseId = this.getAttribute('data-course-id');
            const icon = this.querySelector('.material-symbols-outlined');
            
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }
            
            // Make the request
            fetch(`/user/courses/${courseId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Toggle the favorited state with RED color
                    if (data.is_favorited) {
                        // Make heart RED and filled
                        this.classList.add('text-red-500');
                        this.classList.remove('text-secondary');
                        icon.style.fontVariationSettings = "'FILL' 1";
                        icon.style.color = '#ef4444'; // Red-500
                    } else {
                        // Make heart orange and empty
                        this.classList.remove('text-red-500');
                        this.classList.add('text-secondary');
                        icon.style.fontVariationSettings = "'FILL' 0";
                        icon.style.color = '';
                    }
                    
                    // Add bounce animation
                    icon.classList.add('animate-bounce');
                    setTimeout(() => {
                        icon.classList.remove('animate-bounce');
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error toggling favorite:', error);
            });
        });
    });
</script>
@endsection
