<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    /**
     * Display user's favorite properties
     */
    public function index(): View
    {
        $favorites = auth()->user()->favorites()->with('property.seller', 'property.category')->paginate(12);
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Add property to favorites
     */
    public function store(Property $property): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to add favorites.');
        }

        if (!auth()->user()->isBuyer()) {
            return redirect()->back()->with('error', 'Only buyers can add favorites.');
        }

        $exists = Favorite::where('buyer_id', auth()->id())
            ->where('property_id', $property->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'Already in your favorites.');
        }

        Favorite::create([
            'buyer_id' => auth()->id(),
            'property_id' => $property->id,
        ]);

        return redirect()->back()->with('success', 'Added to favorites.');
    }

    /**
     * Remove property from favorites
     */
    public function destroy(Property $property): RedirectResponse
    {
        Favorite::where('buyer_id', auth()->id())
            ->where('property_id', $property->id)
            ->delete();

        return redirect()->back()->with('success', 'Removed from favorites.');
    }
}
