<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('notification.send_telegram') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-sm mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                            <span class="font-medium">{{__('notification.success_alert')}}</span> {{session('success')}}
                        </div>
                    @endif
                    @if(session('failed'))
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">{{__('notification.danger_alert')}}</span> {{session('failed')}}
                        </div>
                    @endif
                    <form class="max-w-sm mx-auto" action="{{route('notification.send.telegram')}}" method="post">
                        @csrf
                        <div class="mb-5">
                        <label for="user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('notification.user')</label>
                            <select id="user" name="user" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach($users as $user)
                                <option {{old('user') == $user->id? 'selected':''}} value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('notification.message_text')</label>
                            <textarea id="message" name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{old('message')}}</textarea>
                        </div>
                        @if($errors->any())
                            <ul>
                                @foreach($errors->all() as $error)
                                    <div class="text-sm mb-2">
                                        <li class="text-red-500">{{$error}}</li>
                                    </div>
                                @endforeach
                            </ul>
                        @endif
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('notification.submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
