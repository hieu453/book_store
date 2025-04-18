<template>
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-8">
        <Head title="Cart" />
        <Toast />
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Shopping Cart</h2>

            <WhenVisible data="cartItems">
                <template #fallback>
                    <div>Loading...</div>
                </template>
                <template v-if="cart.length > 0">
                    <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                        <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                            <div class="space-y-6">
                                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:py-3 md:px-6 mb-3">
                                    <div class="space-y-4 flex items-center justify-between gap-6">
                                        <input type="checkbox" :checked="isCheckAll" @change="checkAll">
                                        <!-- <span><button @click="deleteBatch">Delete</button></span> -->
                                        <span><button @click="removeItems(checkedItems)">Delete</button></span>
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
                                            <img class="h-20 w-20 dark:hidden"
                                                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/apple-watch-light.svg"
                                                alt="imac image" />
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
                                                <p class="text-base font-bold text-gray-900 dark:text-white">${{ (item.product.price * item.quantity).toFixed(2) }}</p>
                                            </div>
                                        </div>
                                        <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                            <a href="#"
                                                class="text-base font-medium text-gray-900 hover:underline dark:text-white">{{ item.product.name }}</a>
                                            <div class="flex items-center gap-4">
                                                <button type="button"
                                                    class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 hover:underline dark:text-gray-400 dark:hover:text-white">
                                                    <svg class="me-1.5 h-5 w-5" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                                    </svg>
                                                    Add to Favorites
                                                </button>
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
                                                    Remove
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
                                <p class="text-xl font-semibold text-gray-900 dark:text-white">Order summary</p>
                                <div class="space-y-4">
                                    <!-- <div class="space-y-2">
                                        <dl class="flex items-center justify-between gap-4">
                                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Original price
                                            </dt>
                                            <dd class="text-base font-medium text-gray-900 dark:text-white">$7,592.00</dd>
                                        </dl>
                                        <dl class="flex items-center justify-between gap-4">
                                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Savings</dt>
                                            <dd class="text-base font-medium text-green-600">-$299.00</dd>
                                        </dl>
                                        <dl class="flex items-center justify-between gap-4">
                                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Store Pickup</dt>
                                            <dd class="text-base font-medium text-gray-900 dark:text-white">$99</dd>
                                        </dl>
                                        <dl class="flex items-center justify-between gap-4">
                                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Tax</dt>
                                            <dd class="text-base font-medium text-gray-900 dark:text-white">$799</dd>
                                        </dl>
                                    </div> -->
                                    <dl
                                        class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                        <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                        <dd class="text-base font-bold text-gray-900 dark:text-white">${{ totalPrice.toFixed(2) }}</dd>
                                    </dl>
                                </div>
                                <button
                                    @click="processToCheckout"
                                    :disabled="loading"
                                    :class="{ 'cursor-not-allowed': loading }"
                                    class="flex w-full items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-purple-700 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700"
                                >
                                    Proceed to Checkout
                                </button>
                                <div class="flex items-center justify-center gap-2">
                                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> or </span>
                                    <Link :href="route('home')" title=""
                                        class="inline-flex items-center gap-2 text-sm font-medium text-primary-700 underline hover:no-underline dark:text-primary-500">
                                        Continue Shopping
                                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                            <!-- <div
                                class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                                <form class="space-y-4">
                                    <div>
                                        <label for="voucher"
                                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Do you have a
                                            voucher or gift card? </label>
                                        <input type="text" id="voucher"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                            placeholder="" required />
                                    </div>
                                    <button type="submit"
                                        class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Apply
                                        Code</button>
                                </form>
                            </div> -->
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="px-5 py-5 max-w-sm mx-auto border rounded-lg">
                        <h1 class="text-2xl">There are no products in cart</h1>
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
        return total + (item.product.price * item.quantity)
    }, 0)

})

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
                    toast.add({ severity: 'success', summary: 'Item deleted', life: 2000 });
                }
            })
        })
        .catch(err => {
            toast.add({ severity: 'error', summary: err.message, life: 2000 });
        })
}

function processToCheckout() {
    if (checkedItems.value.length < 1) {
        toast.add({ severity: 'warn', summary: 'Please select item(s)', life: 2000 })
        return;
    }
    router.post(route('cart.total'), {
        checkedItems: checkedItems.value
    })
}
</script>
