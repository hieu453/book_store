<template>
    <div class="mx-auto max-w-md my-20">
        <Head title="Payment status" />
        <div class="flex justify-center mb-3">
            <img :src="icon_url" alt="">
        </div>
        <div class="text-center">
            <h1
                :class="[ code == 0 ? 'text-green-500' : 'text-red-500' ,'text-3xl font-bold' ]"
            >
                {{ message }}
            </h1>
            <div v-if="order" class="flex justify-center mt-2">
                <table class="text-left">
                    <tr>
                        <th>Order id:</th>
                        <td class="px-2 py-2">{{ order.order_id }}</td>
                    </tr>
                    <tr>
                        <th>Total Quantity:</th>
                        <td class="px-2 py-2">{{ order.quantity }}</td>
                    </tr>
                    <tr>
                        <th>Total price:</th>
                        <td class="px-2 py-2">{{ order.total_price }}</td>
                    </tr>
                </table>
            </div>
            <div v-if="order" class="flex justify-center">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Language
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Author
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Publisher
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Quantity
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="orderItem in order.order_items"
                            :key="orderItem.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200"
                        >
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ orderItem.product.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ orderItem.product.language }}
                            </td>
                            <td class="px-6 py-4">
                                {{ orderItem.product.author }}
                            </td>
                            <td class="px-6 py-4">
                                {{ orderItem.product.publisher }}
                            </td>
                            <td class="px-6 py-4">
                                {{ orderItem.product.price }}
                            </td>
                            <td class="px-6 py-4">
                                {{ orderItem.quantity }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    icon_url: String,
    message: String,
    order: Object,
    code: Number,
})
</script>
