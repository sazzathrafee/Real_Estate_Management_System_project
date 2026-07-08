@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('admin.properties.pending') }}" class="text-blue-600 hover:underline mb-6 inline-block">Back to Properties</a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="bg-gray-200 rounded-lg overflow-hidden mb-6 h-96">
                    @if($property->image)
                        <img src="{{ Storage::url($property->image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-300">No Image</div>
                    @endif
                </div>

                <h1 class="text-3xl font-bold mb-4">{{ $property->title }}</h1>
                <p class="text-gray-700 mb-6">{{ $property->description }}</p>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-gray-600 text-sm">Bedrooms</p>
                        <p class="text-2xl font-bold">{{ $property->bedrooms }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-gray-600 text-sm">Bathrooms</p>
                        <p class="text-2xl font-bold">{{ $property->bathrooms }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-gray-600 text-sm">Area</p>
                        <p class="text-2xl font-bold">{{ $property->area_size }} sqft</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-gray-600 text-sm">Type</p>
                        <p class="text-2xl font-bold">{{ ucfirst($property->property_type) }}</p>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <p class="text-gray-600 mb-2"><strong>Location:</strong> {{ $property->location }}, {{ $property->city }}</p>
                    <p class="text-gray-600 mb-2"><strong>Price:</strong> ৳{{ number_format($property->price) }}</p>
                    <p class="text-gray-600 mb-2"><strong>Status:</strong> {{ ucfirst($property->status) }}</p>
                    <p class="text-gray-600"><strong>Approval Status:</strong> {{ ucfirst($property->approval_status) }}</p>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6 sticky top-20">
                <h2 class="text-xl font-bold mb-4">Seller Information</h2>
                <p class="text-lg font-semibold mb-2">{{ $property->seller->name }}</p>
                <p class="text-gray-600 mb-2">{{ $property->seller->email }}</p>
                @if($property->seller->phone)
                    <p class="text-gray-600 mb-4">{{ $property->seller->phone }}</p>
                @endif

                <div class="border-t pt-6 mt-6">
                    <h3 class="font-bold mb-4">Actions</h3>
                    @if($property->approval_status == 'pending')
                        <form action="{{ route('admin.properties.approve', $property) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 rounded hover:bg-green-700">Approve</button>
                        </form>
                        <form action="{{ route('admin.properties.reject', $property) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-red-600 text-white font-bold py-2 rounded hover:bg-red-700" onclick="return confirm('Are you sure?')">Reject</button>
                        </form>
                    @else
                        <p class="text-gray-600 text-center py-3">Already {{ $property->approval_status }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
