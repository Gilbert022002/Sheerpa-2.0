@extends('layouts.admin')

@section('title', 'Sheerpa Admin - Dashboard')

@section('content')
        <h1 class="text-2xl font-black text-text-main-light">Tableau de bord Administrateur</h1>

        @if (session('status'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl font-bold">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl font-bold">
                {{ session('error') }}
            </div>
        @endif

        <section>
            <h2 class="text-lg font-black mb-4">Instructeurs en attente de validation</h2>
            @if($pendingInstructors->isEmpty())
                <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow text-center text-text-sub-light">
                    Aucun instructeur en attente de validation pour le moment.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pendingInstructors as $instructor)
                        <div class="bg-card-light p-6 rounded-3xl border border-border-light soft-shadow flex flex-col gap-4">
                            <div class="flex items-center gap-4">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $instructor->id }}" class="size-16 rounded-full bg-primary/5 object-cover" alt="Profile">
                                <div>
                                    <h3 class="text-lg font-black">{{ $instructor->name }}</h3>
                                    <p class="text-sm text-text-sub-light">{{ $instructor->email }}</p>
                                    <p class="text-xs font-bold uppercase text-secondary">{{ $instructor->instructor_status }}</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm text-text-main-light">
                                <p><span class="font-bold">Expérience:</span> {{ Str::limit($instructor->experience, 100) }}</p>
                                @if($instructor->stripe_account_id)
                                    <p><span class="font-bold">Stripe ID:</span> {{ $instructor->stripe_account_id }}</p>
                                @endif
                                @if($instructor->presentation_video_url)
                                    <p><span class="font-bold">Vidéo:</span> <a href="{{ $instructor->presentation_video_url }}" target="_blank" class="text-primary hover:underline">Voir la vidéo</a></p>
                                @endif
                            </div>
                            <div class="flex gap-2 mt-auto pt-4 border-t border-border-light">
                                <form method="POST" action="{{ route('admin.instructors.approve', $instructor) }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-xl font-bold text-sm hover:opacity-90 transition-all">
                                        Approuver
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.instructors.reject', $instructor) }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-xl font-bold text-sm hover:opacity-90 transition-all">
                                        Rejeter
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
@endsection
