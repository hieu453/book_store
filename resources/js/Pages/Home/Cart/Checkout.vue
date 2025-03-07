<template>
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-8">
        <Head title="Checkout" />
        <form class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="lg:flex lg:items-start lg:gap-12 xl:gap-16">
                <div class="min-w-0 flex-1 space-y-8">
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Delivery Details</h2>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="your_name"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Your name
                                </label>
                                <input type="text" id="your_name"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Bonnie Green" required />
                            </div>

                            <div>
                                <label for="your_email"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Your email*
                                </label>
                                <input type="email" id="your_email"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="name@flowbite.com" required />
                            </div>

                            <div>
                                <div class="mb-2 flex items-center gap-2">
                                    <label for="select-country-input-3"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"> Country*
                                    </label>
                                </div>
                                <select id="select-country-input-3"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                    <option selected>United States</option>
                                    <option value="AS">Australia</option>
                                    <option value="FR">France</option>
                                    <option value="ES">Spain</option>
                                    <option value="UK">United Kingdom</option>
                                </select>
                            </div>

                            <div>
                                <div class="mb-2 flex items-center gap-2">
                                    <label for="select-city-input-3"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"> City* </label>
                                </div>
                                <select id="select-city-input-3"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                    <option selected>San Francisco</option>
                                    <option value="NY">New York</option>
                                    <option value="LA">Los Angeles</option>
                                    <option value="CH">Chicago</option>
                                    <option value="HU">Houston</option>
                                </select>
                            </div>

                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    Email </label>
                                <input type="email" id="email"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="name@flowbite.com" required />
                            </div>

                            <div>
                                <label for="company_name"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Company name
                                </label>
                                <input type="text" id="company_name"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Flowbite LLC" required />
                            </div>

                            <div>
                                <label for="vat_number"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> VAT number
                                </label>
                                <input type="text" id="vat_number"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="DE42313253" required />
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Payment</h3>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input id="pay-on-delivery" aria-describedby="pay-on-delivery-text" type="radio"
                                            name="payment-method" value="delivery"
                                            class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />
                                    </div>

                                    <div class="ms-4 text-sm">
                                        <label for="pay-on-delivery" class="font-medium leading-none text-gray-900 dark:text-white">
                                            Payment on delivery
                                        </label>
                                        <p id="pay-on-delivery-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">
                                            +$15 payment processing fee
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center gap-2">
                                    <button type="button"
                                        class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Delete</button>

                                    <div class="h-3 w-px shrink-0 bg-gray-200 dark:bg-gray-700"></div>

                                    <button type="button"
                                        class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Edit</button>
                                </div>
                            </div>

                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input id="paypal-2" aria-describedby="paypal-text" type="radio"
                                            name="payment-method" value=""
                                            class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />
                                    </div>

                                    <div class="ms-4 text-sm">
                                        <label for="paypal-2" class="font-medium leading-none text-gray-900 dark:text-white">
                                            Paypal account
                                        </label>
                                        <p id="paypal-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">
                                            Connect to your account
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center gap-2">
                                    <button type="button"
                                        class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Delete</button>

                                    <div class="h-3 w-px shrink-0 bg-gray-200 dark:bg-gray-700"></div>

                                    <button type="button"
                                        class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
                    <div class="flow-root">
                        <div class="my-3 divide-y divide-gray-200 dark:divide-gray-800">
                            <dl class="flex items-center justify-between gap-4 py-3">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Subtotal</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">${{ totalPrice.toFixed(2) }}</dd>
                            </dl>

                            <!-- <dl class="flex items-center justify-between gap-4 py-3">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Savings</dt>
                                <dd class="text-base font-medium text-green-500">0</dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4 py-3">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Store Pickup</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">$99</dd>
                            </dl> -->

                            <dl class="flex items-center justify-between gap-4 py-3">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Fee</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">${{ fee }}</dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4 py-3">
                                <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                <dd class="text-base font-bold text-gray-900 dark:text-white">${{ totalCheckoutPrice.toFixed(2) }}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button @click="processToPayment" type="submit" class="flex w-full items-center justify-center rounded-lg bg-purple-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-purple-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Proceed to Payment
                        </button>
                        <!-- <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-purple-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-purple-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Proceed to Payment
                        </button> -->
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { computed, onMounted, ref, useTemplateRef } from 'vue';

const props = defineProps({
    cart: {
        type: Object,
    },
    checkedItems: {
        type: Array,
    }
})

const addMoreFee = ref(false);

const totalPrice = computed(() => {
    return props.checkedItems.reduce((totalPrice, item) => {
        return totalPrice + (item['product']['price'] * item['quantity'])
    }, 0)
})

const fee = computed(() => {
    return addMoreFee.value ? 15 : 0;
})

const totalCheckoutPrice = computed(() => {
    return totalPrice.value + fee.value
})

onMounted(() => {
    const paymentMethod = document.querySelectorAll("input[name='payment-method']")
    paymentMethod.forEach((el) => {
        el.onchange = function (e) {
            this.value == 'delivery' ? addMoreFee.value = true : addMoreFee.value = false;
        }
    })

})

function processToPayment() {
    router.post(route('payment'))
}
</script>
