<template>
    <div>
        <!-- Item Container -->
        <div v-if="product.reviews.length > 0" class="flex flex-col gap-3 mt-3">
            <div
                v-for="review in product.reviews"
                class="flex flex-col gap-4"
            >
                <!-- Profile and Rating -->
                <div class="flex justify justify-between">
                    <div class="flex gap-2">
                        <div class="w-7 h-7 text-center rounded-full bg-red-500">J</div>
                        <span>{{ review.user.name }}</span>
                        <div class="flex p-1 gap-1 text-orange-300">
                            <div class="flex items-center">
                                <template v-for="i in 5">
                                    <svg v-if="i <= review.rate.stars" class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <svg v-else class="w-4 h-4 text-gray-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    {{ review.content }}
                </div>

                <div class="flex justify-between">
                    <span>{{ dayjs(review.created_at).locale('vi').fromNow() }}</span>
                    <button
                        :class="[isLiked(review) ? 'bg-blue-500' : 'bg-blue-400 hover:bg-blue-500', 'btn p-1 px-2 border']"
                        @click="toggleLike(review.id)"
                    >
                        <i v-if="isLiked(review)" class="pi pi-thumbs-up-fill"></i>
                        <i v-else class="pi pi-thumbs-up"></i>

                        {{ isLiked(review) ? 'Đã thích' : 'Hữu ích' }}
                        {{ review.likes.length }}
                    </button>
                </div>
            </div>
        </div>
        <div v-else>
            No reviews
        </div>
    </div>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { computed, ref } from 'vue';

const props = defineProps({
    product: Object,
})

const page = usePage()
const user = computed(() => page.props.auth.user)

function toggleLike(reviewId) {
    router.post(route('reviews.toggleLike', {'reviewId': reviewId}), null, {
        preserveScroll: true,
    })
}

function isLiked(review) {
    if (user.value) {
        return review.likes.some(like => like.user_id === user.value.id);
    }

    return false;
}

</script>

