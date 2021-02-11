<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(User $user)
    {
        return view('account', compact('user'));
    }
    public function update(User $user)
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'file' => 'image|max:2048'
        ]);
        $user->name = request()->name;
        if(request()->hasFile('file')){
            $image_file = request()->file('file');
            $image = Image::make($image_file);
            Response::make($image->utf8_encode('jpg'));
            $user->image = $image;
        }
        $user->save();
        return redirect(route('account.show',$user));
    }
}
