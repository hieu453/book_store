<template>
    <div class="mt-2">
        <div v-for="order in ordersPending">
            <div v-for="item in order.order_items" class="border flex gap-6 mb-2 rounded-lg">
                <div>
                    <img
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="product_image"
                        class="w-20 rounded-lg"
                    >
                </div>
                <div>
                    <p class="text-lg">{{ item.product.name }}</p>
                    <div class="space-x-2">
                        <span class="text-sm">{{ item.quantity }}</span>
                        <span>x</span>
                        <span class="text-sm">{{ item.price }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>


const props = defineProps({
    ordersPending: Array,
    ordersProcessing: Array,
    ordersCompleted: Array,
})

</script>
