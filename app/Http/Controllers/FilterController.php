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

    public function search(Request $request){
        $search = $request->input('q');
        $query = Posts::query();


        $words = explode(" ",$search);
        foreach ($words as $word){
            $query->orWhere('title', 'LIKE', "%$word%");
        }

        $posts = $query->where('active', 1)
            ->with('categories')
            ->with('mcu')
            ->with('comments')
            ->with('tagged')
            ->with('mcu')
            ->paginate(5);


        $inputs = array(
            'vendor' => $request->input('vendor'),
            'sort' => $request->input('sort'),
            'filter' => $request->input('filter'),
        );

        return view('search')
            ->withPosts($posts)
            ->withInputs($inputs)
            ->withSearch($search)
            ->withMeta('Latest posts containing the words: ' . $search)
            ;

    }

    public function tag(Request $request, $tagInput){
        $query = Posts::query();

        // Get tag that matches filter
        $tagRoot = DB::table('tagging_tags')->where('slug', $tagInput)->first();

        $filterCompiler = $request->input('compiler');
        if(($filterCompiler!='all' && isset($filterCompiler))) {
            $filterCompiler = McuCompilers::where('name', $filterCompiler)->first();
            $compFilter = array('id' => $filterCompiler->id);
        }
        else
            $compFilter = array(); // don't filter on vendor here since each compiler can belong to multple vendors

        $filterMcu = $request->input('mcu');
        if(($filterMcu!='all' && isset($filterMcu))) {
            $filterMcu = Mcus::where('name', $filterMcu)->first();
            $mcuFilter = array('id' => $filterMcu->id);
        }
        else
            $mcuFilter = array(); // THE MICRO is the only thing that should be filtering on vendor


        $inLanguage = $request->input('language');
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

        $existingTags = Posts::existingTags()->toArray();
        $tags = array();
        foreach($existingTags as $tag){
            $tags[] = $tag['slug'];
        }


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

            ->withAnyTag($tagInput) // passed into function


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
        arsort($tagsVals); arsort($categoriesVals);arsort($languageVals);arsort($mcusVals);arsort($vals);

        // Get the slug of each. This is EXTREMELY inefficient, but it works for now
        $categoryZ = array(); $languageZ = array(); $mcuZ = array(); $compilersZ = array();
        foreach($categoriesVals as $name=>$count){
            $temp = Categories::get()->where('name', $name)->first();
            $categoryZ[$name]['count'] = $count;
            $categoryZ[$name]['name'] = $name;
            $categoryZ[$name]['slug'] = $temp->slug;
        }
        foreach($languageVals as $name=>$count){
            $temp = McuLanguages::get()->where('name', $name)->first();
            $languageZ[$name]['count'] = $count;
            $languageZ[$name]['name'] = $name;
            $languageZ[$name]['slug'] = $temp->slug;
        }
        foreach($mcusVals as $name=>$count){
            $temp = Mcus::get()->where('name', $name)->first();
            $mcuZ[$name]['count'] = $count;
            $mcuZ[$name]['name'] = $name;
            $mcuZ[$name]['slug'] = $temp->slug;
        }
        foreach($vals as $name=>$count){
            $temp = McuCompilers::get()->where('name', $name)->first();
            $compilersZ[$name]['count'] = $count;
            $compilersZ[$name]['name'] = $name;
            $compilersZ[$name]['slug'] = $temp->slug;
        }



        $page = $request->input('page');
        if($page == '') $page = 1;
        $perPage =10;
        $paginate = new LengthAwarePaginator($posts, $posts->count(), $perPage, $page, array('path' => '/tags/'.$tagRoot->slug)); // create pagination

        parse_str($_SERVER['QUERY_STRING'],$url_array);
        $paginate->appends($url_array);

        $posts = $posts->splice(($perPage * $page) - $perPage, $perPage);

        $inputs = array(
            'compiler' => $request->input('compiler'),
            'language' => $request->input('language'),
            'mcu' => $request->input('mcu'),
            'category' => $request->input('category'),
            'tag' => $request->input('tag'),
        );


        return view('filter')
            ->withInputs($inputs)
            ->withPosts($posts)
            ->withPagination($paginate)
            //->withVendor($vendor)

            ->withUrl(url('/tags/'.$tagRoot->slug))
            ->withBreadcrumb('Tag - ' .$tagRoot->name)
            ->withTitle("Project and tutorials tagged as $tagRoot->name")
            ->withDescription('')
            ->withMeta('Most recent projects and tutorials tagged with ' . $tagRoot->name)
            ->withTopic('Tags')

            ->withCategories($categoryZ)
            ->withMcus($mcuZ)
            ->withCompilers($compilersZ)
            ->withLanguages($languageZ)

//            ->withLanguages($languages)
            ->withTags($tagsVals)
            ;


    }

    public function category(Request $request, $category){
        // Get the categoryID
        $category = Categories::where('slug', $category)->first();
        $categoryID = $category->id;


        $query = Posts::query();

        $filterCompiler = $request->input('compiler');
        if(($filterCompiler!='all' && isset($filterCompiler))) {
            $filterCompiler = McuCompilers::where('name', $filterCompiler)->first();
            $compFilter = array('id' => $filterCompiler->id);
        }
        else
            $compFilter = array(); // don't filter on vendor here since each compiler can belong to multple vendors

        $filterMcu = $request->input('mcu');
        if(($filterMcu!='all' && isset($filterMcu))) {
            $filterMcu = Mcus::where('name', $filterMcu)->first();
            $mcuFilter = array('id' => $filterMcu->id);
        }
        else
            $mcuFilter = array(); // THE MICRO is the only thing that should be filtering on vendor


        $inLanguage = $request->input('language');
        if(($inLanguage!='all' && isset($inLanguage))) {
            $lanId = McuLanguages::where('slug', $inLanguage)->first();
            $lanFilter = array('id' => $lanId->id);
        }
        else
            $lanFilter = array();

        $existingTags = Posts::existingTags()->toArray();
        $tags = array();
        foreach($existingTags as $tag){
            $tags[] = $tag['slug'];
        }

        $inTag = $request->input('tag');
        if($inTag == '')
            $query->withAnyTag($tags);
        else
            $query->withAnyTag($inTag);


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


            ->whereHas('categories', function($q) use($categoryID){
                $q->where('category_id', $categoryID);
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
        arsort($tagsVals); arsort($categoriesVals);arsort($languageVals);arsort($mcusVals);arsort($vals);

        // Get the slug of each. This is EXTREMELY inefficient, but it works for now
        $categoryZ = array(); $languageZ = array(); $mcuZ = array(); $compilersZ = array();
        foreach($categoriesVals as $name=>$count){
            $temp = Categories::get()->where('name', $name)->first();
            $categoryZ[$name]['count'] = $count;
            $categoryZ[$name]['name'] = $name;
            $categoryZ[$name]['slug'] = $temp->slug;
        }
        foreach($languageVals as $name=>$count){
            $temp = McuLanguages::get()->where('name', $name)->first();
            $languageZ[$name]['count'] = $count;
            $languageZ[$name]['name'] = $name;
            $languageZ[$name]['slug'] = $temp->slug;
        }
        foreach($mcusVals as $name=>$count){
            $temp = Mcus::get()->where('name', $name)->first();
            $mcuZ[$name]['count'] = $count;
            $mcuZ[$name]['name'] = $name;
            $mcuZ[$name]['slug'] = $temp->slug;
        }
        foreach($vals as $name=>$count){
            $temp = McuCompilers::get()->where('name', $name)->first();
            $compilersZ[$name]['count'] = $count;
            $compilersZ[$name]['name'] = $name;
            $compilersZ[$name]['slug'] = $temp->slug;
        }



        $page = $request->input('page');
        if($page == '') $page = 1;
        $perPage =10;
        $paginate = new LengthAwarePaginator($posts, $posts->count(), $perPage, $page, array('path' => '/categories/'.$category->slug)); // create pagination

        parse_str($_SERVER['QUERY_STRING'],$url_array);
        $paginate->appends($url_array);

        $posts = $posts->splice(($perPage * $page) - $perPage, $perPage);

        $inputs = array(
            'compiler' => $request->input('compiler'),
            'language' => $request->input('language'),
            'mcu' => $request->input('mcu'),
            'category' => $request->input('category'),
            'tag' => $request->input('tag'),
        );


        return view('filter')
            ->withInputs($inputs)
            ->withPosts($posts)
            ->withPagination($paginate)
            //->withVendor($vendor)

            ->withUrl(url('/categories/'.$category->slug))
            ->withTopic('Category')
            ->withBreadcrumb('Category - ' .$category->name)
            ->withTitle("$category->name projects and tutorials")
            ->withDescription($category->description)
            ->withMeta('All projects and tutorials in ' . $category->name . ' category')


            ->withCategories($categoryZ)
            ->withMcus($mcuZ)
            ->withCompilers($compilersZ)
            ->withLanguages($languageZ)

//            ->withLanguages($languages)
            ->withTags($tagsVals)

            ;


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
            if((!isset($filterMcu->id))) {
                $filterMcu = new \stdClass();
                $filterMcu->id = 99; // bogus ID
            }
            $mcuFilter = array('vendor_id' => $vendorId, 'id' => $filterMcu->id);
        }
        else
            $mcuFilter = array('vendor_id' => $vendorId); // THE MICRO is the only thing that should be filtering on vendor


        $inLanguage = $request->input('language');
        if(($inLanguage!='all' && isset($inLanguage))) {
            $lanId = McuLanguages::where('slug', $inLanguage)->first();
            $lanFilter = array('id' => $lanId->id);
        }
        else
            $lanFilter = array();

        $inCategory = $request->input('category');
        if(($inCategory!='all' && isset($inCategory))) {
            $cat = Categories::where('slug', $inCategory)->first();
            $catFilter = array('category_id' => $cat->id);
        }
        else
            $catFilter = array();


        $existingTags = Posts::existingTags()->toArray();
        $tags = array();
        foreach($existingTags as $tag){
            $tags[] = $tag['slug'];
        }

        $query = Posts::query();

        $inTag = $request->input('tag');
        if($inTag == '')
            $query->withAnyTag($tags);
        else
            $query->withAnyTag($inTag);

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

            //->withAnyTag($tags)


            ->whereHas('categories', function($q) use($catFilter){
                $q->where($catFilter);
            })
            ->whereHas('languages', function($q) use ($lanFilter){
                if(empty($lanFilter))
                    $q->where($lanFilter)->orWhere('language_id', 99); //Allow languages of 'none'
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
            foreach($post->categories as $cat) {
                $categories[] = $cat->name;
            }
            foreach($post->tagged as $tag)
                $tags[] = $tag->tag_name;

        }
        // Count up the amount of entries
        $vals = array_count_values($compilers);
        $mcusVals = array_count_values($mcus);
        $languageVals = array_count_values($languages);
        $categoriesVals = array_count_values($categories);
        $tagsVals = array_count_values($tags);
        arsort($tagsVals); arsort($categoriesVals);arsort($languageVals);arsort($mcusVals);arsort($vals);

        // Get the slug of each. This is EXTREMELY inefficient, but it works for now
        $categoryZ = array(); $languageZ = array(); $mcuZ = array(); $compilersZ = array();
        foreach($categoriesVals as $name=>$count){
            $temp = Categories::get()->where('name', $name)->first();
            $categoryZ[$name]['count'] = $count;
            $categoryZ[$name]['name'] = $name;
            $categoryZ[$name]['slug'] = $temp->slug;
        }
        foreach($languageVals as $name=>$count){
            $temp = McuLanguages::get()->where('name', $name)->first();
            $languageZ[$name]['count'] = $count;
            $languageZ[$name]['name'] = $name;
            $languageZ[$name]['slug'] = $temp->slug;
        }
        foreach($mcusVals as $name=>$count){
            $temp = Mcus::get()->where('name', $name)->first();
            $mcuZ[$name]['count'] = $count;
            $mcuZ[$name]['name'] = $name;
            $mcuZ[$name]['slug'] = $temp->slug;
        }
        foreach($vals as $name=>$count){
            $temp = McuCompilers::get()->where('name', $name)->first();
            $compilersZ[$name]['count'] = $count;
            $compilersZ[$name]['name'] = $name;
            $compilersZ[$name]['slug'] = $temp->slug;
        }


        $page = $request->input('page');
        if($page == '') $page = 1;
        $perPage = 10;
        $paginate = new LengthAwarePaginator($posts, $posts->count(), $perPage, $page, array('path' => '/vendors/'.$vendor->slug)); // create pagination

        parse_str($_SERVER['QUERY_STRING'],$url_array);
        $paginate->appends($url_array);

        $posts = $posts->splice(($perPage * $page) - $perPage, $perPage);

        $inputs = array(
            'compiler' => $request->input('compiler'),
            'language' => $request->input('language'),
            'mcu' => $request->input('mcu'),
            'category' => $request->input('category'),
            'tag' => $request->input('tag'),
        );


        return view('filter')
            ->withInputs($inputs)
            ->withPosts($posts)
            ->withPagination($paginate)
            ->withVendor($vendor)

            ->withUrl(url('/vendors/'.$vendor->slug))
            ->withBreadcrumb('Vendor - ' .$vendor->name)
            ->withTopic('Vendors')
            ->withTitle("$vendor->name projects and tutorials")
            ->withDescription($vendor->description)
            ->withMeta('All projects and tutorials related to ' . $vendor->name)


            ->withCategories($categoryZ)
            ->withMcus($mcuZ)
            ->withCompilers($compilersZ)
            ->withLanguages($languageZ)

//            ->withLanguages($languages)
            ->withTags($tagsVals)
            ;
    }
}