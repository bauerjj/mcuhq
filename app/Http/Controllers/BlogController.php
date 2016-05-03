<?php

namespace App\Http\Controllers;


use App\Models\BlogCategories;
use App\Models\Blog;
use DOMDocument;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mews\Purifier\Facades\Purifier;

class BlogController extends Controller
{

    public function index(Request $request)
    {


        $query = Blog::query();
        //$query->with('commentsCount');

        $canonical = url('/');
        $sort = $request->input('sort');

        $categorySlug = $request->input('category');
        $category = BlogCategories::where('slug', $categorySlug)->first();

        if(isset($category)) {
            $catFilter = array('category_id' => $category->id);
            $vendorMeta = ' '. $category->name;
            $canonical = url('/'.$category->slug);
        }
        else if($categorySlug == '' || $categorySlug == 'all')
            $catFilter = array();
        else
            $catFilter = array('category_id' => 9999999); // get here when no user input matches any slug

        $sort = $request->input('sort');

        $sortMeta = "Newest";
        if($sort == 'new'){
            $query->orderBy('created_at', 'desc');
            $sortMeta = "Newest";
        }
        else if($sort == 'comments'){
            $query->orderBy('comments_count','desc');
            $sortMeta = "Active";
        }
        else if($sort == 'views'){
            $query->orderBy('view_counter','desc');
            $sortMeta = "Popular";
        }
        else{
            $query->orderBy('created_at', 'desc'); // on default, show the new posts first
        }

        $blogPosts = $query->where('active', 1)
            ->with('tagged')
            ->whereHas('categories', function ($q) use ($catFilter) {
                $q->where($catFilter);
            })
            ->paginate(15);

        $inputs = array(
            'category' => $request->input('category'),
            'sort' => $request->input('sort'),
            'filter' => $request->input('filter'),
        );
        return view('blog.home')->withInputs($inputs)->withPosts($blogPosts);
    }

    public function create(Request $request)
    {
        // check if user can post and is admin
        if ($request->user()->can_post() && $request->user()->is_Admin()) {

            // Grab the available categories and such
            $categories = BlogCategories::all();
            $tags = Blog::existingTags()->toArray();

            return view('blog.create')
                ->withCategories($categories)
                ->withTags(json_encode($tags));
        } else {
            return redirect('/')->withErrors('You do not have sufficient permissions to post!');
        }
    }

    public function store(Request $request) //PostFormRequest
    {
        // return Redirect::to('new-post')->withErrors('wooops')->withInput();

        $this->validate($request, [
            'title' => 'required|max:255', // no longer required to be unique
            'title' => array('Regex:/^[A-Za-z0-9 .\- ]+$/'),
            'description' => 'required|max:160', // 160 is what google recommends as the cap
            'body' => 'required',
            'tags' => 'required|arrayCountMax:6|arrayCountMin:1',
            'topics' => 'required|arrayCountMax:4|arrayCountMin:1',
            'file_image'=> 'max:50000|image', // don't require this
        ]);


        $main_image = $request->file('file_image');
        $time = substr(str_shuffle(MD5(microtime())), 0, 15);
        if($main_image){
            $main_image_dest =  $time . '.'.$main_image->getClientOriginalExtension();
            $request->file('file_image')->move('uploads', $main_image_dest);
        }



        $blog = new Blog();
        $blog->title = $request->get('title');
        $blog->description = $request->get('description');
        $blog->body = $request->get('body');
        $blog->body_html = Purifier::clean(Markdown::convertToHtml($request->get('body'))); // convert ONCE here
        $blog->slug = str_slug($blog->title);
        $blog->author_id = $request->user()->id;

        if($main_image)
         $blog->main_image = $main_image_dest;

        ////////// Find all images and center them and make them responsive!
        $dom = new DOMDocument;
        $dom->loadHTML($blog->body_html);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $image) {
            $image->setAttribute('class', 'img-responsive img-thumbnail center-block');
        }
        $html = $dom->saveHTML();
        $blog->body_html = $html;
        //////////

        if ($request->has('save')) {
            $blog->active = 0;
            $message = 'Post saved successfully';
        } else {
            // Only allow an admin to post content directly to website before being reviewed
            if($request->user()->role == 'admin') {
                $blog->active = 1;
                $message = 'Post published successfully';
            }
            else{
                $blog->active = 0;
                $message = 'Post published successfully - awaiting review!';
            }
        }

        if($blog->save()) {
            $cat_string = $request->get('topics');
            $cat_ids = explode(',', $cat_string);
            $blog->categories()->sync($cat_ids); // save categories
            // Must first save the ID before tagging!
            $blog->tag($request->get('tags')); // delete current tags and save new tags

        }
        return redirect('/blog/'.$blog->id.'/' . $blog->slug)->withMessage($message);
    }

    public function show(Request $request, $id, $slug)
    {

        $blog = Blog::with('tagged')->where('id',$id)->first();

        if (!$blog) {
            return redirect('/')->withErrors('requested page not found');
        }

        // Fire view counter event
        //event(new ViewPostHandler($post, $request->session()));


        // Grab other associated display things
        $categories = $blog->categories;
        // Get the related posts for each word in the title
        $query = Blog::query();
        $words = explode(" ",$blog->title);
        $queryString = '';
        $i = 0;
        foreach ($words as $word){ // Build this query so to get related posts on each word in title WITHOUT own post ID
            if($i == 0)
                $queryString.= "title LIKE '%$word%' AND id != $blog->id AND active = 1";
            else
                $queryString.= " OR title LIKE '%$word%' AND id != $blog->id AND active = 1";
            $i++;
        }

        $query->whereRaw($queryString);
        $related = $query->get();



        return view('blog.show')->withBlog($blog)->withCategories($categories)
            ->withRelated($related);
    }

    public function edit(Request $request, $id, $slug)
    {

        $blog = Blog::where('id', $id)->first();
        if ($blog && ($request->user()->id == $blog->author_id || $request->user()->is_admin())) {
            // Grab the available categories and such
            $categories = BlogCategories::all();
            $tags = Blog::existingTags()->toArray();
            //print_r($tags); die;

            // Get the existing tags for the post
            $existingTags = $blog->tagged->toArray();
            $existingTagsArray = array();
            foreach($existingTags as $tag){
                $existingTagsArray[] = $tag['tag']['slug'];
            }
            $existingCatArray = array();
            foreach($blog->categories as $cat){
                $existingCatArray[] = $cat->id;
            }

            return view('blog.edit')
                ->withBlog($blog)
                ->with('existingTags',implode(',',$existingTagsArray))
                ->with('existingCategories',implode(',',$existingCatArray))
                ->withTags(json_encode($tags))
                ->withCategories($categories);
        }
        return redirect('/')->withErrors('you have not sufficient permissions');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'title' => array('Regex:/^[A-Za-z0-9 .\- ]+$/'),
            'description' => 'required|max:160', // 160 is what google recommends as the cap
            'body' => 'required',
            'tags' => 'required|arrayCountMax:6|arrayCountMin:1',
            'topics' => 'required|arrayCountMax:4|arrayCountMin:1',
            'file_image'=> 'max:50000|image', // don't require this
        ]);


        $blog_id = $request->input('blog_id');
        $blog = Blog::find($blog_id);
        if ($blog && ($blog->author_id == $request->user()->id || $request->user()->is_admin())) {

            $file = $request->file('file_source');
            $main_image = $request->file('file_image');

            $time = substr(str_shuffle(MD5(microtime())), 0, 15);

            if($main_image){
                $main_image_dest =  $time . '.'.$main_image->getClientOriginalExtension();
                $blog->main_image = $main_image_dest;
                $request->file('file_image')->move('uploads', $main_image_dest);
            }


            $title = $request->input('title');
            $blog->slug = str_slug($title); // Don't check for duplicates anymore since postId is part of the title URL
            $blog->title = $title;
            $blog->description = $request->input('description');
            $blog->body = $request->input('body');
            $blog->body_html = Purifier::clean(Markdown::convertToHtml($request->input('body')));

            ////////// Find all images and center them and make them responsive!
            $dom = new DOMDocument;
            $dom->loadHTML($blog->body_html);
            $images = $dom->getElementsByTagName('img');
            foreach ($images as $image) {
                $image->setAttribute('class', 'img-responsive img-thumbnail center-block');
            }
            $html = $dom->saveHTML();
            $blog->body_html = $html;
            //////////

            if ($request->has('save')) {
                $blog->active = 0;
                $message = 'Post saved successfully';
                $landing = '/blog/edit/' . $blog->id .'/'.$blog->slug;
            } else {
                $blog->active = 1;
                $message = 'Post updated successfully';
                $landing = '/blog/'.$blog->id .'/'.$blog->slug;
            }
            $prevCategories = $blog->categories; // save the old cateogires before saving so that we can decrement count
            if($blog->save()) {
                foreach($prevCategories as $cat){
                   // Db::table('blog_categories')->where('id',$cat->id)->decrement('count'); // Decrement existing categories
                }

                // First remove existing relationships
                $cat_string = $request->get('topics');
                $cat_ids = explode(',', $cat_string);
                $blog->categories()->sync($cat_ids); // save categories
                foreach($cat_ids as $id){
                   // Db::table('categories')->where('id',$id)->increment('count'); // increment new categories
                }
                $blog->retag($request->get('tags')); // delete current tags and save new tags
            }

            return redirect($landing)->withMessage($message);
        } else {
            return redirect('/')->withErrors('You do not have sufficient permissions or the post does not exist');
        }
    }

    public function destroy(Request $request, $id)
    {
        //
        $blog = Blog::find($id);
        if ($blog && ($blog->author_id == $request->user()->id || $request->user()->is_admin())) {
            $blog->delete();
            $data['message'] = 'Blog post deleted successfully';
        } else {
            $data['errors'] = 'Invalid Operation. You do not have sufficient permissions';
        }
        return redirect('/')->with($data);
    }


}