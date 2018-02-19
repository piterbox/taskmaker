<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Image;


class CabinetController extends Controller
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
     * Show the user's cabinet.
     *
     * @return view
     */
    public function index()
    {
        //getting autorized user
        $user = User::get()->where('id', Auth::id())->first();
        
        return view('cabinet')->with('user', $user);
    }

    /**
     * Update data of user (name, avatar).
     *
     * @return redirect to cabinet
     */
    public function update(Request $request)
    {
        //getting autorized user
        $user = User::get()->where('id', Auth::id())->first();
        //validation input data
        $validatedData = $request->validate([
            'name' => 'required|max:120|min:3',
            'avatar' => 'image|size:1000'
        ]);
        if(!empty($request->input('name'))){
            $user->name = strip_tags($request->input('name'));
        }
        //resizing avatar and saving
        if ($request->hasFile('avatar')) {
           $image = $request->file('avatar');
           $filename = time() . '.' . $image->getClientOriginalExtension();
           $location = public_path('images/' . $filename);
           Image::make($image)->resize(25, 25)->save($location);
           $user->avatar=$filename;
        }
        
        if($user->update()){
            return redirect('/cabinet')->with(['success' => 'Data of user has been changed!']);
        }
        else{
            return redirect('/cabinet')->with(['error' => 'Something was wrong!']);
        }
        
    }
}
