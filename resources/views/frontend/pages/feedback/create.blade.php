<x-layouts.app>
    <section class="container px-5 py-10 lg:py-24 mx-auto">
        <div class="">
            <div class="flex sm:flex-nowrap flex-wrap">
                <div
                    class="lg:w-2/3 md:w-1/2 bg-gray-300 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative hidden md:block">

                </div>
                <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full  md:mt-0 p-3">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Write feedback</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">Share your thoughts and make your dream wedding come
                        true.</p>
                    @if (Session::has('success'))
                        <p class="text-xs text-green-500 mb-3">{{ Session::get('success') }}</p>
                    @else
                        <p class="text-xs text-red-500 mb-3">{{ Session::get('error') }}</p>
                    @endif
                    <form action="{{ route('feedbacks.store') }}" method="post">
                        @csrf
                        <div class="relative mb-4">
                            <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
                            <input type="text" id="name" name="name"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                            <input type="email" id="email" name="email"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="message" class="leading-7 text-sm text-gray-600">Message <span
                                    class="text-red-500">*</span></label>
                            <textarea id="message" name="context"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        </div>
                        <button
                            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                            type="submit">Submit</button>

                    </form>
                </div>


            </div>

        </div>
    </section>
</x-layouts.app>
