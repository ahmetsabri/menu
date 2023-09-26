<x-app-layout>
    <div class="flex justify-center p-10">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{route('dashboard')}}"
                        class="inline-flex items-center text-xl font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        {{__('messages.restaurants')}}
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{route('restaurant.show',$restaurant)}}"
                            class="ml-1 text-xl font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            {{$restaurant->name}}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#"
                            class="ml-1 text-xl font-medium text-blue-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            {{$category->name}}
                        </a>
                    </div>
                </li>

            </ol>
        </nav>
    </div>
        <div class="w-full flex justify-center">
        <h1 class="text-5xl font-bold text-indigo-700">
            {{$category->name}}
        </h1>

    </div>
    <div class="w-full mx-24 my-4">

        <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            {{__('messages.create_item')}}
        </button>
    </div>

    <div class="flex flex-wrap justify-center">

        @foreach($category->items as $item)
        <div
            class="w-1/5 bg-white border border-gray-200 flex flex-col  rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mx-3 my-3">
            @if($item->image?->url)
            <img class="rounded-t-lg" src="{{$item?->image?->url}}" alt="restaurant image" />

            @else
            <img class="rounded-t-lg" src="{{asset('imgs/placeholder.png')}}" alt="" />
            @endif
            <x-edit-item id="{{$item->id}}" title="{{$item->title}}" description="{{$item->description}}"
                price="{{$item->price}}" />

            <div class="p-5">
                <a href="#">
                    <h5 class="h-auto text-base font-bold tracking-tight text-gray-900 dark:text-white">{{$item->title}}
                    </h5>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-700">{{$item->description}}</p>
                    <hr class="h-0.5 my-4 bg-gray-200 border-0 dark:bg-gray-700">
                    <h5 class="h-10 text-2xl font-bold tracking-tight text-indigo-700 dark:text-white">{{$item->price}}
                        ₺ </h5>
                </a>
                @if($restaurant->created_by == auth()->id())
                <button data-modal-target="edit-item-modal-{{$item->id}}"
                    data-modal-toggle="edit-item-modal-{{$item->id}}"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    {{__('messages.edit')}}
                </button>

                <button type="button" @click="deleteItem(`{{route('item.destroy',[$restaurant,$category,$item])}}`)"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                    x-data="{
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
                @endif

            </div>
        </div>
        @endforeach
    </div>
    <x-create-item />

</x-app-layout>
