@extends('layouts.user')

@section('title', 'Sheerpa - Mes Réservations')

@section('content')
            <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
                <div class="mb-8">
                    <h1 class="text-2xl font-black text-text-main-light">Mes Réservations</h1>
                    <p class="text-text-sub-light">Consultez vos sessions programmées et passées</p>
                </div>

                <div>
                    <h2 class="text-lg font-bold text-text-main-light mb-4">Sessions à venir</h2>
                    <div class="overflow-x-auto rounded-2xl border border-border-light">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Cours</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Instructeur</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Date/Heure</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($bookings as $booking)
                                    @if ($booking->status === 'confirmed' && \Carbon\Carbon::parse($booking->start_datetime)->isFuture())
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">
                                            @if($booking->course)
                                                {{ $booking->course->title }}
                                            @else
                                                Session individuelle
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ $booking->guide->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmé
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($booking->meeting_link)
                                                <a href="{{ $booking->meeting_link }}" target="_blank" class="px-4 py-2 bg-primary text-white rounded-lg font-bold hover:bg-primary/90 transition-all">
                                                    Rejoindre le meeting
                                                </a>
                                            @else
                                                <span class="text-text-sub-light">Lien non disponible</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-text-sub-light">
                                            <div class="flex flex-col items-center justify-center">
                                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-4">calendar_today</span>
                                                <p class="text-lg font-bold">Aucune session à venir</p>
                                                <p class="mt-2">Vos prochaines réservations apparaîtront ici</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-12">
                    <h2 class="text-lg font-bold text-text-main-light mb-4">Sessions passées</h2>
                    <div class="overflow-x-auto rounded-2xl border border-border-light">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Cours</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Instructeur</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Date/Heure</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-text-sub-light uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($bookings as $booking)
                                    @if ($booking->status === 'confirmed' && \Carbon\Carbon::parse($booking->start_datetime)->isPast())
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">
                                            @if($booking->course)
                                                {{ $booking->course->title }}
                                            @else
                                                Session individuelle
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ $booking->guide->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-text-main-light">{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Terminé
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($booking->meeting_link)
                                                <a href="{{ $booking->meeting_link }}" target="_blank" class="px-4 py-2 bg-primary text-white rounded-lg font-bold hover:bg-primary/90 transition-all">
                                                    Rejoindre le meeting
                                                </a>
                                            @else
                                                <span class="text-text-sub-light">Lien non disponible</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-text-sub-light">
                                            <div class="flex flex-col items-center justify-center">
                                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-4">history</span>
                                                <p class="text-lg font-bold">Aucune session passée</p>
                                                <p class="mt-2">Vos sessions terminées apparaîtront ici</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
@endsection