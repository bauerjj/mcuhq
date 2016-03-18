<?php

namespace App\Http\Controllers;


use App\Models\Categories;
use App\Models\McuCompilers;
use App\Models\McuLanguages;
use App\Models\Mcus;
use App\Models\McuVendors;
use Illuminate\Pagination\Paginator;
use Input;
use Validator;
use Session;
use App\Models\Posts;
use DB;
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

    public function category(Request $request, $category){

    }

    public function vendor(Request $request, $vendor)
    {
        // Get the vendor ID
        $vendor = McuVendors::where('slug', $vendor)->first();
        $vendorId = $vendor->id;


        $filterCompiler = $request->input('compiler');
        if(($filterCompiler!='all' && isset($filterCompiler))) {
            $filterCompiler = McuCompilers::where('name', $filterCompiler)->first();
            $compFilter = array('vendor_id' => $vendorId, 'id' => $filterCompiler->id);
        }
        else
            $compFilter = array(); // don't filter on vendor here since each compiler can belong to multple vendors

        $filterMcu = $request->input('mcu');
        if(($filterMcu!='all' && isset($filterMcu))) {
            $filterMcu = Mcus::where('name', $filterMcu)->first();
            $mcuFilter = array('vendor_id' => $vendorId, 'id' => $filterMcu->id);
        }
        else
            $mcuFilter = array('vendor_id' => $vendorId); // THE MICRO is the only thing that should be filtering on vendor


        $inLanguage = $request->input('lan');
        if(($inLanguage!='all' && isset($inLanguage))) {
            $lanId = McuLanguages::where('slug', $inLanguage)->first();
            $lanFilter = array('id' => $lanId->id);
        }
        else
            $lanFilter = array();

        $inCategory = $request->input('category');
        if(($inCategory!='all' && isset($inCategory))) {
            $cat = Categories::where('slug', $inCategory)->first();
            $catFilter = array('id' => $cat->id);
        }
        else
            $catFilter = array();

        $inTag = $request->input('tag');
//        if(($inTag!='all' && isset($inTag))) {
//            $tag = Categories::where('slug', $inCategory)->first();
//            $catFilter = array('id' => $cat->id);
//        }
//        else
//            $catFilter = array();


       // ->withAnyTag(['tiger','cat','elephant'])
    //print_r(Posts::existingTags()->toArray()); die;
        $existingTags = Posts::existingTags()->toArray();
        $tags = array();
        foreach($existingTags as $tag){
            $tags[] = $tag['slug'];
        }

        $query = Posts::query();

        $query->select( ////http://stackoverflow.com/questions/24208502/laravel-orderby-relationship-count
            array(
                '*',
                DB::raw('(SELECT count(*) FROM comments WHERE on_post = posts.id) as comments_count')
            ));

        $posts = $query->where('active', 1)
            ->with('mcu')
            ->with('tagged')
            ->with('categories')
            ->with('compiler')
            ->with('languages')

            ->withAnyTag($tags)


            ->whereHas('categories', function($q) use($catFilter){
                $q->where($catFilter);
            })
            ->whereHas('languages', function($q) use ($lanFilter){
                if(empty($lanFilter))
                    $q->where($lanFilter)->orWhere('id', 99);
                else
                $q->where($lanFilter);
            })
            ->whereHas('compiler', function ($q) use ($compFilter) {
                $q->where($compFilter);
            })
            ->whereHas('mcu', function ($q) use ($mcuFilter) {
                $q->where($mcuFilter);
            })


            ->orderBy('created_at', 'desc')
        //    ->paginate(5);
        ->get();
        ;

        // Cycle through posts to get how many tags and such of each
        $compilers = array();$mcus = array();$languages = array(); $categories = array();$tags = array();

        foreach($posts as $post){
           // $arr ['name'] = $post->compiler->name;
           // $arr ['slug'] = $post->compiler->slug;
            $compilers [] = $post->compiler->name;
            $mcus[] = $post->mcu->name;
            foreach($post->languages as $lan)
                $languages[] = $lan->name;
            foreach($post->categories as $cat)
                $categories[] = $cat->name;
            foreach($post->tagged as $tag)
                $tags[] = $tag->tag_name;

        }
        $vals = array_count_values($compilers);
        $mcusVals = array_count_values($mcus);
        $languageVals = array_count_values($languages);
        $categoriesVals = array_count_values($categories);
        $tagsVals = array_count_values($tags);



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

        parse_str($_SERVER['QUERY_STRING'],$url_array);
        $paginate->appends($url_array);

        $posts = $posts->splice(($perPage * $page) - $perPage, $perPage);

        $inputs = array(
            'compiler' => $request->input('compiler'),
            'language' => $request->input('lan'),
            'mcu' => $request->input('mcu'),
            'category' => $request->input('category'),
        );


        return view('filter')
            ->withInputs($inputs)
            ->withPosts($posts)
            ->withPagination($paginate)
            ->withVendor($vendor)

            ->withCategories($categoriesVals)
            ->withMcus($mcusVals)
            ->withCompilers($vals)
            ->withLanguages($languageVals)

//            ->withLanguages($languages)
            ->withTags($tagsVals)
            ;
    }
}