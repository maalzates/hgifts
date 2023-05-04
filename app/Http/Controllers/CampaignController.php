<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        // $current_user = Auth::user();

        // //  This will display the list of campaigns for admin roles.
        // $all_campaigns = Campaign::with('items', 'users')->latest('id')->paginate();

        // // Anyone who's not admin, will see filtered results. 
        // $active_campaigns = Campaign::with('items', 'users')->whereDate('dispatch_date', '>', Carbon::today()->toDateString())->paginate();

        // $subscribed_campaigns = Campaign::with('items', 'users')->whereHas('users', function($users) {
        //     $users->where(function($query) {
        //         $query->whereName(Auth::user()->name);
        //         });
        //    })->paginate();

           
        // $active_or_suscribed =  Campaign::with('items', 'users')->whereHas('users', function($users) {
        //     $users->where(function($query) {
        //         $query->whereName(Auth::user()->name);
        //         })
        //         ->orWhere(function($query) {
        //             $query->whereDate('dispatch_date', '>', Carbon::today()->toDateString());
        //          });
        //    })->paginate();
           
        // $is_admin = Gate::allows('admin');

        // return Inertia::render('Campaign/Index', compact('all_campaigns', 'current_user', 'active_campaigns', 'subscribed_campaigns', 'active_or_suscribed', 'is_admin'));
        // return $all_campaigns;
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
    public function store(Request $request)
    {   

        $campaign = Campaign::create($request->json());
        $items = collect($request->items);
        $users = collect($request->users);

        $campaign->users()->attach($users);


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
        $current_user = Auth::user();
        $users = $campaign->users()->get();
        $comments = $campaign->comments()->get();

        // Adding user property to each comment. This will help us in the view to render the propper information.

        // By default, eloquent's belongsTo relation, search for the foreign key, using the name given to the relation
        // plus "_id". This means, for this to work, the relationship in model Comment, needs to be called user(), insted users()
        foreach ($comments as $comment) {
             $comment["user"] = $comment->user;
        }

        // Getting list of scores for this campaign.   
        $scores = $campaign->users->pluck('pivot.score');
        $filtered_scores = $scores->reject(function ($score) {
            return $score=== '0';
        });

        // getting the average punctuation for this course. First we convert the array of strings in numbers, then we get the average using the avg() Laravel collections method
        $average = $filtered_scores->map( function($score) {
            return (int)$score; // First we convert each number string to integer. Then we get the average.
        })->avg();


        // ----------------------------------------------------
        $rates = $campaign->users->pluck('pivot');
        $uid = Auth::id();

        // Checking if the user has already rated. This will be true if at least one of the rate records match the uid with the current authenticated user, and is different to zero (default value).
        $has_rated = (bool) $rates->contains(function ($rate) use ($uid){ 
            return $rate['user_id'] === $uid && $rate['score'] !== '0';
        });
        // ---------------------------------------------------
        $is_admin = Gate::allows('admin');

        return Inertia::render('Campaign/Show', compact('campaign', 'users', 'current_user', 'comments', 'scores', 'average', 'has_rated', 'is_admin'));
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

        $data = $request->json()->all();
        $campaign = Campaign::find($request->id);

        // UPDATING RATING for this campaign
        if ($request['is_rating']) {
           
            $campaign->users()->syncWithoutDetaching([$request['user'] => ['score' => $request['score']]]);
            // return redirect()->back()->with('success', 'Model updated successfully!');
            return response()->json([
                'message' => 'Rating updated successfully'
            ]);

        } else {
            
            $campaign = Campaign::find($request->id);
            $campaign->update($data);
            
            // UPDATING PIVOT (campaign_item) TABLE WITH EXTRA FIELD
            // Formatting the data as we need in the sync function, array with item_id as key, and value as another array with key 'field_name' => field_value
            // $payload = [
            //              1 => ['count' => 10],
            //              5 => ['count' => 3],
            //              8 => ['count' => 7],
            // ];
    
            $items = $request->items;
            $payload = [];
            
            foreach ($items as $item) {
                $payload[$item['item_id']] = ['count' => $item['count']];
            };
            $campaign->items()->sync($payload);
            //------------------------------
    
            // UPDATING USERS ATTACHED TO THIS CAMPAIGN
            $users = $request->users;
            $campaign->users()->sync($users);
            //-----------------
    
    
            return redirect()->route('campaigns.index');
            // return redirect()->back()->with('success', 'Updated successfully');
        }
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
