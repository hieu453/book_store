<template>
    <div class="mt-2">
        <template v-if="pendingOrders.length > 0">
            <div v-for="order in pendingOrders">
                <div class="flex justify-between items-center mx-4 my-2">
                    <h1 class="p-2 text-3xl font-bold">Đơn hàng: {{ order.order_id }}</h1>
                    <button
                        v-if="order.cancelled_order == null"
                        @click="cancelOrder(order.order_id)"
                        class="btn-indigo"
                    >
                        Hủy
                    </button>
                    <button
                        v-else
                        class="btn-gray italic"
                        disabled
                    >
                        Đã yêu cầu hủy hàng
                    </button>
                </div>
                <div v-for="item in order.order_items" class="border mb-2 rounded-lg">
                    <Link :href="route('product.show', { slug: item.product.slug, id: item.product.id })" class="flex gap-6 items-center justify-between px-4">
                        <div class="flex items-center gap-x-2">
                            <img
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
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
                                <span class="text-xl">Giá: {{ item.price }}đ</span>
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
import { Link, router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import { computed } from 'vue';

const toast = useToast();

const page = usePage();

const props = defineProps({
    orders: Array,
})

const pendingOrders = computed(() => props.orders.filter(order => order.status === 'pending'));

function cancelOrder(orderId) {
    router.post(route('orders.cancel', { orderId }), null, {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        },
        onError: () => {
            console.log('vl');

        }
    })

}

</script>
