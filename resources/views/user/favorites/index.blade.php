@extends('layouts.user')

@section('title', 'Mes Favoris - Sheerpa')

@section('content')
<div class="flex flex-1 w-full max-w-[1280px] mx-auto">
    <main class="flex-1 p-6 md:p-8 space-y-8 overflow-y-auto">
        <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">

            <div class="mb-8">
                <h1 class="text-2xl font-black text-text-main-light">Mes Favoris</h1>
                <p class="text-text-sub-light">Retrouvez tous vos cours favoris</p>
            </div>

            @if($favorites->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($favorites as $course)
                        <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow flex flex-col h-full">

                            {{-- Thumbnail --}}
                            <div class="relative mb-4">
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                         alt="Thumbnail"
                                         class="w-full h-40 object-cover rounded-xl">
                                @else
                                    <div class="bg-slate-200 border-2 border-dashed rounded-xl w-full h-40 flex items-center justify-center">
                                        <span class="text-slate-500 text-sm">Aucune miniature</span>
                                    </div>
                                @endif
                                <button class="favorite-btn absolute top-2 right-2 bg-white p-2 rounded-full hover:bg-slate-50 transition-all transform hover:scale-110 favorited text-red-500" data-course-id="{{ $course->id }}">
                                    <span class="material-symbols-outlined fill transition-all" style="font-variation-settings: 'FILL' 1">favorite</span>
                                </button>
                            </div>

                            <h4 class="font-black text-lg mb-2 text-text-main-light">
                                {{ $course->title }}
                            </h4>

                            <p class="text-sm text-text-sub-light mb-4 flex-grow">
                                {{ Str::limit($course->description, 100) }}
                            </p>

                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm font-bold text-primary">
                                    {{ $course->price }} €
                                </span>
                                <span class="text-sm text-text-sub-light">
                                    {{ $course->duration }} min
                                </span>
                            </div>

                            {{-- Guide avec image profil --}}
                            <div class="flex items-center gap-2 pt-4 border-t border-border-light">
                                <img
                                    src="{{ $course->guide->profile_image
                                            ? asset('storage/' . $course->guide->profile_image)
                                            : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $course->guide->id }}"
                                    class="size-8 rounded-full">
                                <a href="{{ route('user.tutors.show', $course->guide) }}" class="text-sm font-bold text-text-sub-light hover:text-primary transition-colors">
                                    {{ $course->guide->name }}
                                </a>
                            </div>

                            <a href="{{ route('user.courses.show', $course) }}"
                               class="mt-4 px-4 py-3 bg-primary text-white rounded-xl text-center font-bold hover:bg-primary/90 transition-all">
                                Voir les détails et réserver
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="col-span-full bg-white p-8 rounded-2xl border border-border-light soft-shadow text-center text-text-sub-light">
                    <div class="flex flex-col items-center justify-center">
                        <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">favorite</span>
                        <p class="text-lg font-bold">
                            Aucun cours favori pour le moment
                        </p>
                        <p class="mt-2 mb-4">
                            Parcourez nos cours et ajoutez-les à vos favoris
                        </p>
                        <a href="{{ route('user.courses.index') }}" class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all">
                            Découvrir les cours
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </main>
</div>

<script>
    // Favorite button functionality
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const courseId = this.getAttribute('data-course-id');
            const icon = this.querySelector('.material-symbols-outlined');
            const card = this.closest('.bg-white');
            
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
                    // If unfavoriting, remove the card with animation
                    if (!data.is_favorited) {
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        
                        setTimeout(() => {
                            card.remove();
                            
                            // Check if no favorites left
                            const remainingCards = document.querySelectorAll('.bg-white.p-6');
                            if (remainingCards.length === 0) {
                                location.reload();
                            }
                        }, 300);
                    } else {
                        // Make heart RED and filled
                        this.classList.add('text-red-500');
                        this.classList.remove('text-secondary');
                        icon.style.fontVariationSettings = "'FILL' 1";
                        icon.style.color = '#ef4444'; // Red-500
                        
                        // Add bounce animation
                        icon.classList.add('animate-bounce');
                        setTimeout(() => {
                            icon.classList.remove('animate-bounce');
                        }, 1000);
                    }
                }
            })
            .catch(error => {
                console.error('Error toggling favorite:', error);
            });
        });
    });
</script>
@endsection