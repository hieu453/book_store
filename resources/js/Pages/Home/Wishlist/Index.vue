<template>
    <div class="container px-4 py-8 mx-auto">
        <Head title="Wishlists" />
        <Breadcrumb :data="breadCrumb" />
        <WhenVisible data="permissions" :buffer="500">
            <template #fallback>
                <DataView :value="wishlists.data" layout="grid">
                    <template #grid>
                        <div class="grid md:grid-cols-3">
                            <div v-for="i in 12" :key="i" class="col-12 sm:col-6 lg:col-12 xl:col-4 p-2">
                                <div class="p-4 border-1 surface-border surface-card border-round">
                                    <div class="flex flex-wrap align-items-center justify-content-between gap-2">
                                        <Skeleton class="w-6rem border-round h-2rem" />
                                        <Skeleton class="w-3rem border-round h-1rem" />
                                    </div>
                                    <div class="flex flex-column align-items-center gap-3 py-5">
                                        <Skeleton class="w-9 border-round h-10rem" />
                                        <Skeleton class="w-8rem border-round h-2rem" />
                                        <Skeleton class="w-6rem border-round h-1rem" />
                                    </div>
                                    <div class="flex align-items-center justify-content-between">
                                        <Skeleton class="w-4rem border-round h-2rem" />
                                        <Skeleton shape="circle" class="w-3rem h-3rem" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </DataView>
            </template>
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
                                        ${{ wishlist.product.price }}
                                    </p>
                                </template>
                                <template #footer>
                                    <div class="flex gap-2 mt-1 items-center">
                                        <Link :href="route('product.show', {
                                            slug: wishlist.product.slug,
                                            id: wishlist.product.id,
                                        })" class="w-full btn bg-purple-800 hover:bg-purple-600">
                                        View
                                        </Link>
                                    </div>
                                </template>
                            </Card>
                        </div>
                    </div>
                    <Pagination :products="wishlists" :route="route('wishlist')" class="mt-2" />
                </div>
                <div v-else class="h-screen text-center content-center">
                    <div class="px-5 py-5 max-w-sm mx-auto border rounded-lg">
                        <h1 class="text-2xl">There are no products in wishlist</h1>
                    </div>
                </div>
            </div>
        </WhenVisible>
    </div>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import { WhenVisible, Link, Head } from '@inertiajs/vue3';
import Skeleton from 'primevue/skeleton';
import DataView from 'primevue/dataview';
import Card from 'primevue/card';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { ref } from 'vue';

const props = defineProps({
    wishlists: Object,
})

const breadCrumb = ref([
    {
        label: 'Wishlists',
    }
])
</script>
