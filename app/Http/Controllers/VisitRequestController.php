<?php

namespace App\Http\Controllers;

use App\Models\VisitRequest;
use App\Models\Property;
use App\Http\Requests\StoreVisitRequestRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VisitRequestController extends Controller
{
    /**
     * Store a newly created visit request.
     */
    public function store(StoreVisitRequestRequest $request, Property $property): RedirectResponse
    {
        if (!auth()->user()->isBuyer()) {
            return redirect()->back()->with('error', 'Only buyers can request visits.');
        }

        // Check if request already exists
        $exists = VisitRequest::where('property_id', $property->id)
            ->where('buyer_id', auth()->id())
            ->where('request_status', '!=', 'rejected')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You already have a pending request for this property.');
        }

        $property->visitRequests()->create([
            'buyer_id' => auth()->id(),
            'visit_date' => $request->visit_date,
            'visit_time' => $request->visit_time,
            'message' => $request->message,
            'request_status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Visit request submitted successfully.');
    }

    /**
     * View all visit requests for seller's properties
     */
    public function sellerIndex(): View
    {
        $visitRequests = VisitRequest::whereHas('property', function ($query) {
            $query->where('seller_id', auth()->id());
        })->with('property', 'buyer')->paginate(10);

        return view('visit-requests.seller-index', compact('visitRequests'));
    }

    /**
     * View all visit requests for admin
     */
    public function adminIndex(): View
    {
        $visitRequests = VisitRequest::with('property', 'buyer')->paginate(10);
        return view('visit-requests.admin-index', compact('visitRequests'));
    }

    /**
     * View buyer's visit requests
     */
    public function buyerIndex(): View
    {
        $visitRequests = auth()->user()->visitRequests()->with('property')->paginate(10);
        return view('visit-requests.buyer-index', compact('visitRequests'));
    }

    /**
     * Approve a visit request
     */
    public function approve(VisitRequest $visitRequest): RedirectResponse
    {
        if (auth()->id() !== $visitRequest->property->seller_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $visitRequest->update(['request_status' => 'approved']);
        return redirect()->back()->with('success', 'Visit request approved.');
    }

    /**
     * Reject a visit request
     */
    public function reject(VisitRequest $visitRequest): RedirectResponse
    {
        if (auth()->id() !== $visitRequest->property->seller_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $visitRequest->update(['request_status' => 'rejected']);
        return redirect()->back()->with('success', 'Visit request rejected.');
    }

    /**
     * Mark visit as completed
     */
    public function complete(VisitRequest $visitRequest): RedirectResponse
    {
        if (auth()->id() !== $visitRequest->property->seller_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $visitRequest->update(['request_status' => 'completed']);
        return redirect()->back()->with('success', 'Visit marked as completed.');
    }
}
