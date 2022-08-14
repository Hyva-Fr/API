<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agency;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->employed == 0) {
            return abort(404);
        }

        // On récupère tous les utilisateurs

        $agency = Agency::where(['id'=> Auth::user()->agency_id])->first();
        $users = User::where(['agency_id' => $agency->id, 'employed' => 1])->paginate(10);

        // On retourne les informations des utilisateurs en JSON
        return UserResource::collection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return UserResource
     */
    public function show(User $user)
    {
        if (Auth::user()->employed == 0) {
            return abort(404);
        }
        
        // On retourne les informations de l'utilisateur en JSON
        $agency = Agency::select(
            'agencies.name',
            'agencies.street',
            'agencies.zip',
            'agencies.city',
            'states.name as state',
            'states.code as state_code',
            'countries.name as country',
            'zones.name as zone',
        )
            ->where('agencies.id', Auth::user()->agency_id)
            ->join('states', 'agencies.state_id', '=', 'states.id')
            ->join('countries', 'states.country_id', '=', 'countries.id')
            ->join('zones', 'countries.zone_id', '=', 'zones.id')
            ->first();

        return response()->json([
            'message' => 'ok',
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'agency' => $agency
        ]);
    }
}
