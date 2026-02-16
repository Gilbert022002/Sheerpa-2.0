@extends('layouts.instructor')

@section('title', $user->name . ' - Profil utilisateur')

@section('content')
    <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
        <div class="flex flex-col md:flex-row items-start gap-8">
            <div class="relative">
                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) . '?' . time() : asset('images/default/profile-default.jpg') }}" class="size-28 rounded-full bg-primary/5 object-cover" alt="{{ $user->name }}">
            </div>
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-2xl font-black">{{ $user->name }}</h2>
                <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-2 text-text-sub-light text-sm font-medium">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-base">mail</span> {{ $user->email }}</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-base">person</span> {{ $user->role }}</span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">calendar_today</span>
                        <span>Inscrit depuis {{ $user->created_at->format('d/m/Y') }}</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow">
                <h3 class="font-bold text-lg mb-4">Informations personnelles</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Nom complet</span>
                        <span class="font-medium">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Email</span>
                        <span class="font-medium">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Téléphone</span>
                        <span class="font-medium">{{ $user->phone ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-sub-light">Spécialité</span>
                        <span class="font-medium">{{ $user->specialty ?? 'Non renseigné' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow">
                <h3 class="font-bold text-lg mb-4">À propos de l'utilisateur</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-text-sub-light font-medium mb-1">Biographie :</p>
                        <p class="text-text-sub-light">
                            {{ $user->bio ?? 'Aucune description fournie. Cet utilisateur n\'a pas encore ajouté de biographie.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-black mb-4">Sessions réservées avec vous</h3>
            @php
                $bookings = $user->bookings()->where('guide_id', auth()->id())->get();
            @endphp
            
            @if($bookings->count() > 0)
                <div class="overflow-x-auto rounded-2xl border border-border-light">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Cours</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Date/Heure</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Paiement</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-text-main-light">
                                        @if($booking->course)
                                            {{ $booking->course->title }}
                                        @else
                                            Session individuelle
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $booking->payment_status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-text-sub-light">Cet utilisateur n'a pas encore réservé de session avec vous.</p>
                </div>
            @endif
        </div>
    </div>
@endsection