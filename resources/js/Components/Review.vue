<template>
    <div>
        <div class="w-auto">
            <h1 class="text-2xl font-bold mt-4">Reviews</h1>
            <textarea v-model="reviewContent"></textarea>
            <button @click="sendReview(product.id)">Send</button>
        </div>

        <!-- Item Container -->
        <div v-if="reviews.length > 0" class="flex flex-col gap-3 mt-3">
            <div
                v-for="review in reviews"
                class="flex flex-col gap-4 bg-gray-400 p-4"
            >
                <!-- Profile and Rating -->
                <div class="flex justify justify-between">
                    <div class="flex gap-2">
                        <div class="w-7 h-7 text-center rounded-full bg-red-500">J</div>
                        <span>{{ review.user.name }}</span>
                    </div>
                    <div class="flex p-1 gap-1 text-orange-300">
                        <!-- <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star-half"></ion-icon> -->
                    </div>
                </div>

                <div>
                    {{ review.content }}
                </div>

                <div class="flex justify-between">
                    <span>{{ review.created_at }}</span>
                    <button
                        :class="[isLiked(review) ? 'liked' : '', 'p-1 px-2 bg-gray-900 hover:bg-gray-950 border border-gray-950 bg-opacity-60']"
                        @click="toggleLike(review.id)"
                    >
                        {{ isLiked(review) ? 'Unlike' : 'Like' }}
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
import { computed, ref } from 'vue';

defineProps({
    product: Object,
    reviews: Object,
})

const page = usePage()
const user = computed(() => page.props.auth.user)
const reviewContent = ref('')

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

function sendReview(productId) {
    router.post(route('reviews.add'), {
        reviewContent: reviewContent.value,
        productId
    })

}

</script>

<style scoped>
.liked {
  background-color: red;
  color: white;
}
</style>
