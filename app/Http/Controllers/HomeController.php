<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\SubscriberCompany;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = SubscriberCompany::query()
            ->with('payments','subscriber')
            ->whereHas('payments', function ($query) {
                $query->where('latest', true)
                    ->where('isPremium', true)
                    ->where('status',  PaymentStatusEnum::ACTIVE->value);
            })
            ->pluck('logo', 'id');
        $announcement = Announcement::where('is_visible', true)->first();
        return view('frontend.pages.home.index', compact('suppliers','announcement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
