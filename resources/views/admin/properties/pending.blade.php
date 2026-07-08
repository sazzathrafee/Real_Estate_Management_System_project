@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Properties Awaiting Approval</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
    @endif

    <div class="space-y-6">
        @forelse($properties as $property)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        @if($property->image)
                            <img src="{{ Storage::url($property->image) }}" alt="{{ $property->title }}" class="w-full h-40 object-cover rounded">
                        @else
                            <div class="w-full h-40 bg-gray-300 flex items-center justify-center rounded">No Image</div>
                        @endif
                    </div>
                    <div class="md:col-span-3">
                        <h2 class="text-xl font-bold mb-2">{{ $property->title }}</h2>
                        <p class="text-gray-600 mb-2">{{ Str::limit($property->description, 150) }}</p>
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <p><strong>Price:</strong> ৳{{ number_format($property->price) }}</p>
                            <p><strong>Type:</strong> {{ ucfirst($property->property_type) }}</p>
                            <p><strong>Location:</strong> {{ $property->city }}</p>
                            <p><strong>Seller:</strong> {{ $property->seller->name }}</p>
                            <p><strong>Bedrooms:</strong> {{ $property->bedrooms }}</p>
                            <p><strong>Bathrooms:</strong> {{ $property->bathrooms }}</p>
                        </div>
                        <div class="flex gap-4">
                            <a href="{{ route('admin.properties.show', $property) }}" class="text-blue-600 hover:underline">View Details</a>
                            <form action="{{ route('admin.properties.approve', $property) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:underline font-semibold">Approve</button>
                            </form>
                            <form action="{{ route('admin.properties.reject', $property) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:underline font-semibold" onclick="return confirm('Are you sure?')">Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <p class="text-gray-600">No properties awaiting approval.</p>
            </div>
        @endforelse
    </div>

    @if($properties->hasPages())
        <div class="mt-8">{{ $properties->links() }}</div>
    @endif
</div>
@endsection
