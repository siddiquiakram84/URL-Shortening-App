<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('urls.store') }}" class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-md shadow-md custom-shadow-right">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-600">{{ __('Title') }}</label>
                <input type="text"
                    id="title"
                    name="title"
                    required
                    maxlength="255"
                    placeholder="{{ __('Enter a title') }}"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-indigo-300"
                    value="{{ old('title') }}"
                />
                <x-input-error :messages="$errors->store->get('title')" class="mt-2" />
            </div>
            <div class="mb-4">
                <label for="original_url" class="block text-sm font-medium text-gray-600">{{ __('Original URL') }}</label>
                <input type="text"
                    id="original_url"
                    name="original_url"
                    required
                    maxlength="255"
                    placeholder="{{ __('Enter the original URL') }}"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-indigo-300"
                    value="{{ old('original_url') }}"
                />
                <x-input-error :messages="$errors->store->get('original_url')" class="mt-2" />
            </div>
            <div class="mt-6">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </div>
        </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y w-[40rem]" style="padding: 4px;">
            @foreach ($urls as $item)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1 w-[100%]">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center font-serif">
                                <span class="text-indigo-600 bg-gray-100 px-2 py-1 rounded-sm text-lg">{{ $item->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-500">{{ $item->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($item->created_at->eq($item->updated_at))
                                    <small class="ml-2 text-sm text-red-500"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>

                            @if ($item->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
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
                        <p class="mt-4 text-lg text-gray-900 w-[100%] overflow-auto">{{ __('Title: ') }} {{ $item->title }}</p>
                        <p class="mt-4 text-lg text-gray-900 w-[100%] overflow-auto">{{ __('Target Url: ') }}<a href="{{$item->original_url}}" class="magical-link">{{$item->original_url}}</a></p>

                        <p class="mt-4 text-lg text-gray-900 w-[100%] overflow-auto">{{ __('Short Url: ') }}
                            <a href="{{ route('shortener-url', $item->shortener_url) }}" target="_blank" class="magical-link">
                                {{ route('shortener-url', $item->shortener_url) }}
                            </a>
                        </p>

                        <style>
                            .magical-link {
                                position: relative;
                                color: blue;
                                text-decoration: none;
                            }
                        </style>
                            </a>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>