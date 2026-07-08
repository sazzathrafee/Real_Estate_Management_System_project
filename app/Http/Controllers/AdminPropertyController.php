<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminPropertyController extends Controller
{
    /**
     * Display pending properties for approval
     */
    public function pending(): View
    {
        $properties = Property::where('approval_status', 'pending')
            ->with('seller', 'category')
            ->paginate(10);
        
        return view('admin.properties.pending', compact('properties'));
    }

    /**
     * Display all properties
     */
    public function index(): View
    {
        $properties = Property::with('seller', 'category')
            ->paginate(10);
        
        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Approve a property
     */
    public function approve(Property $property): RedirectResponse
    {
        $property->update(['approval_status' => 'approved']);
        return redirect()->back()->with('success', 'Property approved successfully.');
    }

    /**
     * Reject a property
     */
    public function reject(Property $property): RedirectResponse
    {
        $property->update(['approval_status' => 'rejected']);
        return redirect()->back()->with('success', 'Property rejected successfully.');
    }

    /**
     * Show property details
     */
    public function show(Property $property): View
    {
        $property->load('seller', 'category', 'images', 'visitRequests');
        return view('admin.properties.show', compact('property'));
    }
}
