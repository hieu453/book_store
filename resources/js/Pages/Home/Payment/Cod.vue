<template>
    <div class="mx-auto max-w-md my-20">
        <Head title="Payment status" />
        <div class="flex justify-center mb-3">
            <img :src="icon_url" alt="">
        </div>
        <div class="text-center">
            <h1 class="text-green-500 text-3xl font-bold">
                {{ message }}
            </h1>
            <div v-if="order" class="flex justify-center mt-2">
                <table class="text-left">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng:</th>
                            <td class="px-2 py-2">{{ order.order_id }}</td>
                        </tr>
                        <tr>
                            <th>Tổng số lượng:</th>
                            <td class="px-2 py-2">{{ order.quantity }}</td>
                        </tr>
                        <tr>
                            <th>Tổng tiền:</th>
                            <td class="px-2 py-2">{{ order.total_price }}</td>
                        </tr>
                        <tr>
                            <th>Phương thức thanh toán:</th>
                            <td class="px-2 py-2">{{ order.payment_mode }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div v-if="order" class="flex justify-center">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Tên sách
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ngôn ngữ
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tác giả
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nhà xuất bản
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Giá tiền
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Số lượng
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="orderItem in order.order_items"
                            :key="orderItem.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200"
                        >
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ orderItem.product.name }}
                            </td>
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
                                {{ formatCurrency(orderItem.product.price) }}
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
import formatCurrency from '@/helper/formatCurrency';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    icon_url: String,
    message: String,
    order: Object,
})
</script>
