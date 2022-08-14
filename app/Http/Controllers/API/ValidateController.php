<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Validate;
use Illuminate\Http\Request;
use Auth;

class ValidateController extends Controller
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

        $validates = Validate::where(['user_id' => Auth::user()->id, 'agency_id' => Auth::user()->agency_id])->orderBy('id', 'desc')->paginate(10);
        return response()->json([
            'message' => 'ok',
            'data' => $validates
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->employed == 0) {
            return abort(404);
        }

        // La validation de données
        $this->validate($request, [
            'agency_id' => 'required|integer',
            'user_id' => 'required|integer',
            'form_id' => 'required|integer',
            'form' => 'required',
            'mission_id' => 'required|integer',
            'mission' => 'required',
            'content' => 'required',
        ]);

        // On crée un nouvel utilisateur
        $validate = Validate::create([
            'agency_id' => $request->agency_id,
            'user_id' => $request->user_id,
            'form_id' => $request->form_id,
            'form' => $request->form,
            'mission_id' => $request->mission_id,
            'mission' => $request->mission,
            'content' => $request->content
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json($validate, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Validate  $validate
     * @return \Illuminate\Http\Response
     */
    public function show(Validate $validate)
    {
        if (Auth::user()->employed == 0) {
            return abort(404);
        }

        return response()->json([
            'message' => 'ok',
            'data' => $validate
        ]);
    }

    /**
     * Update an existing resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Validate $validate)
    {
        if (Auth::user()->employed == 0) {
            return abort(404);
        }

        // La validation de données
        $this->validate($request, [
            'seen' => 'required|boolean',
        ]);

        // On modifie les informations de l'utilisateur
        $done = $validate->update([
            "seen" => $request->seen
        ]);

        return response()->json(['message' => 'ok', 'data' => $done]);
    }
}
