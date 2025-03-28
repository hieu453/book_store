<template>
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-8">
        <Head title="Checkout" />
        <Toast />
        <form class="mx-auto max-w-screen-xl px-4 2xl:px-0" @submit.prevent="processToPayment">
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
                                    v-model="form.fullname"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Bonnie Green" />
                                <span v-if="errors.fullname" class="text-red-600">{{ errors.fullname }}</span>
                            </div>

                            <div>
                                <label for="your_email"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Your email*
                                </label>
                                <input type="email" id="your_email"
                                    v-model="form.email"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="name@flowbite.com" />
                                <span v-if="errors.email" class="text-red-600">{{ errors.email }}</span>
                            </div>

                            <div>
                                <div class="mb-2 flex items-center gap-2">
                                    <label for="select-city-input-3"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"> City*
                                    </label>
                                </div>
                                <select id="select-city-input-3"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    v-model="form.city"
                                    @change="form.district = ''; form.ward = ''"
                                >
                                    <option value="">Please select city</option>
                                    <option
                                        v-for="city in provinces"
                                        :key="city.code"
                                        :value="city.name"
                                    >
                                        {{ city.name }}
                                    </option>
                                </select>
                                <span v-if="errors.city" class="text-red-600">{{ errors.city }}</span>
                            </div>

                            <div>
                                <div class="mb-2 flex items-center gap-2">
                                    <label for="select-district-input-3"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"> District* </label>
                                </div>
                                <select id="select-district-input-3"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    v-model="form.district"
                                    @change="form.ward = ''"
                                >
                                    <option value="">Please select district</option>
                                    <template v-if="city">
                                        <option
                                            v-for="district in city.districts"
                                            :key="district.code"
                                            :value="district.name"
                                        >
                                            {{ district.name }}
                                        </option>
                                    </template>
                                </select>
                                <span v-if="errors.district" class="text-red-600">{{ errors.district }}</span>
                            </div>

                            <div>
                                <div class="mb-2 flex items-center gap-2">
                                    <label for="select-ward-input-3"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"> Ward* </label>
                                </div>
                                <select id="select-ward-input-3"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    v-model="form.ward"
                                >
                                    <option value="">Please select ward</option>
                                    <template v-if="district">
                                        <option
                                            v-for="ward in district.wards"
                                            :key="ward.code"
                                            :value="ward.name"
                                        >
                                            {{ ward.name }}
                                        </option>
                                    </template>
                                </select>
                                <span v-if="errors.ward" class="text-red-600">{{ errors.ward }}</span>
                            </div>

                            <div>
                                <label for="phone_number"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Phone number
                                </label>
                                <input type="text" id="phone_number"
                                    v-model="form.phone_number"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Enter your phone number" />
                                <span v-if="errors.phone_number" class="text-red-600">{{ errors.phone_number }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Payment</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input
                                            v-model="form.paymentMethod"
                                            aria-describedby="pay-on-delivery-text"
                                            type="radio"
                                            value="cod"
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
                            </div>

                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input
                                            v-model="form.paymentMethod"
                                            aria-describedby="paypal-text"
                                            type="radio"
                                            value="online"
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
                        <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-purple-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-purple-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Proceed to Payment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { useToast, Toast } from 'primevue';
import { computed, onMounted, reactive, ref } from 'vue';

const props = defineProps({
    checkedItems: Array,
    provinces: Array,
    errors: Object,
})
const form = reactive({
    fullname: null,
    email: null,
    phone_number: null,
    city: "",
    district: "",
    ward: "",
    paymentMethod: 'cod'
})
console.log(props.errors.ward)
const addMoreFee = ref(false);

const city = computed(() => props.provinces.find(province => province.name == form.city))
const district = computed(() => city.value ? city.value.districts.find(district => district.name == form.district) : null)

const toast = useToast();

const totalPrice = computed(() => {
    return props.checkedItems.reduce((totalPrice, item) => {
        return totalPrice + (item['product']['price'] * item['quantity'])
    }, 0)
})

const fee = computed(() => {
    addMoreFee.value = form.paymentMethod == "cod" ? true : false;

    return addMoreFee.value ? 15 : 0;
})

const totalCheckoutPrice = computed(() => {
    return totalPrice.value + fee.value
})

function processToPayment() {
    if (form.paymentMethod == 'online') {
        router.post(route('payment.online'), form, {
            preserveState: true,
            onSuccess: (page) => {
                if (page.props.flash.payment_status) {
                    toast.add({ severity: 'info', summary: page.props.flash.payment_status, life: 4000 });
                }

                if (page.props.flash.update_quantity_error) {
                    toast.add({ severity: 'error', summary: page.props.flash.update_quantity_error, life: 4000 });
                }
            }
        })
    } else {
        console.log(form)
        router.post(route('payment.online'), form, {
            preserveState: true,
            onSuccess: (page) => {
                if (page.props.flash.payment_status) {
                    toast.add({ severity: 'info', summary: page.props.flash.payment_status, life: 4000 });
                }

                if (page.props.flash.update_quantity_error) {
                    toast.add({ severity: 'error', summary: page.props.flash.update_quantity_error, life: 4000 });
                }
            }
        })
    }
}
</script>
