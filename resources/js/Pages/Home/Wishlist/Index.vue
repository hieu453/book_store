<template>
    <div class="container px-4 py-8 mx-auto">
        <Head title="Danh sách yêu thích" />
        <Breadcrumb :data="breadCrumb" />
        <div class="mt-2">
            <div v-if="wishlists.data.length > 0">
                <div class="grid md:grid-cols-4 gap-4">
                    <div v-for="wishlist in wishlists.data" :key="wishlist.id">
                        <Card style="overflow: hidden;">
                            <template #header>
                                <img v-if="wishlist.product.images.length > 0" :src="wishlist.product.images[0].url" style="height: 300px; width: 100%;" />
                                <img v-else src="" alt="product image" style="height: 300px;">
                            </template>
                            <template #title>
                                <div class="line-clamp-2 has-tooltip">
                                    <h1>
                                        {{ wishlist.product.name }}
                                    </h1>
                                    <div class="tooltip text-sm font-thin -mt-20 bg-gray-100 shadow-md text-black rounded-sm p-2">
                                        {{ wishlist.product.name }}
                                    </div>
                                </div>
                            </template>
                            <template #content>
                                <span class="text-xl font-bold mr-2 dark:text-black">{{ formatCurrency(wishlist.product.new_price ?? wishlist.product.price) }}</span>
                                <span v-if="wishlist.product.new_price" class="text-gray-500 line-through">{{ formatCurrency(wishlist.product.price) }}</span>
                            </template>
                            <template #footer>
                                <div class="flex gap-2 mt-1 items-center">
                                    <Link :href="route('product.show', {
                                        slug: wishlist.product.slug,
                                        id: wishlist.product.id,
                                    })" class="w-full btn bg-purple-800 hover:bg-purple-600">
                                    Xem
                                    </Link>
                                </div>
                            </template>
                        </Card>
                    </div>
                </div>
                <Pagination :products="wishlists" class="mt-2" />
            </div>
            <div v-else class="h-screen text-center content-center">
                <div class="px-5 py-5 max-w-sm mx-auto border rounded-lg">
                    <h1 class="text-2xl">Chưa có sản phẩm nào.</h1>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import { WhenVisible, Link, Head } from '@inertiajs/vue3';
import Card from 'primevue/card';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { ref } from 'vue';
import formatCurrency from '@/helper/formatCurrency';

const props = defineProps({
    wishlists: Object,
})

const breadCrumb = ref([
    {
        label: 'Danh sách yêu thích',
    }
])
</script>
