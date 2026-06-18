@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg py-16 px-8 mb-12">
        <h1 class="text-4xl font-bold mb-4">Real Estate Management System</h1>
        <p class="text-lg mb-6">Find your dream property in Bangladesh or list your properties with us</p>
        <form action="{{ route('properties.search') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="keyword" placeholder="Search properties..." class="px-4 py-2 rounded text-black" value="{{ request('keyword') }}">
                <select name="city" class="px-4 py-2 rounded text-black">
                    <option value="">All Cities</option>
                    <option value="Dhaka" {{ request('city') == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                    <option value="Khulna" {{ request('city') == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                    <option value="Chattogram" {{ request('city') == 'Chattogram' ? 'selected' : '' }}>Chattogram</option>
                </select>
                <button type="submit" class="bg-white text-blue-600 font-bold px-4 py-2 rounded hover:bg-gray-100">Search</button>
            </div>
        </form>
    </div>

    <div class="mb-12">
        <h2 class="text-3xl font-bold mb-6">Featured Properties</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($properties as $property)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="aspect-square bg-gray-200 overflow-hidden">
                        @if($property->image)
                            <img src="{{ Storage::url($property->image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center bg-gray-300 text-gray-600\'>No Image</div>'">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-600">No Image</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $property->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($property->description, 80) }}</p>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xl font-bold text-blue-600">৳{{ number_format($property->price) }}</span>
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ ucfirst($property->property_type) }}</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-2">{{ $property->location }}, {{ $property->city }}</p>
                        <div class="flex gap-2 mb-4 flex-wrap">
                            @if($property->bedrooms > 0)<span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ $property->bedrooms }} Bed</span>@endif
                            @if($property->bathrooms > 0)<span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ $property->bathrooms }} Bath</span>@endif
                            <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ $property->area_size }} sqft</span>
                        </div>
                        <a href="{{ route('properties.show', $property) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">View Details</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">No properties available yet.</div>
            @endforelse
        </div>
    </div>

    @if($properties->hasPages())
        <div class="flex justify-center mb-12">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection
