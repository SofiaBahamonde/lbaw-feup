<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
use Image;

class UsersController extends Controller
{
    public function profile($id){
        $user = User::find($id);
        $favorites = $user->favorites;

        $orders = Order::where('id_user',$id)->get();

        return view('user.profile',compact('user','favorites','orders'));
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();

        return redirect()->route('home');
   }

   public function update(Request $request,$id){
        $user = User::find($id);

        $user->username = request('username');
        $user->address = request('address');
        $user->city = request('city');
        $user->email = request('email');
        $user->zip = request('zip');

        $avatar = $request->file('avatar');

        if($avatar != null){
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->save( public_path('/images/avatars/' . $filename ) );
            $user->avatar = $filename;
        }

        $user->save();

        return redirect()->route('profile',['id' => $user->id]);
    }

    public function cart($id){
      $user = User::find($id);
      $products= $user->cart;
     // $quantities = 
      return view('cart.cart',compact('products'));
    }

}
