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
use Illuminate\Pagination\LengthAwarePaginator;

// @see http://stackoverflow.com/a/35347256
class PostController extends Controller
{
    //
    public function index()
    {
        // fetch 5 posts from db which are active and latest
        $posts = Posts::where('active', 1)->with('categories')->with('tagged')->orderBy('created_at', 'desc')->paginate(5);
       // print_r($posts); die;
        $title = 'Latest Posts';

        return view('home')->withPosts($posts)->withTitle($title);


    }

    public function about()
    {
        return view('static.about');
    }

    public function image_upload(Request $request)
    {
        $uploadedFiles = array();
        //$allFiles = Input::file();
//        if(Input::hasFile('files')){
//            echo 'hi';
//        }
//        $files = $request->allFiles();
//        $name = Input::file('file')->getFilename();
//        echo json_encode($name); die;
//        Request::file('photo')->move('uploads');


        if (!empty($_FILES)) {
            foreach ($_FILES as $file) {
//                $file = array('image' => Input::file('image'));
//                $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
//                $validator = Validator::make($file, $rules);
//                $destinationPath = 'uploads'; // upload path
//                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
//                $fileName = rand(11111,99999).'.'.$extension; // renameing image
//                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
//                Session::flash('success', 'Upload successfully');

                // source: http://www.w3schools.com/php/php_file_upload.asp
                $target_dir = "/uploads/";
                $dest_file_name = substr(str_shuffle(MD5(microtime())), 0, 15);
                $target_file = $target_dir . $dest_file_name . '.' .pathinfo($file['name'], PATHINFO_EXTENSION);
                $uploadOk = 1;

                $imageFileType = pathinfo($file['name'], PATHINFO_EXTENSION);
                // Check if image file is a actual image or fake image
                if (1) {
                    $check = getimagesize($file["tmp_name"]);
                    if ($check !== false) {
                       // echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        //echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }
                // Check if file already exists
                if (file_exists($target_file)) {
                    //echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                // Check file size
                if ($file["size"] > 500000) {
                    //echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != 'PNG'
                ) {
                    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    //echo "Sorry, your file was not uploaded.";

                // if everything is ok, try to upload file
                } else {
                    $uploadedFiles[] = $target_file;

                    if (move_uploaded_file($file["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$target_file)) {
                        //echo "The file " . basename($file["name"]) . " has been uploaded.";
                       // $uploadedFiles[] = $target_file;

                    } else {
                        //echo "Sorry, there was an error uploading your file.";
                    }
                }


//                if (move_uploaded_file($file['tmp_name'], 'uploads/' . urlencode($file['name']))) {
//                    $uploadedFiles[] = 'uploads/' . urlencode($file['name']);
//                }
            }
        }

        echo json_encode($uploadedFiles);
    }

    public function create(Request $request)
    {
        // check if user can post
        if ($request->user()->can_post()) {

            // Grab the available categories and such
            $categories = Categories::all();
            $mcus = Mcus::orderBy('vendor_id')->get();
            $compilers = McuCompilers::orderBy('vendor_id')->get();
            $languages = McuLanguages::where('slug', '!=', 'none')->orderBy('id')->get();
            $tags = Posts::existingTags()->toArray();

            return view('posts.create')
                ->withCategories($categories)
                ->withMcus($mcus)
                ->withTags(json_encode($tags))
                ->withCompilers($compilers)
                ->withLanguages($languages);
        } else {
            return redirect('/')->withErrors('You have not sufficent permissions to post!');
        }
    }



    public function store(Request $request) //PostFormRequest
    {
       // return Redirect::to('new-post')->withErrors('wooops')->withInput();

        $this->validate($request, [
            'title' => 'required|unique:posts|max:255',
            'title' => array('Regex:/^[A-Za-z0-9 ]+$/'),
            'body' => 'required',
            'tags' => 'required|arrayCountMax:2|arrayCountMin:1',
            'topics' => 'required|arrayCountMax:4|arrayCountMin:1',
            'micro' => 'required',
            'languages' => 'arrayCountMax:3',
            'compiler-assembler' => 'required|arrayCountMax:3',
            'file_source'=> 'max:10000|mimes:zip', // don't require this
            'file_image'=> 'max:10000|image', // don't require this
        ]);

        $file = $request->file('file_source');
        $main_image = $request->file('file_image');
        $time = substr(str_shuffle(MD5(microtime())), 0, 15);
        $file_source_dest = $time . '.'.$file->getClientOriginalExtension();
        $main_image_dest =  $time . '.'.$main_image->getClientOriginalExtension();
        $request->file('file_source')->move('uploads', $file_source_dest);
        $request->file('file_image')->move('uploads', $main_image_dest);


        $post = new Posts();
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->body_html = Markdown::convertToHtml($request->get('body')); // convert ONCE here
        $post->slug = str_slug($post->title);
        $post->author_id = $request->user()->id;
        $post->more_info_link = $request->get('more_info_link');
        $post->mcu_id = $request->get('micro');
        $post->compiler_id = $request->get('compiler-assembler');
        $post->source_file = $file_source_dest;
        $post->main_image_dest = $main_image_dest;

        if ($request->has('save')) {
            $post->active = 0;
            $message = 'Post saved successfully';
        } else {
            $post->active = 1;
            $message = 'Post published successfully';
        }

        if($post->save()) {

            $cat_string = $request->get('topics');
            $languages = $request->get('languages');
            $cat_ids = explode(',', $cat_string);
            $post->categories()->sync($cat_ids); // save categories
            $language_ids = explode(',', $languages);
            if(empty($languages)){
                $language_ids = array(99); // If none posted, save the language as 'None'
            }
            $post->languages()->sync($language_ids);

            // Must first save the ID before tagging!
            $post->tag($request->get('tags')); // delete current tags and save new tags

        }




        return redirect('edit/' . $post->slug)->withMessage($message);
    }

    public function show($id, $slug)
    {
        //https://laravel.com/docs/5.1/eloquent-relationships#eager-loading
        //https://github.com/rtconner/laravel-tagging
        $post = Posts::with('tagged')->where('id',$id)->first();
        // This gets posts with where clause on inside
//        $post = Posts::with(['tagged' => function ($query) use($slug){
//            $query->where('slug', $slug);
//        }])->get();

        if (!$post) {
            return redirect('/')->withErrors('requested page not found');
        }
        // Grab other associated display things
        $categories = $post->categories;
        $languages = $post->languages;
        $comments = $post->comments;

        $compiler = $post->compiler;
        $mcu = $post->mcu;
        if($mcu) {
            $vendor = $mcu->vendor;
            $arch = $mcu->arch;
        }


        return view('posts.show')->withPost($post)->withComments($comments)->withCategories($categories)
            ->withLanguages($languages)
            ->withVendor($vendor)
            ->withArch($arch)
            ->withCompiler($compiler)
            ->withMcu($mcu);
    }

    public function edit(Request $request, $id, $slug)
    {

        $post = Posts::where('id', $id)->first();
        if ($post && ($request->user()->id == $post->author_id || $request->user()->is_admin())) {
            // Grab the available categories and such
            $categories = Categories::all();
            $mcus = Mcus::orderBy('vendor_id')->get();
            $compilers = McuCompilers::orderBy('vendor_id')->get();
            $languages = McuLanguages::where('slug', '!=', 'none')->orderBy('id')->get();
            $tags = Posts::existingTags()->toArray();
            //print_r($tags); die;

            // Get the existing tags for the post
            $existingTags = $post->tagged->toArray();
            $existingTagsArray = array();
            foreach($existingTags as $tag){
                $existingTagsArray[] = $tag['tag']['slug'];
            }
            $existingCatArray = array();
            foreach($post->categories as $cat){
                $existingCatArray[] = $cat->id;
            }
            $existingLanguagesArray = array();
            foreach($post->languages as $language){
                $existingLanguagesArray[] = $language->id;
            }
            $existingCompiler = '999999';
            if($post->compiler)
                $existingCompiler = $post->compiler->id;

            $existingMcu = $post->mcu->id;


            return view('posts.edit')
                ->withPost($post)
                ->with('existingTags',implode(',',$existingTagsArray))
                ->with('existingCategories',implode(',',$existingCatArray))
                ->with('existingLanguages',implode(',',$existingLanguagesArray))
                ->with('existingCompilers',$existingCompiler)
                ->with('existingMcu',$existingMcu)


                ->withTags(json_encode($tags))
                ->withCategories($categories)
                ->withMcus($mcus)
                ->withCompilers($compilers)
                ->withLanguages($languages);
        }
        return redirect('/')->withErrors('you have not sufficient permissions');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:posts|max:255',
            'title' => array('Regex:/^[A-Za-z0-9 ]+$/'),
            'body' => 'required',
            'tags' => 'required|arrayCountMax:2|arrayCountMin:1',
            'topics' => 'required|arrayCountMax:4|arrayCountMin:1',
            'micro' => 'required',
            'languages' => 'arrayCountMax:3',
            'compiler-assembler' => 'required|arrayCountMax:3',
            'file_source'=> 'max:10000|mimes:zip', // don't require this
            'file_image'=> 'max:10000|image', // don't require this
        ]);


        $post_id = $request->input('post_id');
        $post = Posts::find($post_id);
        if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {

            $file = $request->file('file_source');
            $main_image = $request->file('file_image');

            $time = substr(str_shuffle(MD5(microtime())), 0, 15);

            if($file){
                $file_source_dest = $time . '.'. $file->getClientOriginalExtension();
                $post->source_file = $file_source_dest;
                $request->file('file_source')->move('uploads', $file_source_dest);

            }
            if($main_image){
                $main_image_dest =  $time . '.'.$main_image->getClientOriginalExtension();
                $post->main_image = $main_image_dest;
                $request->file('file_image')->move('uploads', $main_image_dest);
            }


            $title = $request->input('title');
            $post->slug = str_slug($title); // Don't check for duplicates anymore since postId is part of the title URL
            $post->title = $title;
            $post->body = $request->input('body');
            $post->body_html = Markdown::convertToHtml($request->input('body'));
            $post->more_info_link = $request->get('more_info_link');
            $post->mcu_id = $request->get('micro');
            $post->compiler_id = $request->get('compiler-assembler');

            if ($request->has('save')) {
                $post->active = 0;
                $message = 'Post saved successfully';
                $landing = 'edit/' . $post->id .'/'.$post->slug;
            } else {
                $post->active = 1;
                $message = 'Post updated successfully';
                $landing = $post->id .'/'.$post->slug;
            }
            if($post->save()) {
                // First remove existing relationships

                $cat_string = $request->get('topics');
                $languages = $request->get('languages');
                $cat_ids = explode(',', $cat_string);
                $post->categories()->sync($cat_ids); // save categories
                $language_ids = explode(',', $languages);
                if(empty($languages)){
                    $language_ids = array(99); // If none posted, save the language as 'None'
                }

                $post->languages()->sync($language_ids);

                $post->retag($request->get('tags')); // delete current tags and save new tags
            }

            return redirect($landing)->withMessage($message);
        } else {
            return redirect('/')->withErrors('You do not have sufficient permissions or the post does not exist');
        }
    }

    public function destroy(Request $request, $id)
    {
        //
        $post = Posts::find($id);
        if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
            $post->delete();
            $data['message'] = 'Post deleted Successfully';
        } else {
            $data['errors'] = 'Invalid Operation. You do not have sufficient permissions';
        }
        return redirect('/')->with($data);
    }
}
