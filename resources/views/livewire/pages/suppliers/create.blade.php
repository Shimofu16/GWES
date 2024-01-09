<section class="">
    <div class="container px-5 pb-10 pt-5 mx-auto">
        <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
            <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-bold text-gray-900 ">Become a supplier</h2>
            <p class="font-light text-gray-500 sm:text-xl">

            </p>
        </div>
        <div class="flex flex-wrap justify-center -m-4">
            <form wire:submit="save" class="bg-white p-10 shadow-lg">
                @switch($current_step)
                    @case(1)
                        <div class="flex flex-col ">
                            <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Owner Information</h2>
                            <div class="relative mb-4">
                                <label for="owner_name" class="leading-7 text-sm text-gray-600">Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="owner_name" name="owner_name" wire:model='owner_name'
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                <div>
                                    @error('owner_name')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="relative mb-4">
                                <label for="owner_phone" class="leading-7 text-sm text-gray-600">Phone No. <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="owner_phone" name="owner_phone" wire:model='owner_phone'
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                <div>
                                    @error('owner_phone')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="relative mb-4">
                                <label for="owner_email" class="leading-7 text-sm text-gray-600">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" id="owner_email" name="owner_email" wire:model='owner_email'
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                <div>
                                    @error('owner_email')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="relative mb-4">
                                <label for="company_count" class="leading-7 text-sm text-gray-600">Number of Companies <span
                                        class="text-red-500">*</span></label>
                                <input type="number" id="company_count" name="company_count" wire:model='company_count'
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                <div>
                                    @error('company_count')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @break

                    @case(2)
                        <div class="flex flex-col">
                            <div class="flex justify-between items-center">
                                <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Company Information</h2>
                            </div>
                            @for ($i = 0; $i < $company_count; $i++)
                                <div class="flex justify-between">
                                    <div>Company #{{ $i + 1 }}</div>
                                    <div></div>
                                </div>
                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                                    <div class="col-span-2 lg:col-span-4 relative mb-4">
                                        <label for="company_logos" class="leading-7 text-sm text-gray-600">Logo <span
                                                class="text-red-500">*</span></label>
                                        <input
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                            id="company_logos" type="file" name="company_logos"
                                            wire:model='company_logos.{{ $i }}'>

                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_names" class="leading-7 text-sm text-gray-600">Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="company_names" name="company_names"
                                            wire:model='company_names.{{ $i }}'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <div>
                                            @error('company_names')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_phones" class="leading-7 text-sm text-gray-600">Phone no. <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="company_phones" name="company_phones"
                                            wire:model='company_phones.{{ $i }}'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <div>
                                            @error('company_phones')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_addresses" class="leading-7 text-sm text-gray-600">Address <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="company_addresses" name="company_addresses"
                                            wire:model='company_addresses.{{ $i }}'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <div>
                                            @error('company_addresses')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_price_ranges" class="leading-7 text-sm text-gray-600">Price
                                            Range <span class="text-red-500">*</span></label>
                                        <input type="text" id="company_price_ranges" name="company_price_ranges"
                                            wire:model='company_price_ranges.{{ $i }}'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                            placeholder="Ex: 10000 - 20000">
                                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        </p>
                                        <div>
                                            @error('company_price_ranges')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_socials" class="leading-7 text-sm text-gray-600">Socials <span
                                                class="text-red-500">*</span></label>
                                        <textarea id="company_socials" name="company_socials" wire:model='company_socials.{{ $i }}'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                                            rows="3" placeholder="Ex: https://facebook.com, https://instagra.com, https://twitter.com/"></textarea>
                                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            Make sure to add a comma and space after links.
                                        </p>
                                        <div>
                                            @error('company_socials')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_plans" class="leading-7 text-sm text-gray-600">Plan <span
                                                class="text-red-500">*</span></label>
                                        <select id="company_plans" wire:model='company_plans.{{ $i }}'
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                            <option selected>Choose a Plan</option>
                                            @foreach ($plans as $plan)
                                                <option value="{{ $plan->id }}">{{ $plan->name }} -
                                                    {{ $plan->type }}</option>
                                            @endforeach
                                        </select>

                                        <div>
                                            @error('company_plans')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 lg:col-span-4 relative mb-4">
                                        <label for="company_descriptions" class="leading-7 text-sm text-gray-600">Description
                                            <span class="text-red-500">*</span></label>
                                        <textarea id="company_descriptions" name="company_descriptions"
                                            wire:model='company_descriptions.{{ $i }}'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            Write a short description about your company.
                                        </p>
                                        <div>
                                            @error('company_descriptions')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            @endfor
                        </div>
                    @break

                    @case(3)
                        <div class="flex flex-col">
                            <div class="flex justify-between items-center">
                                <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Payment</h2>
                            </div>
                            @for ($i = 0; $i < $company_count; $i++)
                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                                    <div class="col-span-2 relative mb-4">
                                        <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
                                        <input type="text" id="name" name="name"
                                            wire:model='company_names.{{ $i }}'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <div>
                                            @error('title')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                                        <input type="email" id="email" name="email"
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                            @endfor


                        </div>
                    @break

                @endswitch
                <div class="flex justify-between">
                    @if ($current_step == 1)
                        <div></div>
                    @else
                        <button
                            class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                            wire:click.prevent='decreaseStep' wire:loading.class="disabled">
                            Back
                        </button>
                    @endif

                    @if ($current_step != $total_step)
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            wire:click.prevent='increaseStep' wire:loading.class="disabled">
                            Next
                        </button>
                    @else
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            type="submit">
                            Submit
                        </button>
                    @endif
                </div>

            </form>
        </div>
    </div>
</section>
