<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
     * Display active posts of a particular user
     *
     * @param int $id
     * @return view
     */
    private $inputs = array();

    // So the home page doesn't break
    public function __construct()
    {
        $this->inputs = array('vendor' => '',
            'sort' => '',
            'filter' => '',
        );
    }

    public function user_posts($id)
    {
        //
        $posts = Posts::where('author_id', $id)->where('active', 1)->orderBy('created_at', 'desc')->paginate(5);
        $title = User::find($id)->name;
        return view('home')->withPosts($posts)->withTitle($title)->withInputs($this->inputs);
    }

    /*
     * Display all of the posts of a particular user
     *
     * @param Request $request
     * @return view
     */
    public function user_posts_all(Request $request)
    {
        //
        $user = $request->user();
        $posts = Posts::where('author_id', $user->id)->orderBy('created_at', 'desc')->paginate(5);
        $title = $user->name;
        return view('home')->withPosts($posts)->withTitle($title)->withInputs($this->inputs);
    }

    /*
     * Display draft posts of a currently active user
     *
     * @param Request $request
     * @return view
     */
    public function user_posts_draft(Request $request)
    {
        //
        $user = $request->user();
        $posts = Posts::where('author_id', $user->id)->where('active', 0)->orderBy('created_at', 'desc')->paginate(5);
        $title = $user->name;
        return view('home')->withPosts($posts)->withTitle($title)->withInputs($this->inputs);
    }

    /**
     * profile for user
     */
    public function profile(Request $request, $id)
    {
        $data['user'] = User::find($id);
        if (!$data['user'])
            return redirect('/');
        if ($request->user() && $data['user']->id == $request->user()->id) {
            $data['author'] = true;
        }
        if($request->user()){
            if($request->user()->role == 'admin')
                $data['author'] = true; // also allow admin access to see
        }

        else {
            $data['author'] = null;
        }
        
        // @note For some reason, there is a diff between MYSQL database interpetations
        // of active input needing to be a string or number
        $data['comments_count'] = $data['user']->comments->count();
        $data['posts_count'] = $data['user']->posts->count();
        $data['posts_active_count'] = $data['user']->posts->where('active',1)->count();
        $data['posts_draft_count'] = $data['posts_count'] - $data['posts_active_count'];
        $data['latest_posts'] = Posts::where('author_id', $data['user']->id)->where('active', 1)->orderBy('created_at', 'desc')->take(5)->get();//$data['user']->posts->where('active', 1)->take(5);
        $data['latest_comments'] = $data['user']->comments->take(5);
        return view('admin.profile', $data);
    }
}
