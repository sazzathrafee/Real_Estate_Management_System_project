@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Seller Dashboard</h1>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Total Properties</p>
            <p class="text-3xl font-bold">{{ $totalProperties }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Approved</p>
            <p class="text-3xl font-bold text-green-600">{{ $approvedProperties }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Pending</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $pendingProperties }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Visit Requests</p>
            <p class="text-3xl font-bold">{{ $totalVisitRequests }} ({{ $approvedVisitRequests }} approved)</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Recent Properties -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">My Properties</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Price</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Approval</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $property)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ Str::limit($property->title, 20) }}</td>
                                <td class="px-4 py-2">৳{{ number_format($property->price) }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $property->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($property->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $property->approval_status == 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($property->approval_status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('properties.show', $property) }}" class="text-blue-600 text-xs hover:underline">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">No properties yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6 h-fit">
            <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('properties.create') }}" class="block bg-blue-600 text-white font-semibold py-3 px-4 rounded hover:bg-blue-700 text-center">
                    Add New Property
                </a>
                <a href="{{ route('visits.seller.index') }}" class="block bg-green-600 text-white font-semibold py-3 px-4 rounded hover:bg-green-700 text-center">
                    View Visit Requests
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
