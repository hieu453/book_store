<template>
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-8">
        <Head title="Checkout" />
        <Toast />
        <form class="mx-auto max-w-screen-xl px-4 2xl:px-0" @submit.prevent="processToPayment">
            <div class="lg:flex lg:items-start lg:gap-12 xl:gap-16">
                <div class="min-w-0 flex-1 space-y-8">
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Thông tin chi tiết</h2>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="your_name"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Tên của bạn
                                </label>
                                <input type="text" id="your_name"
                                    v-model="form.name"
                                    class="block w-full rounded-lg border focus:border-none focus:ring-0 border-none bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400"
                                    placeholder="Bonnie Green" readonly />
                                <span v-if="errors.name" class="text-red-600">{{ errors.name }}</span>
                            </div>

                            <div>
                                <label for="your_email"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Email
                                </label>
                                <input type="email" id="your_email"
                                    v-model="form.email"
                                    class="block w-full rounded-lg border focus:border-none focus:ring-0 border-none bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400"
                                    placeholder="name@flowbite.com" readonly />
                                <span v-if="errors.email" class="text-red-600">{{ errors.email }}</span>
                            </div>

                            <div>
                                <div class="mb-2 flex items-center gap-2">
                                    <label for="select-city-input-3"
                                        class="block text-sm font-medium text-gray-900 dark:text-white"> Thành phố
                                    </label>
                                </div>
                                <select id="select-city-input-3"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    v-model="form.city"
                                    @change="form.district = ''; form.ward = ''"
                                >
                                    <option value="">Chọn thành phố</option>
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
                                        class="block text-sm font-medium text-gray-900 dark:text-white"> Quận/Huyện </label>
                                </div>
                                <select id="select-district-input-3"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    v-model="form.district"
                                    @change="form.ward = ''"
                                >
                                    <option value="">Chọn quận/huyện</option>
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
                                        class="block text-sm font-medium text-gray-900 dark:text-white"> Phường/Xã </label>
                                </div>
                                <select id="select-ward-input-3"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    v-model="form.ward"
                                >
                                    <option value="">Chọn phường/xã</option>
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
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Số điện thoại
                                </label>
                                <input type="text" id="phone_number"
                                    v-model="form.phone_number"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Số điện thoại của bạn" />
                                <span v-if="errors.phone_number" class="text-red-600">{{ errors.phone_number }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Phương thức thanh toán</h3>
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
                                            Cash on delivery
                                        </label>
                                        <p id="pay-on-delivery-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">
                                            +15.000đ phí
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
                                            aria-describedby="momo-text"
                                            type="radio"
                                            value="online"
                                            class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />
                                    </div>

                                    <div class="ms-4 text-sm">
                                        <label for="momo-2" class="font-medium leading-none text-gray-900 dark:text-white">
                                            Online (Momo)
                                        </label>
                                        <p id="momo-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">
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
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Giá sản phẩm</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">{{ totalPrice.toFixed(2) }}đ</dd>
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
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Phí</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">{{ fee }}đ</dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4 py-3">
                                <dt class="text-base font-bold text-gray-900 dark:text-white">Tổng tiền phải thanh toán</dt>
                                <dd class="text-base font-bold text-gray-900 dark:text-white">{{ totalCheckoutPrice.toFixed(2) }}đ</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-purple-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-purple-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Thanh toán
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import { useToast, Toast } from 'primevue';
import { computed, onMounted, reactive, ref } from 'vue';

const props = defineProps({
    checkedItems: Array,
    provinces: Array,
    errors: Object,
})

const page = usePage()
const user = computed(() => page.props.auth.user)
const toast = useToast();

const form = reactive({
    name: user.value.name,
    email: user.value.email,
    phone_number: null,
    city: "",
    district: "",
    ward: "",
    paymentMethod: 'cod',
})

const city = computed(() => props.provinces.find(province => province.name == form.city))
const district = computed(() => city.value ? city.value.districts.find(district => district.name == form.district) : null)

const addMoreFee = ref(false);
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

onMounted(() => {
    router.reload({ only: ['checkedItems'] })
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
        router.post(route('payment.cod'), form, {
            preserveState: true,
            onSuccess: (page) => {
                if (page.props.flash.update_quantity_error) {
                    toast.add({ severity: 'error', summary: page.props.flash.update_quantity_error, life: 4000 });
                }
            }
        })
    }
}
</script>
