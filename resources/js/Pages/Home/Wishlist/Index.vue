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
                                <img alt="user header" src="https://primefaces.org/cdn/primevue/images/usercard.png" />
                            </template>
                            <template #title>{{ wishlist.product.category.name }}</template>
                            <template #subtitle>{{ wishlist.product.name }}</template>
                            <template #content>
                                <p class="m-0">
                                    {{ wishlist.product.price }}đ
                                </p>
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

const props = defineProps({
    wishlists: Object,
})

const breadCrumb = ref([
    {
        label: 'Danh sách yêu thích',
    }
])
</script>
