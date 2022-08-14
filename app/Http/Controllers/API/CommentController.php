<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{
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

        $this->validate($request, [
            'comment' => 'required',
            'user_id' => 'required|integer',
            'mission_id' => 'required|integer'
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => $request->user_id,
            'mission_id' => $request->mission_id
        ]);

        return response()->json(['message' => 'ok', 'data' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        if (Auth::user()->employed == 0) {
            return abort(404);
        }

        $this->validate($request, [
            'comment' => 'required'
        ]);

        // On modifie les informations de l'utilisateur
        $comment->update([
            "comment" => $request->comment
        ]);

        // On retourne la réponse JSON
        return response()->json(['message' => 'ok', 'data' => $comment]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if (Auth::user()->employed == 0) {
            return abort(404);
        }

        $comment->delete();
        return response()->json(['message' => 'ok', 'data' => 'destroy']);
    }
}
