@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">My Favorite Properties</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
    @endif

    @if($favorites->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($favorites as $favorite)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="aspect-square bg-gray-200 overflow-hidden">
                        @if($favorite->property->image)
                            <img src="{{ Storage::url($favorite->property->image) }}" alt="{{ $favorite->property->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-300">No Image</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $favorite->property->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($favorite->property->description, 60) }}</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xl font-bold text-blue-600">৳{{ number_format($favorite->property->price) }}</span>
                        </div>
                        <div class="flex gap-2 mb-4">
                            <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ $favorite->property->bedrooms }} Bed</span>
                            <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ $favorite->property->bathrooms }} Bath</span>
                        </div>
                        <a href="{{ route('properties.show', $favorite->property) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 mb-2">View Details</a>
                        <form action="{{ route('favorites.destroy', $favorite->property) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-center bg-red-600 text-white py-2 rounded hover:bg-red-700">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if($favorites->hasPages())
            <div class="mt-8">{{ $favorites->links() }}</div>
        @endif
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <p class="text-gray-600 mb-6">You haven't added any properties to your favorites yet.</p>
            <a href="{{ route('properties.index') }}" class="inline-block bg-blue-600 text-white font-semibold py-3 px-6 rounded hover:bg-blue-700">
                Browse Properties
            </a>
        </div>
    @endif
</div>
@endsection
