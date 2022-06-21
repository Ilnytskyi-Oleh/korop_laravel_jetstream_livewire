<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send a message') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">

                                <div class="w-1/2 px-4 pb-3">
                                    <form method="POST" action="{{ route('messages.store') }}">
                                        @csrf
                                        <input type="hidden" value="{{ request('listing_id') }}" name="listing_id">
                                        <div class="mt-4">
                                            <x-jet-label for="message" value="{{ __('Message') }}" />
                                            <textarea id="message" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="message"  required >{{ old('message') }}</textarea>
                                        </div>

                                        <div class="flex items-center mt-4">
                                            <x-jet-button >
                                                {{ __('Send a message') }}
                                            </x-jet-button>
                                        </div>
                                    </form>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
