@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Edit Property</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Title</label>
            <input type="text" name="title" class="w-full px-4 py-2 border rounded" required value="{{ old('title', $property->title) }}">
            @error('title')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Category</label>
            <select name="category_id" class="w-full px-4 py-2 border rounded" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $property->category_id) == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                @endforeach
            </select>
            @error('category_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" class="w-full px-4 py-2 border rounded" rows="5" required>{{ old('description', $property->description) }}</textarea>
            @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Price (BDT)</label>
                <input type="number" name="price" step="0.01" class="w-full px-4 py-2 border rounded" required value="{{ old('price', $property->price) }}">
                @error('price')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Area Size (sqft)</label>
                <input type="number" name="area_size" step="0.01" class="w-full px-4 py-2 border rounded" required value="{{ old('area_size', $property->area_size) }}">
                @error('area_size')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Bedrooms</label>
                <input type="number" name="bedrooms" class="w-full px-4 py-2 border rounded" required value="{{ old('bedrooms', $property->bedrooms) }}">
                @error('bedrooms')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Bathrooms</label>
                <input type="number" name="bathrooms" class="w-full px-4 py-2 border rounded" required value="{{ old('bathrooms', $property->bathrooms) }}">
                @error('bathrooms')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Garage</label>
                <input type="number" name="garage" class="w-full px-4 py-2 border rounded" value="{{ old('garage', $property->garage) }}">
                @error('garage')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Listing Type</label>
                <select name="property_type" class="w-full px-4 py-2 border rounded" required>
                    <option value="sale" {{ old('property_type', $property->property_type) == 'sale' ? 'selected' : '' }}>Sale</option>
                    <option value="rent" {{ old('property_type', $property->property_type) == 'rent' ? 'selected' : '' }}>Rent</option>
                </select>
                @error('property_type')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Division</label>
                <select name="division" class="w-full px-4 py-2 border rounded" required>
                    <option value="">Select Division</option>
                    <option value="Dhaka" {{ old('division', $property->division) == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                    <option value="Khulna" {{ old('division', $property->division) == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                    <option value="Chattogram" {{ old('division', $property->division) == 'Chattogram' ? 'selected' : '' }}>Chattogram</option>
                    <option value="Rajshahi" {{ old('division', $property->division) == 'Rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                    <option value="Barisal" {{ old('division', $property->division) == 'Barisal' ? 'selected' : '' }}>Barisal</option>
                    <option value="Sylhet" {{ old('division', $property->division) == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                    <option value="Rangpur" {{ old('division', $property->division) == 'Rangpur' ? 'selected' : '' }}>Rangpur</option>
                    <option value="Mymensingh" {{ old('division', $property->division) == 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                </select>
                @error('division')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">City</label>
                <input type="text" name="city" class="w-full px-4 py-2 border rounded" required value="{{ old('city', $property->city) }}">
                @error('city')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Location / Address</label>
                <input type="text" name="location" class="w-full px-4 py-2 border rounded" required value="{{ old('location', $property->location) }}">
                @error('location')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Latitude</label>
                <input type="text" name="latitude" class="w-full px-4 py-2 border rounded" value="{{ old('latitude', $property->latitude) }}" placeholder="e.g. 23.7925">
                @error('latitude')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Longitude</label>
                <input type="text" name="longitude" class="w-full px-4 py-2 border rounded" value="{{ old('longitude', $property->longitude) }}" placeholder="e.g. 90.4078">
                @error('longitude')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        @if(auth()->user()->isAdmin())
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded">
                    <option value="available" {{ old('status', $property->status) == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="sold" {{ old('status', $property->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                    <option value="rented" {{ old('status', $property->status) == 'rented' ? 'selected' : '' }}>Rented</option>
                </select>
            </div>
        @endif

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Main Image</label>
            @if($property->image)
                <p class="text-sm text-gray-600 mb-2">Current: <a href="{{ Storage::url($property->image) }}" target="_blank" class="text-blue-600">View</a></p>
            @endif
            <input type="file" name="image" class="w-full px-4 py-2 border rounded" accept="image/*">
            @error('image')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded hover:bg-blue-700">Update Property</button>
            <a href="{{ route('properties.show', $property) }}" class="flex-1 text-center bg-gray-600 text-white font-bold py-3 rounded hover:bg-gray-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
