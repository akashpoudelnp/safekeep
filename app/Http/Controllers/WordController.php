<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Services\JackKrypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showall(Request $request)
    {
        $request->validate([

            'key' => ['required'],


        ]);
        $key= $request->key;
        $words= Word::where("user_id",Auth()->user()->id)->orderBy('title', 'ASC')->get();
        if(!$words->count()>=1)
        {
            abort(403,"No Secrets have been saved yet");
        }
        foreach ($words as $word) {
            $de_phrase[$word->id]= JackKrypt::decrypt($word->phrase,$key);
            $integrity[$word->id]= JackKrypt::CheckHash($word->title,$word->phrase,$word->hash,$key);
        }
        return view("word.showall")->with("words",$words)->with('de_phrase',$de_phrase)->with('integrity',$integrity);
    }
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view("word.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:100'],
            'phrase' => ['required'],
            'secret' => ['required'],


        ]);

        if(!Hash::check($request->secret,auth()->user()->password) )
        {
            return redirect()->back()->withErrors('Password not matched to this account');
        }

        $pre_hash= $request->title.$request->phrase;
       $en_phrase= JackKrypt::encrypt($request->phrase,$request->secret);
        $word= new Word;
        $word->user_id= auth()->user()->id;
        $word->title= $request->title;
        $word->phrase=  $en_phrase;
        $word->hash= Hash::make($pre_hash);

        $word->save();
        return redirect()
        ->route('dashboard')
        ->with('success', 'A Secret has been added sucessfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function show(Word $word)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function edit(Word $word)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Word $word)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function destroy(Word $word)
    {
        $word->delete();
        return redirect()
            ->route('dashboard')
            ->with('error', "Secret: $word->title  has been deleted sucessfully!");
    }
}
