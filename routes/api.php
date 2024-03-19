<?php

use App\Models\Campaign;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
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

// GET CAMPAIGNS SHOW INFO
Route::get('/campaigns/{campaign}/show', function(Campaign $campaign){

    $current_user = Auth::user();
    $users = $campaign->users()->get();
    $comments = $campaign->comments()->latest('id')->get();

    // Adding user property to each comment. This will help us in the view to render the propper information.

    // By default, eloquent's belongsTo relation, search for the foreign key, using the name given to the relation
    // plus "_id". This means, for this to work, the relationship in model Comment, needs to be called user(), insted users()
    foreach ($comments as $comment) {
         $comment["user"] = $comment->user;
    };

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

    return response()->json([
        'current_user' => $current_user,
        'users' => $users,
        'comments' => $comments,
        'scores' => $scores,
        'average' => $average,
        'has_rated' => $has_rated,
        'is_admin' => $is_admin
    ]);

});

// STORE  CAMPAIGN
Route::post('/campaigns', function (Request $request){

    // Validate the request data
    $validatedData = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'status' => 'required|in:preparing,ready,dispatched',
        'dispatch_date' => 'required|date',
        'delivery_date' => 'required|date|after_or_equal:dispatch_date',
        'items' => 'required|array',
        'items.*.id' => 'required|exists:items,id',
        'items.*.count' => 'required|integer|min:1',
        'users.*' => 'exists:users,id',
    ])->validate();

    // Directly use the validated data to create the campaign
    // Additional fields outside of $fillable are ignored
    $campaign = Campaign::create($validatedData);

    // Process and attach items and users separately
    foreach ($validatedData['items'] as $item) {
        $campaign->items()->attach($item['id'], ['count' => $item['count']]);
    }

    if (!empty($validatedData['users'])) {
        $campaign->users()->attach($validatedData['users']);
    }

    return response()->json($campaign);

});

// UPDATE CAMPAIGN
Route::put('/campaigns/{campaign}', function(Request $request, Campaign $campaign) { 

     // Validate the request data and update the campaign in a single step
     $validatedData = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'status' => 'required|in:preparing,ready,dispatched',
        'dispatch_date' => 'required|date',
        'delivery_date' => 'required|date|after_or_equal:dispatch_date',
        'items' => 'required|array',
        'items.*.item_id' => 'required|exists:items,id',
        'items.*.count' => 'required|integer|min:1',
        'users' => 'array',
        'users.*' => 'exists:users,id',
    ])->validate();

    // Update campaign with validated data
    $campaign->update([
        'name' => $validatedData['name'],
        'status' => $validatedData['status'],
        'dispatch_date' => $validatedData['dispatch_date'],
        'delivery_date' => $validatedData['delivery_date'],
    ]);

    // Process and attach items with additional attributes
    if (!empty($validatedData['items'])) {
        // UPDATING PIVOT (campaign_item) TABLE WITH EXTRA FIELD
        // Formatting the data as we need in the sync function, array with item_id as key, and value as another array with key 'field_name' => field_value
        // $payload = [
        //              1 => ['count' => 10],
        //              5 => ['count' => 3],
        //              8 => ['count' => 7],
        // ];
        $payload = [];
        foreach ($validatedData['items'] as $item) {
            $payload[$item['item_id']] = ['count' => $item['count']];
        }
        $campaign->items()->sync($payload); // Use sync to update existing relations
    }

    // Sync users if provided
    if (!empty($validatedData['users'])) {
        $campaign->users()->sync($validatedData['users']);
    }

    return response()->json($campaign);

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
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'unit_price' => 'required|numeric|min:0',
        'units_owned' => 'required|integer|min:0',
    ]);

    // Create the item with the validated data
    $item = Item::create($validatedData);
    
    return response()->json($item);
});


// UPDATE ITEM: 
Route::put('items/{item}', function(Request $request, Item $item){

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'unit_price' => 'required|numeric|min:0',
        'units_owned' => 'required|integer|min:0',
    ]);

    $item->update($validatedData);
    return response()->json($item);
});
// DELETE ITEM
Route::delete('items/{item}', function( Item $item){
    $item->delete();
});

// USERS -----------------

// GET USERS
Route::get('/users', function(){
    $users = User::where('name', '!=' , 'Manuel Alzate')->paginate(8);
    $is_admin = Gate::allows('admin');
    return response()->json([
        'users' => $users,
        'is_admin' => $is_admin
    ]);
});

// UPDATE USER ROLES
Route::put('/users/{user}', function(Request $request, User $user){
    $user->roles()->sync($request->roles);

    return $user;
});


// COMMENTS -------------

// STORE COMMENT
Route::post('/comments', function(Request $request){
    $validatedData = $request->validate([
        'campaign_id' => 'required|exists:campaigns,id',
        'content' => 'required|string|max:255',
        'user_id' => 'required|exists:users,id',
    ]);

    // Create the comment with the validated data
    $new_comment = Comment::create($validatedData);

    // Return the newly created comment as JSON
    return response()->json($new_comment);
});