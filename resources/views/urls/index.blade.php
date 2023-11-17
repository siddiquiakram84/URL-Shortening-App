<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl lg:text-4xl font-bold text-white text-center mb-4 font-poppins">Short URL</h1>

        <form method="POST" action="{{ route('urls.store') }}" class="max-w-2xl w-[40rem] mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-md shadow-md custom-shadow-right">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-bold font-poppins text-gray-600">{{ __('Title') }}</label>

                <input type="text" id="title" name="title" required maxlength="255" placeholder="{{ __('Enter a title') }}" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-indigo-300 transition-all duration-300 ease-in-out transform hover:scale-105" value="{{ old('title') }}" />
                <x-input-error :messages="$errors->store->get('title')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="original_url" class="block text-sm font-bold font-poppins text-gray-600">{{ __('Original URL') }}</label>
                <input 
                    type="text" 
                    id="original_url" 
                    name="original_url" 
                    required 
                    maxlength="255" 
                    placeholder="{{ __('Enter the original URL') }}" 
                    class="mt-2 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-indigo-300 transition-all duration-300 ease-in-out transform hover:scale-105" 
                    value="{{ old('original_url') }}" 
                />

                <x-input-error :messages="$errors->store->get('original_url')" class="mt-2" />

                @if($errors->store->has('original_url'))
                    <p class="text-red-500 text-sm mt-2">{{ __('Please enter a valid URL') }}</p>
                @endif

            </div>

            <div class="mt-6">
                <x-primary-button class="transition-all duration-300 ease-in-out transform hover:scale-105">{{ __('Save') }}</x-primary-button>
            </div>
        </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y w-[40rem] overflow-hidden">
            @foreach ($urls as $item)
                @if ($item->user->is(auth()->user()))
                    <div class="p-6 flex space-x-2 transform hover:scale-103 transition-all duration-300 ease-in-out">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        <div class="flex-1 w-[100%]">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center font-serif">
                                    <small class="text-sm text-gray-500 font-poppins float-right mt-2">{{ $item->created_at->format('j M Y, g:i a') }}</small>
                                    @unless ($item->created_at->eq($item->updated_at))
                                    <small class="ml-2 text-sm text-red-500"> &middot; {{ __('edited') }}</small>
                                    @endunless
                                </div>

                                @if ($item->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('urls.edit', $item)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('urls.destroy', $item) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('urls.destroy', $item)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                                @endif
                            </div>

                            <p class="mt-4 text-lg font-bold font-poppins text-gray-900 w-[100%] overflow-auto break-all">{{ __('Title: ') }} {{ $item->title }}</p>
                            <p class="mt-4 text-lg font-bold font-poppins text-gray-900 w-[100%] overflow-auto break-all">
                                {{ __('Destination Url: ') }}
                                <a href="{{$item->original_url}}" class="magical-link hover:underline">
                                    {{$item->original_url}}
                                </a>
                            </p>
                            
                            <p class="mt-4 text-lg font-bold font-poppins text-gray-900 w-[100%] overflow-auto break-all">{{ __('Shorten Url: ') }}
                                <a href="{{ route('shortener-url', $item->shortener_url) }}" target="_blank" class="magical-link hover:underline">
                                    {{ route('shortener-url', $item->shortener_url) }}
                                </a>
                            </p>
                            <style>
                                .magical-link {
                                    position: relative;
                                    color: #3490dc;
                                    text-decoration: none;
                                }
                            </style>

                            <p class="mt-4 text-lg font-bold font-poppins text-gray-900 w-[100%] overflow-auto break-all">
                                {{ __('Analytics Data: ') }}
                                <a href="{{ route('analytics', ['urlId' => $item->id]) }}" target="_blank" class="magical-link hover:underline">
                                    {{ route('analytics', ['urlId' => $item->id]) }}
                                </a>
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
</x-app-layout>