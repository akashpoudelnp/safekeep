<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Secrets') }}
        </h2>
    </x-slot>

    {{-- <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
        Uncompromized
      </span> --}}
    <h3 class="p-4 text-center text-xl border-b-2">My Saved Secrets</h3>
    <livewire:secret-table/>
    <div class="py-6 mt-4">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="flex flex-col">
                    <div class="tools flex flex-row place-items-stretch p-2">
                        <a href="{{ route('word.create') }}"
                        class="bg-green-400 rounded text-blue-50 hover:bg-green-300 p-1 ">Add New</a>
                        <a href="{{route("exportCSV")}}" class="bg-blue-400 rounded text-blue-50 hover:bg-blue-300 p-1 mx-2">Export as CSV</a>


                          <a href="{{route("emptysecretsview")}}" class="bg-red-600 rounded text-red-50 hover:bg-red-400 p-1">Delete all</a>
                    </div>
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>

                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Title
                                            </th>

                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Secret
                                            </th>
                                            <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Integrity
                                        </th>
                                        <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                    </th>


                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                      @forelse ($words as $word)
                                      <tr>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{$word->title}}</div>
                                                </td>

                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                      <div id="ph-{{$word->id}}" class="p-2 border-2 border-gray-200 bg-gray-100">
                                                        {{$de_phrase[$word->id]}}
                                                      </div>
                                                      <div>
                                                          <button class="bg-blue-100 text-blue-800 p-1 rounded disabled:text-blue-300 hover:text-blue-500 active:text-blue-400 active:border-blue-200" data-clipboard-text=" {{$de_phrase[$word->id]}}" >Copy</button>
                                                      </div>
                                                        </td>
                                        <td class="px-6 py-4 whitespace-nowraptext-sm font-medium">
                                                 <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($integrity[$word->id])bg-green-100 text-green-800   @else bg-red-100 text-red-800 @endif ">
                                                    @if ($integrity[$word->id])
                                                       UnAltered
                                                    @else
                                                        Invalid
                                                    @endif
      </span>

                                        </td>
                                        <td colspan="2" class="px-6 py-4 whitespace-nowrap">
                                             <a href="#" onclick="deleteWord({{$word->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                  </svg>
                                            </a>
                                            <form style="display:none" method="POST" id="delete-{{$word->id}}" action="{{route('word.destroy',$word->id)}}">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                        </td>

                                    </tr>
                                      @empty
                                      <tr>

                                        <td colspan="2" class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Aww snap its empty</div>

                                        </td>



                                    </tr>
                                      @endforelse


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        function deleteWord(id){
            if(confirm('Are You sure you want to delete this Secret?')){
                document.querySelector('#delete-'+ id).submit();
            }
        }
    </script>
<script>


var btns = document.querySelectorAll('button');
      var clipboard = new ClipboardJS(btns);
      clipboard.on('success', function(e) {
    console.info('Action:', 'actn');
    console.info('Text:', 'Copied');
    console.info('Trigger:', 'trig');

    e.clearSelection();
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
})



</script>
</x-app-layout>
