<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        return Inertia::render('Campaign/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::all();
        $users = User::all();
        $is_admin = Gate::allows('admin');

        return Inertia::render('Campaign/Create', compact('items', 'users', 'is_admin'));
    }  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCampaignRequest  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)

    {
        $this->authorize('view', $campaign);

        return Inertia::render('Campaign/Show', compact('campaign'));
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
        $users = User::all();

        $items_pivot = $campaign->items->pluck('pivot');
        $users_subscribed = $campaign->users;

        $is_admin = Gate::allows('admin');

        return Inertia::render('Campaign/Edit', compact('campaign', 'items', 'items_pivot', 'users', 'users_subscribed', 'is_admin'));
        // return Inertia::render('Campaign/Edit');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        // return redirect()->route('items.index');
        return redirect()->route('campaigns.index');
    }
}
