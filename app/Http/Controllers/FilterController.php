<?php

namespace App\Http\Controllers;


use App\Models\Categories;
use App\Models\McuCompilers;
use App\Models\McuLanguages;
use App\Models\Mcus;
use Input;
use Validator;
use Session;
use App\Models\Posts;
use App\Models\User;
use Redirect;
use App\Http\Controllers\Controller;
//use App\Http\Requests\PostFormRequest; // don't use for validation anymore
use Illuminate\Http\Request;
use GrahamCampbell\Markdown\Facades\Markdown; // use this to convert markdown to html


class FilterController extends Controller
{
    //
    public function index()
    {

    }

    public function vendor($vendor){
        //$where = ['active' => 1, '']

        $posts = Posts::where('active', 1)
            ->with('mcu')
            ->with('tagged')
            ->with('categories')
            ->with('compiler')
            ->withAnyTag(['elephant'])
            ->whereHas('categories', function($q){
                $q->where('slug', 'analog');
            })
            ->whereHas('languages', function($q){
                $q->where('slug', 'c');
            })
            ->whereHas('compiler', function($q){
                $q->where('id', 3);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
            //->get();

            //Can use either get() or paginate() NOT BOTH

           // ->where('compiler.id', 3)
           // ->where('mcu.vendor_id', 2);

       // $posts = Posts::with('categories')->get()->where('categories.slug', 'audio');

        //->orderBy('created_at', 'desc')->paginate(5)->get()

    print_r($posts); die;
        return view('filter');
    }
}