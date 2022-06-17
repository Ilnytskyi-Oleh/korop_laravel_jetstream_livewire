<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('LIstings') }}
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
                                <table class="min-w-full">
                                    <thead class="border-b font-bold ">
                                    <tr>
                                        <th scope="col" class="text-sm  text-gray-900 px-6 py-4 text-left">
                                            Title
                                        </th>
                                        <th scope="col" class="text-sm  text-gray-900 px-6 py-4 text-left">
                                            Description
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
                                                {{$listing->title}}
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                {{Str::words($listing->description, 5)}}
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                ${{$listing->price}}
                                            </td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap flex flex-row gap-x-4">
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
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
