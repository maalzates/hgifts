<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Items/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_admin = Gate::allows('admin');

        return Inertia::render('Items/Create', compact('is_admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Illuminate\Http\Request;  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->json([
        //     'name' => 'required',
        //     'unit_price' => 'required',
        //     'units_owned' => 'required'
        // ]);

        $data = $request->json()->all();
        Item::create($data);

        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $is_admin = Gate::allows('admin');
        return Inertia::render('Items/Edit', compact('item','is_admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        // $data = $request->validate([
        //     'name' => 'required',
        //     'unit_price' => 'required',
        //     'units_owned' => 'required'
        // ]);
        
        $data = $request->json()->all();

        $item->update($data);

        return redirect()->route('items.index', $item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        // return redirect()->route('items.index');
        return redirect()->route('items.index');
    }
}
