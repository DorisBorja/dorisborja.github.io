<?php

namespace App\Http\Controllers;

use App\Models\LivestockMedicine;
use Illuminate\Http\Request;

class LivestockMedicineController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function showView()
    {

        return view('pages.users.index');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LivestockMedicine  $livestockMedicine
     * @return \Illuminate\Http\Response
     */
    public function show(LivestockMedicine $livestockMedicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LivestockMedicine  $livestockMedicine
     * @return \Illuminate\Http\Response
     */
    public function edit(LivestockMedicine $livestockMedicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LivestockMedicine  $livestockMedicine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LivestockMedicine $livestockMedicine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LivestockMedicine  $livestockMedicine
     * @return \Illuminate\Http\Response
     */
    public function destroy(LivestockMedicine $livestockMedicine)
    {
        //
    }
}
