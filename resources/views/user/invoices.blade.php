@extends('layouts.user')

@section('title', 'Sheerpa - Invoices')

@section('content')
    <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-text-main-light">Invoices</h1>
            <p class="text-text-sub-light">View and download your invoices</p>
        </div>

        <div class="bg-white rounded-2xl border border-border-light overflow-hidden">
            <div class="divide-y divide-border-light">
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">description</span>
                        <div>
                            <p class="text-sm font-bold">JANUARY_2026.pdf</p>
                            <p class="text-xs text-text-sub-light">15 Jan 2026 • $45.00</p>
                        </div>
                    </div>
                    <button class="p-2 text-primary hover:bg-primary/10 rounded-lg">
                        <span class="material-symbols-outlined">download</span>
                    </button>
                </div>
                
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">description</span>
                        <div>
                            <p class="text-sm font-bold">FEBRUARY_2026.pdf</p>
                            <p class="text-xs text-text-sub-light">12 Feb 2026 • $65.00</p>
                        </div>
                    </div>
                    <button class="p-2 text-primary hover:bg-primary/10 rounded-lg">
                        <span class="material-symbols-outlined">download</span>
                    </button>
                </div>
                
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">description</span>
                        <div>
                            <p class="text-sm font-bold">MARCH_2026.pdf</p>
                            <p class="text-xs text-text-sub-light">15 Mar 2026 • $55.00</p>
                        </div>
                    </div>
                    <button class="p-2 text-primary hover:bg-primary/10 rounded-lg">
                        <span class="material-symbols-outlined">download</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection