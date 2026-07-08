@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">All Properties</h1>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Title</th>
                    <th class="px-6 py-3 text-left font-semibold">Seller</th>
                    <th class="px-6 py-3 text-left font-semibold">Price</th>
                    <th class="px-6 py-3 text-left font-semibold">Type</th>
                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                    <th class="px-6 py-3 text-left font-semibold">Approval</th>
                    <th class="px-6 py-3 text-left font-semibold">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $property)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ Str::limit($property->title, 25) }}</td>
                        <td class="px-6 py-4">{{ $property->seller->name }}</td>
                        <td class="px-6 py-4">৳{{ number_format($property->price) }}</td>
                        <td class="px-6 py-4">{{ ucfirst($property->property_type) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $property->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($property->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $property->approval_status == 'approved' ? 'bg-blue-100 text-blue-800' : ($property->approval_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($property->approval_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.properties.show', $property) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No properties</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($properties->hasPages())
        <div class="mt-6">{{ $properties->links() }}</div>
    @endif
</div>
@endsection
