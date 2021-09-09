<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Export Your Secrets as CSV') }}
        </h2>
    </x-slot>


        <div class="p-9">

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{route("exportascsv")}}" method="POST">
                    @csrf
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">



                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="secret" class="block text-sm font-medium text-gray-700">
                                      Enter your password(secret key) to Export as CSV
                                    </label>
                                    <div class="mt-1  rounded-md shadow-sm">

                                        <input type="text" name="key" id="key"
                                            class="focus:ring-indigo-500 focus:border-indigo-500 @error('key') ring-red-600 border-red-600 @enderror flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300"
                                            placeholder="Wow much secret" required>
                                            @error('key')
                                        <small class="text-red-600">{{$message}}</small>
                                        @enderror
                                            <small class="text-blue-600">Note: Once you change the password the data encrypted with it wont be accesible , So before changing password make a backup.</small>

                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>





</x-app-layout>
