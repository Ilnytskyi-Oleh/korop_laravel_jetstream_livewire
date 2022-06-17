<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listing edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-2 flex">
                <a href="{{route('listings.create')}}" class="ml-auto">
                    <x-jet-button class="mt-2 mr-2 " type="button" >
                        {{ __('Add a listing') }}
                    </x-jet-button>
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-4 px-2">
            <x-jet-validation-errors></x-jet-validation-errors>
                <div class="w-1/2 ">
                    <form method="POST" action="{{ route('listings.update', $listing) }}">
                        @method('PUT')
                        @csrf
                        <div>
                            <x-jet-label for="title" value="{{ __('Title') }}" />
                            <x-jet-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title') ?? $listing->title"    />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="price" value="{{ __('Price') }}" />
                            <x-jet-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price') ?? $listing->price"  />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="description"   >{{ old('description') ?? $listing->description}}</textarea>
                        </div>

                        <div class="flex items-center mt-4">
                            <x-jet-button >
                                {{ __('Update') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
