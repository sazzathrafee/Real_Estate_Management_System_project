<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\VisitRequest;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Admin dashboard
     */
    public function adminDashboard(): View
    {
        $totalUsers = User::count();
        $totalSellers = User::where('role', 'seller')->count();
        $totalBuyers = User::where('role', 'buyer')->count();
        $totalProperties = Property::count();
        $approvedProperties = Property::where('approval_status', 'approved')->count();
        $pendingProperties = Property::where('approval_status', 'pending')->count();
        $totalVisitRequests = VisitRequest::count();

        $recentProperties = Property::latest()->take(5)->with('seller', 'category')->get();
        $pendingApprovals = Property::where('approval_status', 'pending')->with('seller', 'category')->paginate(5);

        return view('dashboard.admin', compact(
            'totalUsers',
            'totalSellers',
            'totalBuyers',
            'totalProperties',
            'approvedProperties',
            'pendingProperties',
            'totalVisitRequests',
            'recentProperties',
            'pendingApprovals'
        ));
    }

    /**
     * Seller dashboard
     */
    public function sellerDashboard(): View
    {
        $totalProperties = auth()->user()->properties()->count();
        $approvedProperties = auth()->user()->properties()->where('approval_status', 'approved')->count();
        $pendingProperties = auth()->user()->properties()->where('approval_status', 'pending')->count();
        $totalVisitRequests = VisitRequest::whereHas('property', function ($query) {
            $query->where('seller_id', auth()->id());
        })->count();
        $approvedVisitRequests = VisitRequest::whereHas('property', function ($query) {
            $query->where('seller_id', auth()->id());
        })->where('request_status', 'approved')->count();

        $properties = auth()->user()->properties()->with('category')->latest()->take(5)->get();

        return view('dashboard.seller', compact(
            'totalProperties',
            'approvedProperties',
            'pendingProperties',
            'totalVisitRequests',
            'approvedVisitRequests',
            'properties'
        ));
    }

    /**
     * Buyer dashboard
     */
    public function buyerDashboard(): View
    {
        $totalFavorites = auth()->user()->favorites()->count();
        $totalVisitRequests = auth()->user()->visitRequests()->count();
        $approvedVisitRequests = auth()->user()->visitRequests()->where('request_status', 'approved')->count();

        $favorites = auth()->user()->favorites()->with('property.seller', 'property.category')->latest()->paginate(6);

        return view('dashboard.buyer', compact(
            'totalFavorites',
            'totalVisitRequests',
            'approvedVisitRequests',
            'favorites'
        ));
    }
}
