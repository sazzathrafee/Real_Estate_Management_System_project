@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">All Visit Requests</h1>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Property</th>
                    <th class="px-4 py-3 text-left font-semibold">Buyer</th>
                    <th class="px-4 py-3 text-left font-semibold">Seller</th>
                    <th class="px-4 py-3 text-left font-semibold">Date</th>
                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visitRequests as $request)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ Str::limit($request->property->title, 25) }}</td>
                        <td class="px-4 py-3">{{ $request->buyer->name }}</td>
                        <td class="px-4 py-3">{{ $request->property->seller->name }}</td>
                        <td class="px-4 py-3">{{ $request->visit_date->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ 
                                $request->request_status == 'approved' ? 'bg-green-100 text-green-800' : 
                                ($request->request_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')
                            }}">
                                {{ ucfirst($request->request_status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No visit requests</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($visitRequests->hasPages())
        <div class="mt-6">{{ $visitRequests->links() }}</div>
    @endif
</div>
@endsection
