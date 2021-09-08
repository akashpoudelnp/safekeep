<?php

namespace App\Http\Livewire;
use App\Models\Word;
use App\Services\JackKrypt;
use Livewire\Component;

class SecretTable extends Component
{
    public $term = "";
    public function render()
    {

        sleep(1);
        $words = Word::where("title",'like',"%$this->term%")->where("user_id",Auth()->user()->id)->get();
        // foreach ($words as $word) {
        //     $de_phrase[$word->id]= JackKrypt::decrypt($word->phrase,$key);
        //     $integrity[$word->id]= JackKrypt::CheckHash($word->title,$word->phrase,$word->hash,$key);
        // }
        $data = [
            'words' => $words,
        ];

        return view('livewire.secret-table', $data);
    }
}
