<!-- Main modal -->
<div id="resaturant-qr-{{$id}}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-auto max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="resaturant-qr-{{$id}}">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="py-10 px-10">
                <img
                    src="data:image/png;base64, {!! base64_encode(QrCode::margin(1)->format('png')->size(600)->generate($url)) !!} ">
                <div class="flex justify-center mt-5">
                    <a href="data:image/png;base64, {!! base64_encode(QrCode::margin(1)->format('png')->size(600)->generate($url)) !!}"
                        class="inline-flex items-center justify-center p-5 text-base font-medium text-white rounded-lg bg-indigo-600  hover:bg-indigo-500 dark:bg-indigo-800 dark:hover:bg-indigo-700 dark:hover:text-white"
                        download="qr">
                        <span class="font-bold uppercase">{{__('messages.download')}}</span>
                        <svg class="w-4 h-4 ml-2 rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
