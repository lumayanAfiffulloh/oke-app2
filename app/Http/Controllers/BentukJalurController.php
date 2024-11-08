<?php

namespace App\Http\Controllers;

use App\Models\BentukJalur;
use App\Http\Requests\StoreBentukJalurRequest;
use App\Http\Requests\UpdateBentukJalurRequest;

class BentukJalurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = BentukJalur::query();
        $bentuk_jalur['bentuk_jalur'] = $query->latest()->paginate(10);
        return view ('bentuk_jalur_index', $bentuk_jalur);
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
    public function store(StoreBentukJalurRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BentukJalur $bentukJalur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BentukJalur $bentukJalur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBentukJalurRequest $request, BentukJalur $bentukJalur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BentukJalur $bentukJalur)
    {
        //
    }
}
