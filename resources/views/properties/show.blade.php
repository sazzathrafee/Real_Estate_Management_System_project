@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-gray-200 rounded-lg overflow-hidden mb-6">
                @if($property->image)
                    <img id="mainImage" src="{{ Storage::url($property->image) }}" alt="{{ $property->title }}" class="w-full h-96 object-cover" onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'w-full h-96 flex items-center justify-center bg-gray-300\'>No Image</div>'">
                @else
                    <div class="w-full h-96 flex items-center justify-center bg-gray-300">No Image</div>
                @endif
            </div>

            @if($property->images->count() > 0)
                <div class="grid grid-cols-4 gap-2 mb-8">
                    @foreach($property->images as $image)
                        <img src="{{ Storage::url($image->image_path) }}" alt="Property" class="thumb w-full h-20 object-cover rounded cursor-pointer border-2 transition {{ $loop->first ? 'border-blue-500' : 'border-transparent hover:border-blue-500' }}" onclick="document.getElementById('mainImage').src = this.src; document.querySelectorAll('.thumb').forEach(t => t.classList.remove('border-blue-500')); this.classList.add('border-blue-500');">
                    @endforeach
                </div>
            @endif

            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h1 class="text-3xl font-bold mb-4">{{ $property->title }}</h1>
                <p class="text-gray-700 mb-6">{{ $property->description }}</p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-gray-600 text-sm">Bedrooms</p>
                        <p class="text-2xl font-bold">{{ $property->bedrooms > 0 ? $property->bedrooms : 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-gray-600 text-sm">Bathrooms</p>
                        <p class="text-2xl font-bold">{{ $property->bathrooms > 0 ? $property->bathrooms : 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-gray-600 text-sm">Area Size</p>
                        <p class="text-2xl font-bold">{{ $property->area_size }} sqft</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-gray-600 text-sm">Garage</p>
                        <p class="text-2xl font-bold">{{ $property->garage > 0 ? $property->garage : 'N/A' }}</p>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <p class="text-gray-600 mb-2"><strong>Location:</strong> {{ $property->location }}, {{ $property->city }}</p>
                    <p class="text-gray-600 mb-2"><strong>Division:</strong> {{ $property->division }}</p>
                    <p class="text-gray-600 mb-2"><strong>Category:</strong> {{ $property->category->category_name }}</p>
                    <p class="text-gray-600 mb-2"><strong>Listing Type:</strong> {{ ucfirst($property->property_type) }}</p>
                    <p class="text-gray-600 mb-2"><strong>Status:</strong> {{ ucfirst($property->status) }}</p>
                </div>
            </div>

            @if($property->latitude && $property->longitude)
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-xl font-bold mb-4">Location Map</h3>
                <div id="property-map" style="height: 400px; width: 100%;" class="rounded-lg"></div>
            </div>
            @endif

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold mb-4">Seller Information</h3>
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-lg font-semibold">{{ $property->seller->name }}</p>
                        <p class="text-gray-600">{{ $property->seller->email }}</p>
                        @if($property->seller->phone)
                            <p class="text-gray-600">{{ $property->seller->phone }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6 mb-6 sticky top-20">
                <p class="text-gray-600 text-sm mb-2">Price</p>
                <p class="text-4xl font-bold text-blue-600 mb-6">৳{{ number_format($property->price) }}</p>

                @auth
                    @if(auth()->user()->isBuyer())
                        <form action="{{ route('visit-requests.store', $property) }}" method="POST" class="mb-4">
                            @csrf
                            <button type="button" class="w-full bg-green-600 text-white font-bold py-3 rounded hover:bg-green-700 mb-4" onclick="document.getElementById('visitModal').classList.remove('hidden')">
                                Request Visit
                            </button>
                        </form>

                        @if($isFavorited)
                            <form action="{{ route('favorites.destroy', $property) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded hover:bg-red-700">
                                    Remove from Favorites
                                </button>
                            </form>
                        @else
                            <form action="{{ route('favorites.store', $property) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gray-600 text-white font-bold py-3 rounded hover:bg-gray-700">
                                    Add to Favorites
                                </button>
                            </form>
                        @endif
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="block w-full text-center bg-blue-600 text-white font-bold py-3 rounded hover:bg-blue-700">
                        Login to Request Visit
                    </a>
                @endguest
            </div>
        </div>
    </div>

    @auth
        @if(auth()->user()->isBuyer())
            <div id="visitModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 max-w-md w-full">
                    <h2 class="text-2xl font-bold mb-4">Request Property Visit</h2>
                    <form action="{{ route('visit-requests.store', $property) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Visit Date</label>
                            <input type="date" name="visit_date" required class="w-full px-4 py-2 border rounded" min="{{ now()->addDay()->format('Y-m-d') }}">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Visit Time</label>
                            <input type="time" name="visit_time" required class="w-full px-4 py-2 border rounded">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Message (Optional)</label>
                            <textarea name="message" class="w-full px-4 py-2 border rounded" rows="3"></textarea>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-green-600 text-white font-bold py-2 rounded hover:bg-green-700">Submit</button>
                            <button type="button" class="flex-1 bg-gray-600 text-white font-bold py-2 rounded hover:bg-gray-700" onclick="document.getElementById('visitModal').classList.add('hidden')">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endauth
</div>
@endsection

@push('scripts')
@if($property->latitude && $property->longitude)
<script>
    function initMap() {
        const position = { lat: {{ $property->latitude }}, lng: {{ $property->longitude }} };
        const map = new google.maps.Map(document.getElementById('property-map'), {
            center: position,
            zoom: 15,
        });
        new google.maps.Marker({
            position: position,
            map: map,
            title: '{{ addslashes($property->title) }}',
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
@endif
@endpush
