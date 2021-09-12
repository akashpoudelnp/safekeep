<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Services\JackKrypt;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function exportCSV()
    {
        return view("word.exportcsv");
    }
    public function exportascsv(Request $request)
    {
        if ($request->isMethod('get')) {
            abort(404);
        }
        $request->validate([

            'key' => ['required'],


        ]);
        $key = $request->key;
        if (!Hash::check($request->key, auth()->user()->password)) {
            return redirect()->back()->withErrors('Password not matched to this account');
        }
        $dt = new DateTime();

        $now = $dt->format('Y-m-d-H-i-s');
        $fileName = "exported-safekeep-$now.csv";
        $words = Word::where("user_id", Auth()->user()->id)->orderBy('title', 'ASC')->get();
        if (!$words->count() >= 1) {
            abort(404);
        }
        foreach ($words as $word) {
            $de_phrase[$word->id] = JackKrypt::decrypt($word->phrase, $key);
            $integrity[$word->id] = JackKrypt::CheckHash($word->title, $word->phrase, $word->hash, $key);
        }

        $headers = array(
            "Content-type"        => "text/csv; charset=utf-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Title', 'Secret', 'Date');

        $callback = function () use ($words, $columns, $de_phrase) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($words as $word) {
                $row['Title']  = $word->title;
                $row['Secret']    = $de_phrase[$word->id];
                $row['Creation Date']  = Carbon::parse($word->created_at)->format('d-m-Y');

                fputcsv($file, array($row['Title'], $row['Secret'], $row['Creation Date']));
            }

            fclose($file);
        };
        return (new StreamedResponse($callback, 200, $headers))->sendContent();
    }

    public function showall(Request $request)
    {
        $request->validate([

            'key' => ['required'],


        ]);
        $key = $request->key;
        if (!Hash::check($request->key, auth()->user()->password)) {
            return redirect()->back()->withErrors('Password not matched to this account');
        }

        $words = Word::where("user_id", Auth()->user()->id)->orderBy('title', 'ASC')->get();
        if (!$words->count() >= 1) {
            return redirect()->back()->withErrors('You have not added any secrets yet!');
        }
        foreach ($words as $word) {
            $de_phrase[$word->id] = JackKrypt::decrypt($word->phrase, $key);
            $integrity[$word->id] = JackKrypt::CheckHash($word->title, $word->phrase, $word->hash, $key);
        }




        return view("word.showall")->with("words", $words)->with('de_phrase', $de_phrase)->with('integrity', $integrity);
    }
    public function emptysecretsview()
    {
        return view("word.deleteall");
    }
    public function emptysecrets(Request $request)
    {
        $request->validate([

            'key' => ['required'],
        ]);
        $key = $request->key;
        if (!Hash::check($request->key, auth()->user()->password)) {
            return redirect()->back()->withErrors('Password not matched to this account');
        }

        $words = Word::where("user_id", Auth()->user()->id)->orderBy('title', 'ASC')->get();
        if (!$words->count() >= 1) {
            return redirect()->back()->withErrors('You have no secrets to delete.');
        }
        foreach ($words as $word) {
            $word->delete();
        }
        return redirect()->back()->with('success','All of your secrets have been deleted.');

    }
    public function restore()
    {
        return view("word.restore");
    }
    public function executerestore(Request $request)
    {
        $request->validate([

            'key' => ['required'],
            'csvfile' => 'required|mimes:csv,txt',
        ]);
        if (!Hash::check($request->key, auth()->user()->password)) {
            return redirect()->back()->withErrors('Password not matched to this account');
        }

      $file=  $request->file('csvfile');

      $key= $request->key;
      $tempPath = $file->getRealPath();
      $secretArr = JackKrypt::csvToArray($tempPath);
        foreach ($secretArr as $key => $value) {
           // $value['Title']
            $pre_hash =  $value['Title'] .  $value['Secret'];
            $en_phrase = JackKrypt::encrypt( $value['Secret'], $request->key);
            $word = new Word;
            $word->user_id = auth()->user()->id;
            $word->title =  $value['Title'];
            $word->phrase =  $en_phrase;
            $word->hash = Hash::make($pre_hash);
            $word->save();
        }

        return redirect()
            ->route('restore')
            ->with('success', 'A Secret has been added sucessfully!');
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

        if (!Hash::check($request->secret, auth()->user()->password)) {
            return redirect()->back()->withErrors('Password not matched to this account');
        }

        $pre_hash = $request->title . $request->phrase;
        $en_phrase = JackKrypt::encrypt($request->phrase, $request->secret);
        $word = new Word;
        $word->user_id = auth()->user()->id;
        $word->title = $request->title;
        $word->phrase =  $en_phrase;
        $word->hash = Hash::make($pre_hash);

        $word->save();
        return redirect()
            ->route('word.create')
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
