<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Restore Your Secrets from CSV') }}
        </h2>
    </x-slot>
    @if($errors->any())
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
        <div class="flex">
          <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
          <div>
            <p class="font-bold">{{$errors->first()}}</p>

          </div>
        </div>
      </div>
    <div>
        @endif
        @if(session('success'))


         <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-1 m-2 rounded relative" role="alert">
            <strong class="font-bold">{{ session('success') }}</strong>
          </div>
        @endif

    <div class="p-9">

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('executerestore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-800" for="view_model_csv"> Upload a CSV File </label>
                            <div class="relative">
                              <input class="border-gray-300 focus:ring-blue-600 block w-full overflow-hidden cursor-pointer border text-gray-800 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" aria-describedby="view_model_csv_help" id="view_model_csv" name="csvfile" type="file" />
                            </div>
                            <div class="mt-1 text-sm text-gray-500" id="view_model_csv_help">File type CSV is only supported.</div>
                        </div>


                        <div class="grid grid-cols-3 gap-6">
                            <div class="col-span-3 sm:col-span-2">
                                <label for="key" class="block text-sm font-medium text-gray-700">
                                    Enter your password(secret key) to Encrypt the imported data </label>
                                <div class="mt-1  rounded-md shadow-sm">

                                    <input type="text" name="key" id="key"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 @error('key') ring-red-600 border-red-600 @enderror flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                        placeholder="Wow much secret" required>
                                    @error('key')
                                        <small class="text-red-600">{{ $message }}</small>
                                    @enderror
                                    <small class="text-blue-600">Note: Once you change the password the data encrypted
                                        with it wont be accesible , So before changing password make a backup.</small>

                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Import
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>





</x-app-layout>
