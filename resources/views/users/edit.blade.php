@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Edit User</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Name</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded" required value="{{ old('name', $user->name) }}">
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 border rounded" required value="{{ old('email', $user->email) }}">
            @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Role</label>
            <select name="role" class="w-full px-4 py-2 border rounded" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="seller" {{ old('role', $user->role) == 'seller' ? 'selected' : '' }}>Seller</option>
                <option value="buyer" {{ old('role', $user->role) == 'buyer' ? 'selected' : '' }}>Buyer</option>
            </select>
            @error('role')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Phone</label>
            <input type="text" name="phone" class="w-full px-4 py-2 border rounded" value="{{ old('phone', $user->phone) }}">
            @error('phone')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Address</label>
            <input type="text" name="address" class="w-full px-4 py-2 border rounded" value="{{ old('address', $user->address) }}">
            @error('address')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded hover:bg-blue-700">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="flex-1 text-center bg-gray-600 text-white font-bold py-3 rounded hover:bg-gray-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
