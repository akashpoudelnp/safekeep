<?php

namespace App\Http\Controllers;

use App\Models\SecretKey;
use App\Models\User;
use App\Models\Word;
use App\Services\JackKrypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
//    public function index()
//    {
//       return view("welcome");
//    }
   public function dashboard()
   {
     //  dd(auth()->user());
    $words= Word::where("user_id",Auth()->user()->id)->get();

      return view("dashboard")->with("words",$words);
   }


}
