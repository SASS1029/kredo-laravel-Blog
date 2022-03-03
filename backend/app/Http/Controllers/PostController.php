<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Post;

class PostController extends Controller
{
    private $post;
    const LOCAL_STORAGE_FOLDER = 'public/images/';

    public function __construct(Post $post) {
        $this->post = $post;
    }



    public function index() {
        $all_posts = $this->post->latest()->get(); 

        return view('posts.index')    //postsfolderのindexfile
                 ->with('all_posts', $all_posts);
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title'=> 'required|min:1|max:50',
            'body'=> 'required|min:1|max:1000',
            'image'=> 'required|mimes:jpg,png,png,jpeg,gif|max:1048'
        ]);

        //table column name = data from the form
        $this->post->user_id = Auth::user()->id;
        $this->post->title = $request->title;
        $this->post->body= $request->body;
        $this->post->image = $this->saveImage($request);
        $this->post->save();

        return redirect()->route('index');
    }

    public function saveImage($request, $post_id = null){
        //Change the name of the image to CURRENT TIME to avoid overwriting.
        $image_name = time() . "." . $request->image->extension();

        //Save the image inside storage/app/public/images
        $request->image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

        //Delete if there's any existing image
        $this->deletePostImage($post_id);

        //Return the new name to save to the database
        return $image_name;
    }

    public function deletePostImage($post_id) {
        $post_image = $this->post->where('id', $post_id)->pluck('image')->first();
        //SELECT image FROM posts WHERE id = $post_id LIMIT 1;
        
        if($post_image) {
            $img_path = self::LOCAL_STORAGE_FOLDER . $post_image;
            //$img_path = /public/images/168127674.jpg

            //If the image is existing, delete.
            if(Storage::disk('local')->exists($img_path))  {
                Storage::disk('local')->delete($img_path);
            }
        }
    }

    public function show($id) {
        $post = $this->post->findOrFail($id);
        $comments = $post->comments->sortByDesc('id');

        return view('posts.show')
                ->with('post', $post)
                ->with('comments' , $comments);
    }

    public function edit($id) {
        $post = $this->post->findOrFail($id);

        return view('posts.edit')
                ->with('post', $post);
    }

    public function update($id, Request $request) {
        $request->validate([
            'title'=> 'required|min:1|max:50',
            'body'=> 'required|min:1|max:1000',
            'image'=> 'required|mimes:jpg,png,png,jpeg,gif|max:1048'
         ]);

         $post = $this->post->findOrFail($id);
         $post->title = $request->title;
         $post->body = $request->body;

        //If there is a new image,save it. Otherwise, the image will not be updated.
         if($request->image) {
             $post->image = $this->saveImage($request,$post->id);

         }

         $post->save();

         return redirect()->route('index');
         
    }

    public function destroy($id) {
        $this->deletePostImage($id);
        $this->post->destroy($id);
        //$this->post->findOrFail($id)->delete();//destroyの方が記述量が少ない

        return redirect()->back();
        //return redirect()->route('index');
    }

    

    
        
    
}
