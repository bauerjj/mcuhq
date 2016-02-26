<?php

namespace App\Http\Controllers;


use Input;
use Validator;
use Session;
use App\Posts;
use App\User;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use Illuminate\Http\Request;
use GrahamCampbell\Markdown\Facades\Markdown; // use this to convert markdown to html


// @see http://stackoverflow.com/a/35347256
class PostController extends Controller
{
    //
    public function index()
    {
        // fetch 5 posts from db which are active and latest
        $posts = Posts::where('active', 1)->orderBy('created_at', 'desc')->paginate(5);
        // page heading
        $title = 'Latest Posts';
        return view('home')->withPosts($posts)->withTitle($title);
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
                $target_dir = "uploads/";
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

                    if (move_uploaded_file($file["tmp_name"], $target_file)) {
                        //echo "The file " . basename($file["name"]) . " has been uploaded.";
                        $uploadedFiles[] = $target_file;

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

            return view('posts.create');
        } else {
            return redirect('/')->withErrors('You have not sufficent permissions to post!');
        }
    }

    public function store(PostFormRequest $request)
    {
        $post = new Posts();
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->body_html = Markdown::convertToHtml($request->get('body')); // convert ONCE here
        $post->slug = str_slug($post->title);
        $post->author_id = $request->user()->id;
        if ($request->has('save')) {
            $post->active = 0;
            $message = 'Post saved successfully';
        } else {
            $post->active = 1;
            $message = 'Post published successfully';
        }
        $post->save();
        return redirect('edit/' . $post->slug)->withMessage($message);
    }

    public function show($slug)
    {
        $post = Posts::where('slug', $slug)->first();
        if (!$post) {
            return redirect('/')->withErrors('requested page not found');
        }
        $comments = $post->comments;
        return view('posts.show')->withPost($post)->withComments($comments);
    }

    public function edit(Request $request, $slug)
    {
        $post = Posts::where('slug', $slug)->first();
        if ($post && ($request->user()->id == $post->author_id || $request->user()->is_admin()))
            return view('posts.edit')->with('post', $post);
        return redirect('/')->withErrors('you have not sufficient permissions');
    }

    public function update(Request $request)
    {
        //
        $post_id = $request->input('post_id');
        $post = Posts::find($post_id);
        if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
            $title = $request->input('title');
            $slug = str_slug($title);
            $duplicate = Posts::where('slug', $slug)->first();
            if ($duplicate) {
                if ($duplicate->id != $post_id) {
                    return redirect('edit/' . $post->slug)->withErrors('Title already exists.')->withInput();
                } else {
                    $post->slug = $slug;
                }
            }
            $post->title = $title;
            $post->body = $request->input('body');
            $post->body_html = Markdown::convertToHtml($request->input('body'));
            if ($request->has('save')) {
                $post->active = 0;
                $message = 'Post saved successfully';
                $landing = 'edit/' . $post->slug;
            } else {
                $post->active = 1;
                $message = 'Post updated successfully';
                $landing = $post->slug;
            }
            $post->save();
            return redirect($landing)->withMessage($message);
        } else {
            return redirect('/')->withErrors('you have not sufficient permissions');
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
            $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
        }
        return redirect('/')->with($data);
    }
}
