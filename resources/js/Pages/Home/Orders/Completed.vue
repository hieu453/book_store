<template>
    <div class="mt-2">
        <Dialog v-model:visible="visible" modal header="Đánh giá" :style="{ width: '25rem' }">
            <span class="text-surface-500 dark:text-surface-400 block mb-8">Đánh giá sản phẩm.</span>
            <div class="flex items-center gap-4 mb-4">
                <label class="font-semibold w-24">Số sao</label>
                <Rating :ratings="ratings" @update-rating="updateRatingPoint" />
            </div>
            <div class="flex items-center gap-4 mb-2">
                <label class="font-semibold w-24">Nhận xét</label>
                <Textarea v-model="form.reviewContent" @input="form.reviewContent.trim()" class="flex-auto" autocomplete="off" />
            </div>
            <div class="flex justify-end gap-2">
                <Button type="button" label="Hủy" severity="secondary" @click="visible = false"></Button>
                <Button type="button" label="Đánh giá" @click="addReview" class="!border-none !bg-indigo-500"></Button>
            </div>
        </Dialog>
        <template v-if="completedOrders.length > 0">
            <div v-for="order in completedOrders">
                <div class="flex justify-between items-center mx-4 my-2">
                    <h1 class="p-2 text-3xl font-bold">Đơn hàng: {{ order.order_id }}</h1>
                </div>
                <div v-for="item in order.order_items" class="border mb-2 rounded-lg">
                        <div class="flex gap-6 items-center justify-between px-4">
                            <Link :href="route('product.show', { slug: item.product.slug, id: item.product.id })">
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
                            </Link>
                            <div>
                                <div class="space-y-2 mt-2">
                                    <button
                                        v-if="isRated(item.product.reviews)"
                                        class="btn-gray italic"
                                        disabled
                                    >
                                        Đã đánh giá
                                    </button>
                                    <button
                                        v-else
                                        class="btn-indigo"
                                        @click="openRatingModal(item)"
                                    >
                                        Đánh giá
                                    </button>
                                    <div>
                                        <span class="text-xl">Giá: {{ formatCurrency(item.price) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import { computed, nextTick, onMounted, ref } from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Textarea from 'primevue/textarea';
import Rating from '@/Components/Rating.vue';
import Quill from 'quill';
import formatCurrency from '@/helper/formatCurrency';


const props = defineProps({
    orders: Array,
})

const visible = ref(false);

const page = usePage()
const user = computed(() => page.props.auth.user)

const ratings = [
    {
        name: 'rating1',
        value: 1,
    },
    {
        name: 'rating2',
        value: 2,
    },
    {
        name: 'rating3',
        value: 3,
    },
    {
        name: 'rating3',
        value: 4,
    },
    {
        name: 'rating3',
        value: 5,
    },
];

const form = useForm({
    reviewContent: '',
    ratingPoint: -1,
    productId: null,
})

const completedOrders = computed(() => props.orders.filter(order => order.status === 'completed'));

function isRated(reviews) {
    const userReviews = reviews.filter(review => review.user_id === user.value.id);
    return userReviews.length > 0 ? true : false;
}

function updateRatingPoint(ratingVal) {
    form.ratingPoint = ratingVal;
}

function addReview() {
    router.post(route('reviews.store'), form, {
        onSuccess: ()=>{
            visible.value = false
        }
    })
}

async function openRatingModal(item) {
    form.productId = item.product.id;
    visible.value = true;
}
</script>

