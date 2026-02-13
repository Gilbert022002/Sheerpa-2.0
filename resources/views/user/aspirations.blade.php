@extends('layouts.user')

@section('title', 'Sheerpa - My Aspirations')

@section('content')
    <div class="bg-card-light rounded-3xl p-8 soft-shadow border border-border-light">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-text-main-light">My Aspirations</h1>
            <p class="text-text-sub-light">Manage your career aspirations and goals</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow">
                <h4 class="font-bold text-lg mb-2">Become a web developer</h4>
                <p class="text-sm text-text-sub-light mb-4">Focusing on React and Modern CSS Frameworks.</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold px-2 py-1 bg-primary/10 text-primary rounded">In Progress</span>
                    <button class="text-sm text-primary font-bold hover:underline">Edit</button>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-border-light soft-shadow">
                <h4 class="font-bold text-lg mb-2">Improve interview skills</h4>
                <p class="text-sm text-text-sub-light mb-4">Practicing technical storytelling and soft skills.</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold px-2 py-1 bg-green-100 text-green-700 rounded">Completed</span>
                    <button class="text-sm text-primary font-bold hover:underline">Edit</button>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <button class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all">
                Add New Aspiration
            </button>
        </div>
    </div>
@endsection