<template>
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-8">
        <Head title="Giỏ hàng" />
        <Toast />
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Giỏ hàng</h2>

            <WhenVisible data="cartItems">
                <template #fallback>
                    <div>Đang tải...</div>
                </template>
                <template v-if="cart.length > 0">
                    <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                        <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                            <div class="space-y-6">
                                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:py-3 md:px-6 mb-3">
                                    <div class="space-y-4 flex items-center justify-between gap-6">
                                        <input type="checkbox" :checked="isCheckAll" @change="checkAll">
                                        <!-- <span><button @click="deleteBatch">Delete</button></span> -->
                                        <span><button @click="removeItems(checkedItems)">Xóa</button></span>
                                    </div>
                                </div>
                            </div>
                            <div v-for="(item, index ) in cart" class="space-y-6">
                                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                                    <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                        <span>
                                            <input
                                                type="checkbox"
                                                :checked="item.checked"
                                                @change="checkItem(index)"
                                            >
                                        </span>
                                        <a href="#" class="shrink-0 md:order-1">
                                            <!-- Light -->
                                            <img v-if="item.product.images.length > 0" class="h-20 w-20 dark:hidden rounded-md"
                                                :src="item.product.images[0].url"
                                                alt="imac image" />
                                            <img v-else class="h-20 w-20 dark:hidden"
                                                src=""
                                                alt="imac image" />


                                            <!-- Dark -->
                                            <img class="hidden h-20 w-20 dark:block"
                                                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/apple-watch-dark.svg"
                                                alt="imac image" />
                                        </a>
                                        <label for="counter-input" class="sr-only">Choose quantity:</label>
                                        <div class="flex items-center justify-between md:order-3 md:justify-end">
                                            <div class="flex items-center">
                                                <!-- Decrease button -->
                                                <button type="button" id="decrement-button-2"
                                                    @click.prevent="updateQuantity(item.id, index, item.quantity - 1)"
                                                    data-input-counter-decrement="counter-input-2"
                                                    :class="{
                                                        'bg-gray-50 hover:bg-gray-50 hover:cursor-not-allowed': item.quantity == 1,
                                                    }"
                                                    :disabled="item.quantity == 1"
                                                    class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                                    <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                    </svg>
                                                </button>
                                                <!-- Product quantity -->
                                                <span id="counter-input-2"
                                                    class="w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white"
                                                >
                                                    {{ item.quantity }}
                                                </span>
                                                <!-- Increase button -->
                                                <button type="button" id="increment-button-2"
                                                    @click.prevent="updateQuantity(item.id, index, item.quantity + 1)"
                                                    data-input-counter-increment="counter-input-2"
                                                    class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                                    <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="text-end md:order-4 md:w-32">
                                                <p class="text-base font-bold text-gray-900 dark:text-white">{{ formatCurrency((item.product.new_price ?? item.product.price) * item.quantity) }}</p>
                                            </div>
                                        </div>
                                        <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                            <a href="#"
                                                class="text-base font-medium text-gray-900 hover:underline dark:text-white">{{ item.product.name }}</a>
                                            <div class="flex items-center gap-4">
                                                <button type="button"
                                                    @click="removeItems([ item ])"
                                                    class="inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500">
                                                    <svg class="me-1.5 h-5 w-5" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18 17.94 6M18 18 6.06 6" />
                                                    </svg>
                                                    Xóa
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                            <div
                                class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                                <p class="text-xl font-semibold text-gray-900 dark:text-white">Chi tiết</p>
                                <div class="space-y-4">
                                    <dl
                                        class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                        <dt class="text-base font-bold text-gray-900 dark:text-white">Tổng tiền</dt>
                                        <dd class="text-base font-bold text-gray-900 dark:text-white">{{ formatCurrency(totalPrice) }}</dd>
                                    </dl>
                                </div>
                                <button
                                    @click="processToCheckout"
                                    :disabled="loading"
                                    :class="{ 'cursor-not-allowed': loading }"
                                    class="flex w-full items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-purple-700 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700"
                                >
                                    Checkout
                                </button>
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> hoặc </span>
                                    <Link :href="route('home')" title=""
                                        class="inline-flex items-center gap-2 text-sm font-medium text-primary-700 underline hover:no-underline dark:text-primary-500">
                                        Tiếp tục mua sắm
                                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="px-5 py-5 max-w-sm mx-auto">
                        <h1 class="text-2xl">Chưa có sản phẩm nào trong giỏ hàng</h1>
                    </div>
                </template>
            </WhenVisible>
        </div>
    </section>
</template>

<script setup>
import { Head, router, WhenVisible, usePage, Link } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';
import { computed, onMounted, ref, toRaw } from 'vue';
import formatCurrency from '@/helper/formatCurrency';

const props = defineProps({
    cartItems: {
        type: Object
    }
})

const page = usePage();

const cart = ref([])
const toast = useToast()
const loading = ref(false)
const isCheckAll = ref(false)

const checkedItems = computed(() => {
    return cart.value.filter(item => item.checked)
})

const totalPrice = computed(() => {
    return checkedItems.value.reduce((total, item) => {
        return total + ((item.product.new_price ?? item.product.price) * item.quantity)
    }, 0)

})

console.log(props.cartItems)

onMounted(() => {
    router.reload({
        only: ['cartItems'],
        onSuccess: () => {
            cart.value = structuredClone(toRaw(props.cartItems))
            isCheckAll.value = cart.value.every(item => item.checked)
        }
    })
})

function checkItem(index) {
    cart.value[index].checked = !cart.value[index].checked
    isCheckAll.value = cart.value.every(item => item.checked)

    axios.put(route('cart.check.item'), {
        itemId: cart.value[index].id,
    })
        .then(response => {
        })
        .catch(error => {
            toast.add({ severity: 'error', summary: error.message, life: 2000 });
            cart.value[index].checked = !cart.value[index].checked
            isCheckAll.value = cart.value.every(item => item.checked)
        })
}

function checkAll() {
    isCheckAll.value = !isCheckAll.value
    cart.value.forEach(item => item.checked = isCheckAll.value);

    axios.put(route('cart.check.item'), {
        isCheckAll: isCheckAll.value,
    })
        .then(res => {
        })
        .catch(err => {
            toast.add({ severity: 'error', summary: err.message, life: 2000 });
            isCheckAll.value = !isCheckAll.value
            cart.value.forEach(item => item.checked = isCheckAll.value);
        })
}

function updateQuantity(itemId, index, newQuantity) {
    const oldQuantity = props.cartItems[index].quantity;

    if (props.cartItems[index].product.quantity < newQuantity) {
        cart.value[index].quantity = props.cartItems[index].product.quantity;
        return;
    }

    cart.value[index].quantity = newQuantity;
    loading.value = true;

    axios.put(route('cart.update.quantity'), {
        itemId,
        newQuantity,
    })
        .then(res => {
            loading.value = false;
            router.reload({
                only: ['cartNumber'],
                replace: true
            })
        })
        .catch(error => {
            toast.add({ severity: 'error', summary: error.message, life: 2000 })
            cart.value[index].quantity = oldQuantity
            loading.value = false;
        })
}

/**
 *
 * @param {Array.number} items
 */
function removeItems(items) {
    const itemIds = items.map(item => item.id);

    axios.delete(route('cart.remove.items', { ids: itemIds }))
        .then(res => {
            router.get(route('cart'), {}, {
                preserveScroll: true,
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Đã xóa sản phẩm', life: 2000 });
                }
            })
        })
        .catch(err => {
            toast.add({ severity: 'error', summary: 'Bạn chưa chọn sản phẩm', life: 2000 });
        })
}

function processToCheckout() {
    if (checkedItems.value.length < 1) {
        toast.add({ severity: 'warn', summary: 'Bạn chưa chọn sản phẩm nào', life: 2000 })
        return;
    }
    router.post(route('cart.total'), {
        checkedItems: checkedItems.value
    })
}
</script>
