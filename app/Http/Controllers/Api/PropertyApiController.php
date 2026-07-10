<?php

namespace App\Http\Controllers\Api;

use App\Models\Property;
use App\Models\PropertyCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Property::with('seller', 'category', 'images')
            ->where('approval_status', 'approved');

        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        if ($request->has('property_type')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('category_name', $request->property_type);
            });
        }

        if ($request->has('featured')) {
            $query->where('status', 'available')->latest();
        }

        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('city', 'like', "%{$keyword}%")
                  ->orWhere('location', 'like', "%{$keyword}%");
            });
        }

        if ($request->has('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        if ($request->has('area')) {
            $query->where('area_size', '>=', $request->area);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $properties = $query->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $properties->items(),
            'meta' => [
                'current_page' => $properties->currentPage(),
                'last_page' => $properties->lastPage(),
                'per_page' => $properties->perPage(),
                'total' => $properties->total(),
            ],
        ]);
    }

    public function show($id): JsonResponse
    {
        $property = Property::with('seller', 'category', 'images')
            ->where('approval_status', 'approved')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $property,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:property_categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'area_size' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'garage' => 'nullable|integer|min:0',
            'property_type' => 'required|in:sale,rent',
            'city' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'location' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'nullable|in:available,sold,rented',
        ]);

        $validated['seller_id'] = auth()->id() ?? 1;
        $validated['approval_status'] = 'pending';
        $validated['status'] = $validated['status'] ?? 'available';

        $property = Property::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Property created successfully.',
            'data' => $property,
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|exists:property_categories,id',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'area_size' => 'sometimes|numeric|min:0',
            'bedrooms' => 'sometimes|integer|min:0',
            'bathrooms' => 'sometimes|integer|min:0',
            'garage' => 'nullable|integer|min:0',
            'property_type' => 'sometimes|in:sale,rent',
            'city' => 'sometimes|string|max:255',
            'division' => 'sometimes|string|max:255',
            'location' => 'sometimes|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'status' => 'nullable|in:available,sold,rented',
        ]);

        $property->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Property updated successfully.',
            'data' => $property,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return response()->json([
            'success' => true,
            'message' => 'Property deleted successfully.',
        ]);
    }

    public function byCity($city): JsonResponse
    {
        $properties = Property::with('seller', 'category')
            ->where('approval_status', 'approved')
            ->where('city', $city)
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $properties->items(),
            'meta' => [
                'current_page' => $properties->currentPage(),
                'last_page' => $properties->lastPage(),
                'per_page' => $properties->perPage(),
                'total' => $properties->total(),
            ],
        ]);
    }

    public function byType($type): JsonResponse
    {
        $category = PropertyCategory::where('category_name', $type)->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Property type not found.',
            ], 404);
        }

        $properties = Property::with('seller', 'category')
            ->where('approval_status', 'approved')
            ->where('category_id', $category->id)
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $properties->items(),
            'meta' => [
                'current_page' => $properties->currentPage(),
                'last_page' => $properties->lastPage(),
                'per_page' => $properties->perPage(),
                'total' => $properties->total(),
            ],
        ]);
    }

    public function featured(): JsonResponse
    {
        $properties = Property::with('seller', 'category')
            ->where('approval_status', 'approved')
            ->where('status', 'available')
            ->latest()
            ->take(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $properties,
        ]);
    }
}
