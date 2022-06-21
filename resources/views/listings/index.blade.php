<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listings') }}
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

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">

                            <div class="overflow-hidden">
                                <div class="my-5 px-6 py-4">
                                    @if(session('message'))
                                        <div class="mb-6 py-4 bg-green-100 text-center font-semibold rounded rounded-md border-2 border-green-200">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                    <form action="" method="GET">
                                        <input type="text" name="title" placeholder="Title" value="{{ request('title') ?? '' }}"/>
                                        <select name="category" id="">
                                            <option value="">-- category --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                @if(request('category') == $category->id)
                                                    selected
                                                @endif
                                                >{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="size" id="">
                                            <option value="">-- size --</option>
                                            @foreach($sizes as $item)
                                                <option value="{{ $item->id }}"
                                                    @if(request('size') == $item->id)
                                                        selected
                                                    @endif
                                                >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="color" id="">
                                            <option value="">-- color --</option>
                                            @foreach($colors as $item)
                                                <option value="{{ $item->id }}"
                                                    @if(request('color') == $item->id)
                                                        selected
                                                    @endif
                                                >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="city" id="">
                                            <option value="">-- city --</option>
                                            @foreach($cities as $item)
                                                <option value="{{ $item->id }}"
                                                    @if(request('city') == $item->id)
                                                        selected
                                                    @endif
                                                >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
{{--                                        <span class="ml-4 mr-4">--}}
{{--                                             <input type="checkbox" name="saved"> Saved(0)--}}
{{--                                        </span>--}}
                                        @livewire('listing-saved-checkbox')
                                        <x-jet-button class="mt-2 mr-2 " type="submit" >
                                            {{ __('Search') }}
                                        </x-jet-button>
                                    </form>
                                </div>
                                <table class="min-w-full">
                                    <thead class="border-b font-bold ">
                                    <tr>
                                        <th scope="col" class="text-sm  text-gray-900 px-6 py-4 text-left">
                                            Photo
                                        </th>
                                        <th scope="col" class="text-sm  text-gray-900 px-6 py-4 text-left">
                                            Title
                                        </th>
                                        <th scope="col" class="text-sm  text-gray-900 px-6 py-4 text-left">
                                            Description
                                        </th>
                                        <th scope="col" class="text-sm  text-gray-900 px-6 py-4 text-left">
                                            Categories
                                        </th>
                                        <th scope="col" class="text-sm  text-gray-900 px-6 py-4 text-left">
                                            City
                                        </th>
                                        <th scope="col" class="text-sm  text-gray-900 px-6 py-4 text-left">
                                            Price
                                        </th>
                                        <th scope="col" class="text-sm  text-gray-900 px-6 py-4 text-left">
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listings as $listing)
                                        <tr class="border-b">
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                <img src="{{$listing->getFirstMediaUrl('listings', 'thumb')}}" alt="">

                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{$listing->title}}
                                                <div>
                                                    <a href="{{ route('messages.create') }}?listing_id={{$listing->id}}" class="underline">Send a message</a>
                                                </div>
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{Str::words($listing->description, 5)}}
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                <ul>
                                                @foreach($listing?->categories as $category)
                                                    <li>{{$category->name}}</li>
                                                @endforeach
                                                </ul>
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{ $listing->user->city->name ?? '' }}
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                ${{$listing->price}}
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap flex flex-row gap-x-4">
                                                @if($listing->user?->id !== auth()->id())
                                                    @livewire('listing-save-button', ['listingId' => $listing->id])
                                                @endif
                                                @can('update', $listing)
                                                    <a href="{{route('listings.edit', $listing)}}">Edit</a>
                                                @endcan
                                                @can('delete', $listing)
                                                    <form action="{{ route('listings.destroy', $listing) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" onclick="return confirm('Точно?!');" class="cursor-pointer text-red-500" value="Delete">
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <div class="px-4 py-3">
                                    {{ $listings->links() }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
