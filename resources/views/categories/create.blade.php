@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Add New Category</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Category Name</label>
            <input type="text" name="category_name" class="w-full px-4 py-2 border rounded" required value="{{ old('category_name') }}">
            @error('category_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" class="w-full px-4 py-2 border rounded" rows="4">{{ old('description') }}</textarea>
            @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded hover:bg-blue-700">Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="flex-1 text-center bg-gray-600 text-white font-bold py-3 rounded hover:bg-gray-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
