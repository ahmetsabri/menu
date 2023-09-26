<x-app-layout>
    <div class="p-10">
        <div class="flex flex-wrap justify-center">
            <div class="w-full mb-5">
                <h1 class="text-5xl text-center font-bold">
                    {{__('messages.restaurants')}}
                </h1>
            </div>
            <div class="w-full mx-24 my-4">

              <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
  {{__('messages.create_restaurant')}}
</button>


            </div>
        @foreach($user->restaurants as $restaurant)
            <div class="w-1/5 bg-white border border-gray-200 flex flex-col  rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mx-3 my-3">
                    @if($restaurant?->image?->url)
                    <img class="rounded-t-lg" src="{{$restaurant?->image?->url}}" alt="restaurant image" />

                    @else
                    <img class="rounded-t-lg" src="{{asset('imgs/placeholder.png')}}" alt="" />
                    @endif
                <div class="p-5">
                    <a href="{{route('restaurant.show',[$restaurant])}}">
                        <h5 class="h-16 text-base font-bold tracking-tight text-gray-900 dark:text-white">{{$restaurant->name}}</h5>
                    </a>
                    <div class="flex justify-center space-x-3">
                        <a href="{{route('restaurant.show',[$restaurant])}}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{__('messages.show')}}
                        </a>
                        <button data-modal-target="resaturant-qr-{{$restaurant->id}}" data-modal-toggle="resaturant-qr-{{$restaurant->id}}" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"></path>

        </svg>
          <span class="sr-only">Icon description</span>
        </button>
                     <x-edit-restaurant name="{{$restaurant->name}}" restaurant="{{$restaurant->id}}"/>
                           <button
                           data-modal-target="edit-restaurant-modal-{{$restaurant->id}}" data-modal-toggle="edit-restaurant-modal-{{$restaurant->id}}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        {{__('messages.edit')}}
                        </button>

                          <button type="button" @click="deleteItem(`{{route('restaurant.destroy',[$restaurant])}}`)" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" x-data="{
                                deleteItem(url) {
                                let sure = window.confirm('{{__('messages.are_you_sure')}}')
                                if(!sure) return

                                axios.delete(url)
                                    .then(() => {
                                        window.location.reload()
                                    });
                                }
                                }">
                                    {{__('messages.delete')}}
                </button>
                <x-show-restaurant-qr-code  url="{{route('restaurant.show',[$restaurant])}}" id="{{$restaurant->id}}"/>



                    </div>

                </div>
            </div>

            @endforeach
        </div>
    </div>
    <x-create-restaurant />
</x-app-layout>
