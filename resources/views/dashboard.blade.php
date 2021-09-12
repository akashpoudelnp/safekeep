<x-app-layout>

    <div class="min-h-screen bg-blue-400 flex justify-center items-center">
        {{-- <div class="absolute w-60 h-60 rounded-xl bg-purple-300 -top-5 -left-16 z-0 transform rotate-45 hidden md:block">
        </div> --}}
        {{-- <div class="absolute w-48 h-48 rounded-xl bg-blue-300 -bottom-5 -right-6 transform rotate-12 hidden md:block">
        </div> --}}
        <div class="py-12 px-12 bg-white rounded-2xl shadow-xl z-20">
            <div>
                <h1 class="text-3xl font-bold text-center mb-4 cursor-pointer">Hi {{Auth()->user()->name}}</h1>
                <p class="w-80 text-center text-sm mb-8 font-semibold text-gray-700 tracking-wide cursor-pointer">Enter your secret key to decrypt your secrets!</p>
            </div>
            <div class="space-y-4">
                <form action="{{route("showall")}}" method="POST">
                @csrf
                <input type="text" placeholder="Secret" name="key" class="block text-sm py-3 px-4 rounded-lg w-full @error('title') ring-red-600 border-red-600 @enderror   border outline-none" />
                @error('key')
                <small class="text-red-600">{{$message}}</small>
                @enderror
                @if($errors->any())
                    <small class="text-red-600">{{$errors->first()}}</small>
                @endif
        </div>
                <div class="text-center mt-6">
                    <button type="submit" class="py-3 w-64 text-xl text-white bg-blue-400 rounded-2xl">Decrypt</button>

                </form>
                </div>
                <div class="text-center mt-6">
                    <a href="{{ url('word/create') }}"
                    class="py-4 px-2 text-xl text-white bg-green-400 rounded-2xl  ">Add New Secret</a>
                </div>
                <div class="text-center mt-6">
                   <small class="text-gray-400">&copy; Aakash</small>
                </div>
            </div>
            <div
                class="w-20 h-40 absolute bg-blue-300 rounded-full bottom-20 left-10 transform rotate-45 hidden md:block">
            </div>

        </div>
</x-app-layout>
