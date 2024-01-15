<x-layouts.app>

    <section class="">
        <div class="container px-5 pb-10 pt-5 mx-auto">
            <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
                <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-bold text-gray-900 ">Our Blog</h2>
                <p class="font-light text-gray-500 sm:text-xl">

                </p>
            </div>
            <div class="flex flex-wrap -m-4">
                @foreach ($blogs as $blog)
                    <div class="p-4 md:w-1/3">
                        <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                            <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="/storage/{{ $blog->images }}"
                                alt="blog">
                            <div class="p-6">
                                <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                                    {{ date('M d, Y', strtotime($blog->date)) }}</h2>
                                <h1 class="title-font text-lg font-medium text-gray-900 mb-3">
                                    {{ $blog->title }}</h1>
                                <p class="leading-relaxed mb-3">{{  Str::of($blog->description)->limit(100) }}</p>
                                <div class="flex items-center flex-wrap ">
                                    <a href="{{ route('blogs.show', ['blog_id' => $blog->id]) }}"
                                        class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">See More
                                        <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                {{ $blogs->links() }}
            </div>
        </div>
    </section>
</x-layouts.app>
