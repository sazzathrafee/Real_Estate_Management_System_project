@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Property Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700">Add Category</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Description</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Properties</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $category->category_name }}</td>
                        <td class="px-6 py-4">{{ Str::limit($category->description, 50) }}</td>
                        <td class="px-6 py-4">{{ $category->properties_count }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No categories</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
        <div class="mt-6">{{ $categories->links() }}</div>
    @endif
</div>
@endsection
