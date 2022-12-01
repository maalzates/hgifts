<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Item;
use Inertia\Inertia;



class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::with('items', 'users')->paginate();
        return Inertia::render('Campaign/Index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::all();
        return Inertia::render('Campaign/Create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCampaignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $campaign = Campaign::create($request->all());
        $items = collect($request->items);

        foreach ($items as $key => $item) {
            $campaign->items()->attach($item['id'], ['count' => $item['count']]);
        };

        return $campaign;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {

        $items =  Item::all();
        $items_pivot = $campaign->items->pluck('pivot');

        return Inertia::render('Campaign/Edit', compact('campaign', 'items', 'items_pivot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCampaignRequest  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {   
        $data = $request->validate([
            'name' => 'required',
            'status' => 'required',
            'dispatch_date' => 'required',
            'delivery_date' => 'required'
        ]);
        $campaign = Campaign::find($request->id);
        $campaign->update($data);

        $items = $request->items;
        $payload = [];
        
        // UPDATING PIVOT TABLE WITH EXTRA FIELD
        // Formatting the data as we need in the sync function, array with item_id as key, and value as another array with key 'field_name' => field_value
        // $payload = [
        //              1 => ['count' => 10],
        //              5 => ['count' => 3],
        //              8 => ['count' => 7],
        // ];
        foreach ($items as $key => $item) {
            $payload[$item['item_id']] = ['count' => $item['count']];
        };
        $campaign->items()->sync($payload);


        return redirect()->route('campaigns.edit', $campaign);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
