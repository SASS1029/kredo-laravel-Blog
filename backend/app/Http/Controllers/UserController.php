<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use App\Models\User;

class UserController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'public/avatars/';
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }
    
     public function show() {
         $user = $this->user->findOrFail(Auth::user()->id);
         $my_posts = $user->posts->sortByDesc('id');

         return view('users.show')
                    ->with('user',$user)
                    ->with('my_posts', $my_posts);
     }   

     public function edit() {
         $user = $this->user->findOrFail(Auth::user()->id);

         return view('users.edit')
                 ->with('user', $user);
     }

     public function update(Request $request) {
         $request->validate([
             'name'  => 'required|min:1|max:50',
             'email' => 'required|email|max:50|'. Rule::unique('users')->ignore(Auth::user()->id),
             'avatar'=> 'mimes:jpeg,png,jpg,gif|max:1048'
         ]);

         $user = $this->user->findOrFail(Auth::user()->id);
         $user->name = $request->name;
         $user->email = $request->email;

         if($request->avatar) {
             $user->avatar = $this->saveAvatar($request, $user->avatar);
         }

         $user->save();

         return redirect()->route('user.show');
     }

     public function saveAvatar($request, $avatar = null) {
         //Change the name of the image to avoid overwriting
        $image_name = time() . "." . $request->avatar->extension();

        //Save the image inside storage/app/public/avatars folder
        $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER,$image_name);

        //If avatar is not null/there is an avatar in the database, delete the existing avatar.
        if($avatar) {
            $this->deleteAvatar($avatar);
        }

        return $image_name;
     }

     public function deleteAvatar($avatar) {
         $img_path = self::LOCAL_STORAGE_FOLDER . $avatar;

         if(Storage::disk('local')->exists($img_path)) {
             Storage::disk('local')->delete($img_path);
         }
     }
    
}
