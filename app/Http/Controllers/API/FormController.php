<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

class FormController extends Controller
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

        $categories = Category::get()->toArray();
        $all = [];
        foreach ($categories as $category) {
            $category['forms'] = Form::where('category_id', $category['id'])->get()->toArray();
            $all[] = $category;
        }

        return response()->json(['message' => 'ok', 'data' => $all]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        if (Auth::user()->employed == 0) {
            return abort(404);
        }
        $form['category'] = Category::where('id', $form->id)->first();
        return response()->json(['massage' => 'ok', 'data' => $form]);
    }
}
