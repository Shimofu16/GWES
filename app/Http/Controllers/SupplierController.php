<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubscriberCompany;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($query, $id)
    {
        $suppliers = SubscriberCompany::query();
        if ($query === 'category') {
            $suppliers->whereJsonContains('categories', ['id' => $id]);
        }

        if ($query === 'supplier') {
            $suppliers->find($id);
        }

        return view('frontend.pages.suppliers.index', compact('suppliers'));
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
    public function show($id)
    {

        return view('frontend.pages.suppliers.show', compact('suppliers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $category_id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $category_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $category_id)
    {
        //
    }
}
