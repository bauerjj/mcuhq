<?php

namespace App\Http\Controllers;


use App\Models\Categories;
use App\Models\Posts;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        $inputs = array(
            'vendor' => $request->input('vendor'),
            'sort' => $request->input('sort'),
            'filter' => $request->input('filter'),
        );
        return view('blog.home')->withInputs($inputs);
    }

    public function create(Request $request)
    {
        // check if user can post and is admin
        if ($request->user()->can_post() && $request->user()->is_Admin()) {

            // Grab the available categories and such
            $categories = Categories::all();
            $tags = Posts::existingTags()->toArray();

            return view('blog.create')
                ->withCategories($categories)
                ->withTags(json_encode($tags));
        } else {
            return redirect('/')->withErrors('You do not have sufficient permissions to post!');
        }
    }


}