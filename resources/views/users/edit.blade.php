<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick 5-3-1') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-8 py-4">
                    <form class="w-full max-w-sm" method="post" action="{{ route('admin.updateuser',$user->id) }}">
                    @csrf
                        <div class="md:flex md:items-center mb-6">
                          <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                              Userame
                            </label>
                          </div>
                          <div class="md:w-2/3">
                            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="name" name="name" type="text" value="{{ $user->name }}">
                          </div>
                        </div>
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3">
                              <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                                Email
                              </label>
                            </div>
                            <div class="md:w-2/3">
                              <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="name" name="email" type="text" value="{{ $user->email }}">
                            </div>
                          </div>
                          <div class="md:flex md:items-center mb-6">
                          <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-password">
                              Password (Optional, leave empty to keep unchanged)
                            </label>
                          </div>
                          <div class="md:w-2/3">
                            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="password" name="password" type="password">
                          </div>
                        </div>
                        <div class="md:flex md:items-center mb-6">
                          <div class="md:w-1/3"></div>
                          <label class="md:w-2/3 block text-gray-500 font-bold">
                            <input class="mr-2 leading-tight" name="pick531" type="checkbox" {{ $user->pick531 ? 'checked' : '' }}>
                            <span class="text-sm">
                              Pick 5-3-1
                            </span>
                          </label>
                        </div>
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3"></div>
                            <label class="md:w-2/3 block text-gray-500 font-bold">
                              <input class="mr-2 leading-tight" name="pickall" type="checkbox" {{ $user->pickall ? 'checked' : '' }}>
                              <span class="text-sm">
                                Pick All
                              </span>
                            </label>
                          </div>
                          <div class="md:flex md:items-center mb-6">
                          <div class="md:w-1/3"></div>
                          <label class="md:w-2/3 block text-gray-500 font-bold">
                            <input class="mr-2 leading-tight" name="admin" type="checkbox" {{ $user->admin ? 'checked' : '' }}>
                            <span class="text-sm">
                              Admin
                            </span>
                          </label>
                        </div>
                          <div class="md:flex md:items-center">
                          <div class="md:w-1/3"></div>
                          <div class="md:w-2/3">
                            <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-blue-800 font-bold py-2 px-4 rounded" type="submit">
                              Submit
                            </button>
                          </div>
                        </div>
                      </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
