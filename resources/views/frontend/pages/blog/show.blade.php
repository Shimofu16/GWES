<x-layouts.app>

    <section class="">
        <div class="container px-5 pb-10 pt-5 mx-auto">
            {{-- <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
                <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-bold text-gray-900 ">Our Blogs</h2>
                <p class="font-light text-gray-500 sm:text-xl">

                </p>
            </div> --}}
            <div class="flex flex-wrap -m-4">
                <article class="bg-white p-4 md:p-8 rounded-lg shadow-md md:mr-4 md:flex-1">
                    <h2 class="text-2xl md:text-3xl font-bold mb-2 md:mb-4">{{ $blog->title }}</h2>
                    <p class="text-gray-600 mb-2">Published on {{ date('M d, Y', strtotime($blog->date)) }}</p>

                    <img src="{{ asset('storage/' . $blog->images) }}" id="blogpostpic" alt="Blog Post Image"
                        class="mb-4 rounded-lg w-full md:h-auto">

                    <p class="mb-2">{{ $blog->description }}</p>
                </article>
            </div>

        </div>
    </section>
</x-layouts.app>
