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
                    <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data">
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

                        <div class="mt-4">
                            <x-jet-label for="photo1" value="{{ __('Photo 1') }}" />
                            @if(isset($media[0]))
                                <img src="{{ $media[0]->getUrl('thumb') }}" alt="">
                                <a href="{{ route('listing.delete-photo', [$listing->id, $media[0]->id]) }}"
                                onclick="return confirm('Точно?!')"
                                >Delete Photo</a>
                            @endif
                            <x-jet-input id="photo1" class="block mt-1 w-full" type="file" name="photo1"   />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="photo2" value="{{ __('Photo 2') }}" />
                            @if(isset($media[1]))
                                <img src="{{ $media[1]->getUrl('thumb') }}" alt="">
                                <a href="{{ route('listing.delete-photo', [$listing->id, $media[1]->id]) }}"
                                   onclick="return confirm('Точно?!')"
                                >Delete Photo</a>
                            @endif
                            <x-jet-input id="photo2" class="block mt-1 w-full" type="file" name="photo2"   />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="photo3" value="{{ __('Photo 3') }}" />
                            @if(isset($media[2]))
                                <img src="{{ $media[2]->getUrl('thumb') }}" alt="">
                                <a href="{{ route('listing.delete-photo', [$listing->id, $media[2]->id]) }}"
                                   onclick="return confirm('Точно?!')"
                                >Delete Photo</a>
                            @endif
                            <x-jet-input id="photo3" class="block mt-1 w-full" type="file" name="photo3"   />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="categories" value="{{ __('Categories') }}" />
                            <div class="flex flex-row gap-x-4">
                                @foreach($categories as $category)
                                    <label for="checkbox_{{$category->id}}">
                                        <input type="checkbox"
                                               id="checkbox_{{$category->id}}"
                                               value="{{ $category->id }}"
                                               name="categories[]"
                                        @if(in_array($category->id, $listing->categories()->pluck('id')->toArray())) checked @endif
                                        > {{$category->name}}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="categories" value="{{ __('Colors') }}" />
                            <div class="flex flex-row gap-x-4">
                                @foreach($colors as $color)
                                    <label for="checkbox_{{$color->id}}_colors">
                                        <input type="checkbox" id="checkbox_{{$color->id}}_colors"
                                               value="{{ $color->id }}" name="colors[]"
                                               @if(in_array($color->id, $listing->colors()->pluck('id')->toArray())) checked @endif
                                        > {{$color->name}}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="categories" value="{{ __('Sizes') }}" />
                            <div class="flex flex-row gap-x-4">
                                @foreach($sizes as $size)
                                    <label for="checkbox_{{$size->id}}_sizes">
                                        <input type="checkbox" id="checkbox_{{$size->id}}_sizes"
                                               value="{{ $size->id }}" name="sizes[]"
                                               @if(in_array($size->id, $listing->sizes()->pluck('id')->toArray())) checked @endif
                                        > {{$size->name}}
                                    </label>
                                @endforeach
                            </div>
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
