<section class="">
    <div class="container pb-10 pt-5 mx-auto">
        <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
            <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-bold text-gray-900 ">Become a Supplier</h2>
            <p class="font-light text-gray-500 sm:text-xl">
                @if (session('success'))
                    <div class="alert alert-success bg-green-400 text-white py-5 ">
                        <strong> {{ session('success') }} </strong>
                    </div>
                @endif
            </p>
        </div>
        <div class="flex flex-wrap px-5">
            <form wire:submit="save" class="bg-white rounded p-5 shadow-lg mx-auto">
                @switch($current_step)
                    @case(1)
                        <div class="flex flex-col ">
                            <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Owner Information</h2>
                            <div class="relative mb-4">
                                <label for="owner_name" class="leading-7 text-sm text-gray-600">Owner Name <span
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
                                <label for="owner_phone" class="leading-7 text-sm text-gray-600">Owner Phone No. <span
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
                                <label for="owner_email" class="leading-7 text-sm text-gray-600">Owner Email <span
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
                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3" wire:key="{{ $i }}">
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_logo_{{ $i }}"
                                            class="leading-7 text-sm text-gray-600">Company Logo <span
                                                class="text-red-500">*</span></label>
                                        <input
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                            id="company_logo_{{ $i }}" type="file"
                                            name="company_logo_{{ $i }}"
                                            wire:model='companies.{{ $i }}.logo'>
                                        <div wire:loading wire:target="companies.{{ $i }}.logo">Uploading...</div>
                                        <div>
                                            @error('companies.*.logo')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_image_{{ $i }}"
                                            class="leading-7 text-sm text-gray-600">Company Image <span
                                                class="text-red-500">*</span></label>
                                        <input
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                            id="company_image_{{ $i }}" type="file"
                                            name="company_image_{{ $i }}"
                                            wire:model='companies.{{ $i }}.image'>
                                        <div wire:loading wire:target="companies.{{ $i }}.image">Uploading...</div>
                                        <div>
                                            @error('companies.*.image')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_name_{{ $i }}"
                                            class="leading-7 text-sm text-gray-600">Company Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="company_name_{{ $i }}"
                                            name="company_name_{{ $i }}"
                                            wire:model='companies.{{ $i }}.name'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <div>
                                            @error('companies.*.name')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_phone_{{ $i }}"
                                            class="leading-7 text-sm text-gray-600">Company Phone no.
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" id="company_phone_{{ $i }}"
                                            name="company_phone_{{ $i }}"
                                            wire:model='companies.{{ $i }}.phone'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <div>
                                            @error('companies.*.phone')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_address_{{ $i }}"
                                            class="leading-7 text-sm text-gray-600">Company Address
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" id="company_address_{{ $i }}"
                                            name="company_address_{{ $i }}"
                                            wire:model='companies.{{ $i }}.address'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <div>
                                            @error('companies.*.address')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_price_ranges" class="leading-7 text-sm text-gray-600">Company
                                            Price
                                            Range <span class="text-red-500">*</span></label>
                                        <div class="flex">
                                            <div>
                                                <label for="company_price_ranges_from_{{ $i }}"
                                                    class="leading-7 text-sm text-gray-600">Minimum</label>
                                                <input type="number" id="company_price_ranges_from_{{ $i }}"
                                                    name="company_price_ranges_from_{{ $i }}"
                                                    wire:model='companies.{{ $i }}.from'
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    placeholder="Ex: 10000">
                                            </div>
                                            <h1 class="mx-3 mt-8 text-xl">
                                                <strong>-</strong>
                                            </h1>
                                            <div>
                                                <label for="company_price_ranges_to_{{ $i }}"
                                                    class="leading-7 text-sm text-gray-600">Maximum</label>
                                                <input type="number" id="company_price_ranges_to_{{ $i }}"
                                                    name="company_price_ranges_to_{{ $i }}"
                                                    wire:model='companies.{{ $i }}.to'
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    placeholder="Ex: 20000">

                                            </div>
                                        </div>
                                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            Enter the minimum and maximum values in the price range fields.
                                        </p>
                                        <div>
                                            @error('companies.*.from')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                            @error('companies.*.to')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <label for="company_plan_{{ $i }}"
                                            class="leading-7 text-sm text-gray-600">Company Plan <span
                                                class="text-red-500">*</span></label>
                                        <select id="company_plan_{{ $i }}"
                                            wire:model='companies.{{ $i }}.plan'
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                            <option selected>Choose a Plan</option>
                                            @foreach ($plans as $key => $plan)
                                                <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                            @endforeach
                                        </select>

                                        <div>
                                            @error('companies.*.plan')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- @if (array_key_exists($i, $selected_plans_array))

                                        <div class="flex">
                                            @foreach ($selected_plans_array[$i] as $selected_plans_array)
                                                {{ $selected_plans_array->name }}
                                            @endforeach
                                        </div>
                                        @endif --}}
                                    </div>
                                    <div class="col-span-2 relative mb-4">
                                        <div class="relative overflow-x-scroll shadow-md sm:rounded-lg">
                                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-3 md:px-5 py-3">
                                                            Plan
                                                        </th>
                                                        <th scope="col" class="px-3 md:px-5 py-3">
                                                            Duration
                                                        </th>
                                                        <th scope="col" class="px-3 md:px-5 py-3">
                                                            No. of Allowed Categories
                                                        </th>

                                                        <th scope="col" class="px-3 md:px-5 py-3">
                                                            Price
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($plans as $plan)
                                                        <tr class="odd:bg-white  even:bg-gray-50  border-b">
                                                            <th scope="row"
                                                                class="px-3 md:px-5 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                                {{ $plan->name }}
                                                            </th>
                                                            <td class="px-3 md:px-5 py-4">
                                                                {{ $plan->duration }}
                                                                @switch($plan->billing_cycle)
                                                                    @case('monthly')
                                                                        {{ 'Month' }}{{ $plan->duration > 1 ? 's' : '' }}
                                                                    @break

                                                                    @case('yearly')
                                                                        {{ 'Year' }}{{ $plan->duration > 1 ? 's' : '' }}
                                                                    @break

                                                                    @case('days')
                                                                        {{ 'Day' }}{{ $plan->duration > 1 ? 's' : '' }}
                                                                    @break
                                                                @endswitch
                                                                
                                                                @if ($plan->type == 'premium a' || $plan->type == 'premium b' || $plan->type == 'premium c')
                                                                    {{ 'With Logo ads' }}
                                                                @endif
                                                            </td>
                                                            <td class="px-3 md:px-5 py-4">
                                                                {{ $plan->categories }}
                                                            </td>
                                                            <td class="px-3 md:px-5 py-4">
                                                                ₱ {{ number_format($plan->price) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-span-2 lg:col-span-4 relative mb-4">
                                        <label for="company_socials_{{ $i }}"
                                            class="leading-7 text-sm text-gray-600">Company Socials
                                            (3)<span class="text-red-500">*</span></label>
                                        <textarea id="company_socials_{{ $i }}" name="company_socials_{{ $i }}"
                                            wire:model='companies.{{ $i }}.socials'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                                            rows="3" placeholder="Ex: https://facebook.com, https://instagra.com, https://twitter.com/"></textarea>
                                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            Please ensure that each link is followed by a comma and a space. Note that a maximum
                                            of 3 social media links will be accepted.
                                        </p>
                                        <div>
                                            @error('companies.*.socials')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-2 lg:col-span-4 relative mb-4">
                                        <label for="company_categories" class="leading-7 text-sm text-gray-600">Company
                                            Categories
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex flex-wrap lg:w-1/2">
                                            @foreach ($categories as $key => $category)
                                                <div class="flex items-center mb-2 me-2">
                                                    <input id="company_categories_{{ $i }}_{{ $key }}"
                                                        type="checkbox" value="{{ $key }}"
                                                        wire:model.prevent='companies.{{ $i }}.categories.{{ $key }}'
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2">
                                                    <label for="company_categories_{{ $i }}_{{ $key }}"
                                                        class="ms-2 text-sm font-medium text-gray-900 ">{{ $category }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            Please note that only the number of categories permitted by the selected plan will
                                            be accepted. Refer to the ‘Plans’ table above for more details.
                                        </p>
                                        <div>
                                            @error('companies.*.categories')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-2 lg:col-span-4 relative mb-4">
                                        <label for="company_description_{{ $i }}"
                                            class="leading-7 text-sm text-gray-600">Company
                                            Description
                                            <span class="text-red-500">*</span></label>
                                        <textarea id="company_description_{{ $i }}" name="company_description_{{ $i }}"
                                            wire:model='companies.{{ $i }}.description'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            Write a short description about your company.
                                        </p>
                                        <div>
                                            @error('companies.*.description')
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
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                                <div class="col-span-2 lg:col-span-4">
                                    <div class="relative overflow-x-scroll shadow-md sm:rounded-lg mb-4">
                                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-3 md:px-5 py-3">
                                                        Plan
                                                    </th>
                                                    <th scope="col" class="px-3 md:px-5 py-3">
                                                        Duration
                                                    </th>
                                                    <th scope="col" class="px-3 md:px-5 py-3">
                                                        No. of Allowed Categories
                                                    </th>

                                                    <th scope="col" class="px-3 md:px-5 py-3">
                                                        Price
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($selected_plans as $selected_plan)
                                                    <tr class="odd:bg-white  even:bg-gray-50  border-b">
                                                        <th scope="row"
                                                            class="px-3 md:px-5 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                            {{ $selected_plan->name }}
                                                        </th>
                                                        <td class="px-3 md:px-5 py-4">
                                                            {{ $selected_plan->duration }}
                                                            @switch($selected_plan->billing_cycle)
                                                                @case('monthly')
                                                                    {{ 'Month' }}
                                                                @break

                                                                @case('yearly')
                                                                    {{ 'Year' }}
                                                                @break

                                                                @case('days')
                                                                    {{ 'Day' }}
                                                                @break
                                                            @endswitch
                                                            {{ $selected_plan->duration > 1 ? 's' : '' }}
                                                            @if ($selected_plan->type == 'premium a' || $selected_plan->type == 'premium b' || $selected_plan->type == 'premium c')
                                                                {{ 'With Logo ads' }}
                                                            @endif
                                                        </td>
                                                        <td class="px-3 md:px-5 py-4">
                                                            {{ $selected_plan->categories }}
                                                        </td>
                                                        <td class="px-3 md:px-5 py-4">
                                                            ₱ {{ number_format($selected_plan->price) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if ($redeemed_coupon)
                                                    <tr class="">
                                                        <td class="py-4 px-3">
                                                            <strong>Discount</strong>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="py-4 px-3">
                                                            @if ($redeemed_coupon->discount_type == 'fixed_amount')
                                                                <strong>₱
                                                                    {{ number_format($redeemed_coupon->discount_value) }}</strong>
                                                            @endif
                                                            @if ($redeemed_coupon->discount_type == 'free_subscription')
                                                                <strong>Free {{ $redeemed_coupon->subscription_duration }}
                                                                    Month{{ $redeemed_coupon->subscription_duration > 1 ? 's' : '' }}</strong>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr class="">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="py-4 px-3">
                                                        <strong>Total: ₱ {{ number_format($selected_plan_sum) }}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-span-2 lg:col-span-4 mb-4">
                                    <div class="flex  justify-between flex-wrap">
                                        <img src="{{ asset('assets/images/gwd-gcash.jpg') }}" alt="G-Cash"
                                            class="h-[300px] rounded mb-3 sm:mb-0">
                                        <div class="text sm:ms-3">
                                            <div class="mb-4">
                                                <h2 class="text-gray-700 font-bold mb-2">Thank you for choosing our
                                                    services/products.
                                                </h2>
                                                <p>To expedite the confirmation of your payment, kindly follow the instructions
                                                    below:
                                                </p>
                                            </div>
                                            <ol class="list-decimal list-inside">
                                                <li>Initiate a money transfer to the following account: <strong>(0966) 790
                                                        2816</strong></li>
                                                <li>Once the transfer is completed, please take a screenshot of the transaction
                                                    confirmation.</li>
                                                <li>Upload the screenshot as proof of payment</li>
                                            </ol>
                                            <p class="mt-4">Your prompt attention to this matter is greatly appreciated, and
                                                it will
                                                help us ensure the timely processing of your service.</p>
                                            <p class="mt-2">If you encounter any issues or have questions, feel free to reach
                                                out to
                                                our customer support.</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-span-2  relative mb-4">
                                    <label for="proof_of_payment" class="leading-7 text-sm text-gray-600">Company Proof of
                                        Payment<span class="text-red-500">*</span></label>
                                    <input
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                        id="proof_of_payment" type="file" name="proof_of_payment"
                                        wire:model='proof_of_payment'>
                                    <div wire:loading wire:target="proof_of_payment">Uploading...</div>
                                    <div>
                                        @error('proof_of_payment')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-2 relative mb-4">
                                    <label for="coupon" class="leading-7 text-sm text-gray-600">Company Coupon</label>
                                    <div class="flex">
                                        <input type="text" id="coupon" name="coupon" wire:model='coupon'
                                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <button
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ms-2"
                                            wire:click.prevent='claimCoupon' wire:loading.class='disabled'>
                                            Claim
                                        </button>
                                    </div>
                                    <div>
                                        @error('coupon')
                                            <span class="text-green-500">{{ $message }}</span>
                                        @enderror
                                        @error('invalid_coupon')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @break

                @endswitch
                <div class="flex justify-between">
                    @if ($current_step == 1)
                        <div></div>
                    @else
                        <button
                            class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                            wire:click.prevent='decreaseStep' wire:loading.class='disabled'>
                            Back
                        </button>
                    @endif

                    @if ($current_step != $total_step)
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            wire:click.prevent='increaseStep' wire:loading.class='disabled'>
                            Next
                        </button>
                    @else
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            type="submit" wire:loading.class='disabled' wire:target="proof_of_payment">
                            Submit
                        </button>
                    @endif
                </div>

            </form>
        </div>
    </div>
</section>
