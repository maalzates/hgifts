<?php

use App\Models\Campaign;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// --- GET CURRENT USER INFO
Route::get('/current-user', function () {
    $user = Auth::user();
    return response()->json($user);
});


// CAMPAIGNS ----------------
// GET CAMPAIGNS
Route::get('/campaigns', function () {
    //  This will display the list of campaigns for admin roles.
    $campaigns = Campaign::with('items', 'users')->latest('id')->paginate(8);

    // Anyone who's not admin, will see filtered results. 
    $active_campaigns = Campaign::with('items', 'users')->whereDate('delivery_date', '>', Carbon::today()->toDateString())->paginate(8);

    $subscribed_campaigns = Campaign::with('items', 'users')->whereHas('users', function($users) {
        $users->where(function($query) {
            $query->whereName(Auth::user()->name);
            });
        })->paginate(8);

        
    $active_or_subscribed_campaigns =  Campaign::with('items', 'users')->whereHas('users', function($users) {
            $users->where(function($query) {
                $query->whereName(Auth::user()->name);
                })
                ->orWhere(function($query) {
                    $query->whereDate('delivery_date', '>', Carbon::today()->toDateString());
                 });
           })->paginate(8);
        
    $is_admin = Gate::allows('admin');
    return response()->json([
        'campaigns' => $campaigns, 
        'active_campaigns' => $active_campaigns, 
        'subscribed_campaigns' => $subscribed_campaigns, 
        'active_or_subscribed_campaigns' => $active_or_subscribed_campaigns,
        'is_admin' => $is_admin
    ]);
});
// EDIT CAMPAIGN
Route::put('campaigns/{campaign}', function(Request $request, Campaign $campaign) {
    // UPDATING USERS ATTACHED TO THIS CAMPAIGN
    $campaign = Campaign::find($request->id);
    $users = $request->users;
    $campaign->users()->sync($users);
    //-----------------

});
// STORE  CAMPAIGN
Route::post('/campaigns', function (Request $request){

    // dd($request->json());

    $campaign = Campaign::create($request->input());
    $items = collect($request->items);
    $users = collect($request->users);

    $campaign->users()->attach($users);


    foreach ($items as $key => $item) {
        $campaign->items()->attach($item['id'], ['count' => $item['count']]);
    };

    return $campaign;

    // return $request->json();
});
// UPDATE
Route::put('/campaigns/{campaign}', function(Request $request, Campaign $campaign) { 

    $data = $request->input();
    $campaign = Campaign::find($request->id);

    // $campaign = Campaign::find($request->id);
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

    return $campaign;
});
// DELETE CAMPAIGN
Route::delete('/campaigns/{campaign}', function(Campaign $campaign) {

    $campaign->delete();
});

// ITEMS ----------------------------------------------------------

// GET  ITEMS
Route::get('/items', function() {
    $items = Item::latest('id')->paginate(8);
    $is_admin = Gate::allows('admin');

    return response()->json([
        'items' => $items,
        'is_admin' => $is_admin
    ]);
});
// STORE ITEM
Route::post('/items', function(Request $request) {
    $data = $request->json()->all();
    Item::create($data);

    return redirect()->route('items.index');
});
// UPDATE ITEM: 
Route::put('items/{item}', function(Request $request, Item $item){
    $data = $request->json()->all();

    $item->update($data);
});
// DELETE ITEM
Route::delete('items/{item}', function( Item $item){
    $item->delete();
    // return redirect()->route('items.index');
    // return redirect()->route('items.index');
});

// USERS -----------------

// GET USERS
Route::get('/users', function(){
    // Getting users results excluding admin
    $users = User::where('name', '!=' , 'Manuel Alzate')->paginate(8);
    return response()->json([
        'users' => $users
    ]);
});

// UPDATE USER roles
Route::put('/users/{user}', function(Request $request, User $user){
    // return $request->roles;
    $user->roles()->sync($request->roles);

    return $user;
});