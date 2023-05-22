<?php

use App\Models\Campaign;
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

// Route::get('/campaigns', function () {
//     $campaigns = Campaign::with('items', 'users')->get();
//     return response()->json($campaigns);
// });

Route::get('/campaigns', function () {
    //  This will display the list of campaigns for admin roles.
    $campaigns = Campaign::with('items', 'users')->latest('id')->paginate(8);

    // Anyone who's not admin, will see filtered results. 
    $active_campaigns = Campaign::with('items', 'users')->whereDate('dispatch_date', '>', Carbon::today()->toDateString())->paginate(8);

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
                    $query->whereDate('dispatch_date', '>', Carbon::today()->toDateString());
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
    return response()->json($campaigns);
});

Route::get('/current-user', function () {
    $user = Auth::user();
    return response()->json($user);
});