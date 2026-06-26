@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Search Properties</h1>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form action="{{ route('properties.search') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <input type="text" name="keyword" placeholder="Keyword" class="px-4 py-2 border rounded" value="{{ request('keyword') }}">
                
                <select name="category" class="px-4 py-2 border rounded">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                    @endforeach
                </select>

                <select name="city" class="px-4 py-2 border rounded">
                    <option value="">All Cities</option>
                    <option value="Dhaka" {{ request('city') == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                    <option value="Khulna" {{ request('city') == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                    <option value="Chattogram" {{ request('city') == 'Chattogram' ? 'selected' : '' }}>Chattogram</option>
                </select>

                <select name="property_type" class="px-4 py-2 border rounded">
                    <option value="">All Types</option>
                    <option value="sale" {{ request('property_type') == 'sale' ? 'selected' : '' }}>Sale</option>
                    <option value="rent" {{ request('property_type') == 'rent' ? 'selected' : '' }}>Rent</option>
                </select>

                <button type="submit" class="bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700">Search</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Min Price (BDT)</label>
                    <input type="number" name="min_price" placeholder="Minimum price" class="w-full px-4 py-2 border rounded" value="{{ request('min_price') }}">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Max Price (BDT)</label>
                    <input type="number" name="max_price" placeholder="Maximum price" class="w-full px-4 py-2 border rounded" value="{{ request('max_price') }}">
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($properties as $property)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="aspect-square bg-gray-200 overflow-hidden">
                    @if($property->image)
                        <img src="{{ Storage::url($property->image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center bg-gray-300\'>No Image</div>'">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-300">No Image</div>
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
            <div class="col-span-full text-center text-gray-500 py-8">No properties found.</div>
        @endforelse
    </div>

    @if($properties->hasPages())
        <div class="flex justify-center mt-12">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection
