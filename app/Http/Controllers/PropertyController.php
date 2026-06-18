<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyCategory;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $properties = Property::with('seller', 'category')
            ->where('approval_status', 'approved')
            ->paginate(12);
        
        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = PropertyCategory::all();
        return view('properties.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['seller_id'] = auth()->id();
        $data['approval_status'] = 'pending';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('properties', 'public');
        }

        $property = Property::create($data);

        // Store additional images if provided
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $property->images()->create([
                    'image_path' => $image->store('properties', 'public'),
                ]);
            }
        }

        return redirect()->route('properties.show', $property)->with('success', 'Property created successfully. Awaiting admin approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property): View
    {
        $property->load('seller', 'category', 'images', 'visitRequests');
        $isFavorited = auth()->check() ? auth()->user()->favorites()->where('property_id', $property->id)->exists() : false;
        
        return view('properties.show', compact('property', 'isFavorited'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property): View
    {
        if (auth()->id() !== $property->seller_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = PropertyCategory::all();
        return view('properties.edit', compact('property', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property): RedirectResponse
    {
        if (auth()->id() !== $property->seller_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('properties', 'public');
        }

        $property->update($data);

        return redirect()->route('properties.show', $property)->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property): RedirectResponse
    {
        if (auth()->id() !== $property->seller_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }

    /**
     * Search and filter properties
     */
    public function search(): View
    {
        $query = Property::with('seller', 'category')
            ->where('approval_status', 'approved');

        if (request()->has('keyword') && request('keyword')) {
            $query->where('title', 'like', '%' . request('keyword') . '%')
                  ->orWhere('description', 'like', '%' . request('keyword') . '%');
        }

        if (request()->has('category') && request('category')) {
            $query->where('category_id', request('category'));
        }

        if (request()->has('city') && request('city')) {
            $query->where('city', 'like', '%' . request('city') . '%');
        }

        if (request()->has('property_type') && request('property_type')) {
            $query->where('property_type', request('property_type'));
        }

        if (request()->has('min_price') && request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        if (request()->has('max_price') && request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        $properties = $query->paginate(12);
        $categories = PropertyCategory::all();

        return view('properties.search', compact('properties', 'categories'));
    }
}
