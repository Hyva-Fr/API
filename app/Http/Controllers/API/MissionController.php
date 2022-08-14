<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\Agency;
use App\Models\Society;
use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;

class MissionController extends Controller
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

        $missions = Mission::where('agency_id', Auth::user()->agency_id)->get()->toArray();
        $all = [];
        foreach ($missions as $mission) {
            $mission['agency'] = Agency::select(
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

            $mission['society'] = Society::where('id', $mission['society_id'])->first();
            $mission['comments'] = Comment::select('comments.id', 'users.id as user_id', 'users.name as user', 'comments.comment', 'comments.created_at')
                ->where(['comments.mission_id' => $mission['id']])
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->get();
            $all[] = $mission;
        }

        return response()->json(['message' => 'ok', 'data' => $all]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function show(Mission $mission)
    {
        if (Auth::user()->employed == 0) {
            return abort(404);
        }

        $mission['agency'] = Agency::select(
            'agencies.name',
            'agencies.street',
            'agencies.zip',
            'agencies.city',
            'states.name as state',
            'states.code as state_code',
            'countries.name as country',
            'zones.name as zone',
        )
            ->where('agencies.id', $mission->agency_id)
            ->join('states', 'agencies.state_id', '=', 'states.id')
            ->join('countries', 'states.country_id', '=', 'countries.id')
            ->join('zones', 'countries.zone_id', '=', 'zones.id')
            ->first();

        $mission['society'] = Society::where('id', $mission['society_id'])->first();
        $mission['comments'] = Comment::select('comments.id', 'users.id as user_id', 'users.name as user', 'comments.comment', 'comments.created_at')
            ->where(['comments.mission_id' => $mission['id']])
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->get();
        return response()->json(['message' => 'ok', 'data' => $mission]);
    }
}
