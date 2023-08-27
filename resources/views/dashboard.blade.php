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
            <div
                class="w-1/5 bg-white border border-gray-200 flex flex-col  rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mx-3 my-3">
                    @if($restaurant?->image?->url)
                    <img class="rounded-t-lg" src="{{$restaurant?->image?->url}}" alt="restaurant image" />

                    @else
                    <img class="rounded-t-lg" src="{{asset('imgs/placeholder.png')}}" alt="" />
                    @endif
                <div class="p-5">
                    <a href="{{route('restaurant.show',[$restaurant])}}">
                        <h5 class="h-16 text-base font-bold tracking-tight text-gray-900 dark:text-white">{{$restaurant->name}}</h5>
                    </a>
                    <div class="">
                        <a href="{{route('restaurant.show',[$restaurant])}}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{__('messages.show_restaurant')}}
                        <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                        </a>
                    </div>

                </div>
            </div>

            @endforeach
        </div>
    </div>

    <x-create-restaurant />
</x-app-layout>
