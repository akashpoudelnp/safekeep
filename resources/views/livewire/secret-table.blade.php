<div class="flex ">
    <div class="px-4 space-y-4 mt-8 m-auto">
        <form class="" method="get">
            <input style="width: 100%;" class="border-solid border border-gray-300 p-2 md:w-1/4 rounded-md"
                type="text" placeholder="search words" wire:model="term" />
        </form>
        <div wire:loading>Searching your secrets...</div>
        <div wire:loading.remove>
        <!--
            notice that $term is available as a public
            variable, even though it's not part of the
            data array
        -->
        @if ($term == "")
            <div class="text-gray-500 text-sm">
                Enter a term to search secrets.
            </div>
        @else
            @if($words->isempty())
                <div class="text-gray-500 text-sm">
                    no matching result was found.
                </div>
            @else
                @foreach($words as $word)
                    <div class="flex flex-row place-items-stretch border m-4">
                        <h3 class="text-lg text-gray-900 text-bold">{{$word->title}}</h3>
                        <a href="#ph-{{$word->id}}"      class="bg-green-400 rounded text-blue-50 hover:bg-green-300 p-1 mx-2">View</a>
                    </div>
                @endforeach
            @endif
        @endif
        </div>
    </div>
    {{-- <div class="px-4 mt-4">
        {{$users->links()}}
    </div> --}}
</div>
