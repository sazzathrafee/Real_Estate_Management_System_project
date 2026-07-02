@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Buyer Dashboard</h1>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Favorite Properties</p>
            <p class="text-3xl font-bold">{{ $totalFavorites }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Visit Requests</p>
            <p class="text-3xl font-bold">{{ $totalVisitRequests }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Approved Visits</p>
            <p class="text-3xl font-bold text-green-600">{{ $approvedVisitRequests }}</p>
        </div>
    </div>

    <!-- Favorite Properties -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">My Favorite Properties</h2>
        
        @if($favorites->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($favorites as $favorite)
                    @if($favorite->property)
                        <div class="rounded-lg border overflow-hidden hover:shadow-lg transition">
                            <div class="aspect-square bg-gray-200 overflow-hidden">
                                @if($favorite->property->image)
                                    <img src="{{ Storage::url($favorite->property->image) }}" alt="{{ $favorite->property->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-300">No Image</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold mb-2">{{ $favorite->property->title }}</h3>
                                <p class="text-lg font-bold text-blue-600 mb-2">৳{{ number_format($favorite->property->price) }}</p>
                                <div class="flex gap-2 mb-4">
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $favorite->property->bedrooms }} Bed</span>
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $favorite->property->bathrooms }} Bath</span>
                                </div>
                                <a href="{{ route('properties.show', $favorite->property) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 text-sm mb-2">View</a>
                                <form action="{{ route('favorites.destroy', $favorite->property) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-center bg-red-600 text-white py-2 rounded hover:bg-red-700 text-sm">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No favorite properties yet.</p>
        @endif

        @if($favorites->hasPages())
            <div class="mt-6">{{ $favorites->links() }}</div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold mb-4">Browse Properties</h3>
            <p class="text-gray-600 mb-4">Explore our collection of properties available for sale and rent.</p>
            <a href="{{ route('properties.index') }}" class="block w-full text-center bg-blue-600 text-white font-semibold py-3 rounded hover:bg-blue-700">Browse Now</a>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold mb-4">My Visit Requests</h3>
            <p class="text-gray-600 mb-4">Check the status of your property visit requests.</p>
            <a href="{{ route('visits.buyer.index') }}" class="block w-full text-center bg-green-600 text-white font-semibold py-3 rounded hover:bg-green-700">View Requests</a>
        </div>
    </div>
</div>
@endsection
