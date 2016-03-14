<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Comments;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CommentController extends Controller {
    public function store(Request $request)
    {
        //on_post, from_user, body
        $input['from_user'] = $request->user()->id;
        $input['on_post'] = $request->input('on_post');
        $input['body'] = $request->input('body');
        $slug = $request->input('slug');
        $id = $input['on_post'];
        Comments::create( $input );
        return redirect('/'.$id.'/'.$slug)->with('message', 'Comment published');
    }
}
