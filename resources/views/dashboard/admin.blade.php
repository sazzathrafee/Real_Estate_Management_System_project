@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Total Users</p>
            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Total Sellers</p>
            <p class="text-3xl font-bold">{{ $totalSellers }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Total Buyers</p>
            <p class="text-3xl font-bold">{{ $totalBuyers }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Total Properties</p>
            <p class="text-3xl font-bold">{{ $totalProperties }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Approved Properties</p>
            <p class="text-3xl font-bold">{{ $approvedProperties }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Pending Properties</p>
            <p class="text-3xl font-bold">{{ $pendingProperties }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Total Visit Requests</p>
            <p class="text-3xl font-bold">{{ $totalVisitRequests }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Properties -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Recent Properties</h2>
            <div class="space-y-4">
                @foreach($recentProperties as $property)
                    <div class="border-b pb-4 last:border-b-0">
                        <p class="font-semibold">{{ $property->title }}</p>
                        <p class="text-sm text-gray-600">By: {{ $property->seller->name }}</p>
                        <p class="text-sm text-gray-600">৳{{ number_format($property->price) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('admin.properties.pending') }}" class="block bg-yellow-600 text-white font-semibold py-3 px-4 rounded hover:bg-yellow-700 text-center">
                    Review Pending Properties
                </a>
                <a href="{{ route('admin.users.create') }}" class="block bg-blue-600 text-white font-semibold py-3 px-4 rounded hover:bg-blue-700 text-center">
                    Create New User
                </a>
                <a href="{{ route('admin.categories.create') }}" class="block bg-green-600 text-white font-semibold py-3 px-4 rounded hover:bg-green-700 text-center">
                    Create Category
                </a>
            </div>
        </div>
    </div>

    <!-- Pending Approvals -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Properties Awaiting Approval</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2 text-left">Seller</th>
                        <th class="px-4 py-2 text-left">Price</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingApprovals as $property)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $property->title }}</td>
                            <td class="px-4 py-2">{{ $property->seller->name }}</td>
                            <td class="px-4 py-2">৳{{ number_format($property->price) }}</td>
                            <td class="px-4 py-2">{{ $property->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.properties.show', $property) }}" class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No pending properties</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pendingApprovals->hasPages())
            <div class="mt-4">{{ $pendingApprovals->links() }}</div>
        @endif
    </div>
</div>
@endsection
