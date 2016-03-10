<?php

namespace App\Http\Controllers;


use App\Models\Categories;
use App\Models\McuCompilers;
use App\Models\McuLanguages;
use App\Models\Mcus;
use Illuminate\Pagination\Paginator;
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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FilterController extends Controller
{
    //
    public function index()
    {

    }

    public function vendor(Request $request)
    {
        $filterCompiler = $request->input('compiler');
        if(($filterCompiler!='all')) {
            $filterCompiler = McuCompilers::where('name', $filterCompiler)->first();
            $compFilter = array();
            if(isset($filterCompiler))
                $compFilter = array('vendor_id' => 1, 'id' => $filterCompiler->id);
        }
        else
            $compFilter = array('vendor_id' => 1);

        $posts = Posts::where('active', 1)
            ->with('mcu')
            ->with('tagged')
            ->with('categories')
            ->with('compiler')
            // ->withAnyTag(['elephant'])
//            ->whereHas('categories', function($q){
//                $q->where('slug', 'analog');
//            })
//            ->whereHas('languages', function($q){
//                $q->where('slug', 'c');
//            })
            ->whereHas('compiler', function ($q) use ($compFilter) {
                //$q->where('id', 2);
                $q->where($compFilter);
            })
            ->orderBy('created_at', 'desc')
        //    ->paginate(5);
        ->get();
        ;

        // Cycle through posts to get how many tags and such of each
        foreach($posts as $post){
           // $arr ['name'] = $post->compiler->name;
           // $arr ['slug'] = $post->compiler->slug;
            $compilers [] = $post->compiler->name;
        }
        $vals = array_count_values($compilers);
        //print_r($vals); die;

//        $categories = Categories::all();
//        $mcus = Mcus::orderBy('vendor_id')->where('vendor_id',1)->get();
//        $compilers = McuCompilers::orderBy('vendor_id')->where('vendor_id', 1)->get();
//        $languages = McuLanguages::orderBy('id')->get();
//        $tags = Posts::with('tagged')->first();

        //Can use either get() or paginate() NOT BOTH

        // ->where('compiler.id', 3)
        // ->where('mcu.vendor_id', 2);

        // $posts = Posts::with('categories')->get()->where('categories.slug', 'audio');

        //->orderBy('created_at', 'desc')->paginate(5)->get()
        // print_r($mcus); die;
        $page = $request->input('page');
        if($page == '') $page = 1;
        $perPage = 3;
        $paginate = new LengthAwarePaginator($posts, $posts->count(), $perPage, $page, array('path' => '/vendor/microchip')); // create pagination


        $t = Collection::make([1,2,3]);
        $posts = $posts->splice(($perPage * $page) - $perPage, $perPage);
        $t->splice(0,5);


        return view('filter')
            ->withPosts($posts)
            ->withPagination($paginate)
//            ->withCategories($categories)
//            ->withMcus($mcus)
            ->withCompilers($vals)
//            ->withLanguages($languages)
//            ->withTags($tags)
            ;
    }
}