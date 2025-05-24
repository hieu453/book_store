<template>
    <div class="mt-2">
        <template v-if="cancelledOrders.length > 0">
            <div v-for="order in cancelledOrders">
                <div class="flex justify-between items-center mx-4 my-2">
                    <h1 class="p-2 text-3xl font-bold">Đơn hàng: {{ order.order_id }}</h1>
                </div>
                <div v-for="item in order.order_items" class="border mb-2 rounded-lg">
                    <Link :href="route('product.show', { slug: item.product.slug, id: item.product.id })" class="flex gap-6 items-center justify-between px-4">
                        <div class="flex items-center gap-x-2">
                            <img
                                :src="`http://localhost:8000/storage/product_images/product_${item.product.id}/${item.product.images[0].image_name}`"
                                alt="product_image"
                                class="w-20 rounded-lg"
                            >
                            <div>
                                <p class="text-2xl">{{ item.product.name }}</p>
                                <span class="text-sm">Số lượng: {{ item.quantity }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="space-x-2">
                                <span class="text-xl">Giá: {{ formatCurrency(item.price) }}</span>
                            </div>
                        </div>
                    </Link>
                </div>
                <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
            </div>
        </template>
        <template v-else>
            <p>Chưa có đơn hàng nào.</p>
        </template>
    </div>
</template>

<script setup>
import formatCurrency from '@/helper/formatCurrency';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    orders: Array,
})

const cancelledOrders = computed(() => props.orders.filter(order => order.status === 'cancelled'));
</script>
