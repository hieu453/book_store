<template>
    <div class="container px-4 py-8 mx-auto">
        <Head title="Products" />
        <Breadcrumb :data="breadCrumb" />
        <div class="mt-3 flex space-x-2">
            <div class="w-1/3">
                <div>
                    <h1 class="text-lg font-bold">Filter</h1>
                </div>
                <div>
                    <h1 class="text-lg font-bold">Price:</h1>
                    <select v-model="price" @change="filter">
                        <option value="">Select to filter based on price</option>
                        <option :value="priceOrder.asc">Low to high</option>
                        <option :value="priceOrder.desc">High to low</option>
                    </select>
                </div>

            </div>

            <WhenVisible data="permissions" :buffer="500">
                <template #fallback>
                    <DataView :value="products.data" layout="grid">
                        <template #grid>
                            <div class="grid md:grid-cols-3">
                                <div v-for="i in 9" :key="i" class="col-12 sm:col-6 lg:col-12 xl:col-4 p-2">
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

                <div v-if="products.data.length > 0">
                    <div class="grid md:grid-cols-3 gap-4">
                        <div v-for="product in products.data" :key="product.id">
                            <Card style="overflow: hidden;">
                                <template #header>
                                    <img alt="user header" src="https://primefaces.org/cdn/primevue/images/usercard.png" />
                                </template>
                                <template #title>{{ product.category.name }}</template>
                                <template #subtitle>{{ product.name }}</template>
                                <template #content>
                                    <p class="m-0">
                                        ${{ product.price }}
                                    </p>
                                </template>
                                <template #footer>
                                    <div class="flex gap-2 mt-1 items-center">
                                        <Link
                                            :href="route('product.show', {
                                                slug: product.slug,
                                                id: product.id,
                                            })"
                                            class="w-full btn bg-purple-800 hover:bg-purple-600">
                                            View
                                        </Link>
                                    </div>
                                </template>
                            </Card>
                        </div>
                    </div>
                    <Pagination :products="products" :route="route('products')" :query="{ price }" class="mt-2" />
                </div>
                <div
                    v-else
                    class="h-screen text-center content-center"
                >
                    <div class="px-5 py-5 max-w-sm mx-auto border rounded-lg">
                        <h1 class="text-2xl">No products</h1>
                    </div>
                </div>
            </WhenVisible>
        </div>
    </div>
</template>

<script setup>
import { Head, WhenVisible, Link, router } from '@inertiajs/vue3';
import DataView from 'primevue/dataview';
import Skeleton from 'primevue/skeleton';
import Card from 'primevue/card';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import { reactive, ref } from 'vue';

const props = defineProps({
    products: {
        type: Object,
    }
})

const breadCrumb = ref([
    {
        label: 'Products',
    }
])

const price = ref('')
const priceOrder = reactive({
    asc: 'asc',
    desc: 'desc',
})


function filter() {
    router.get(route('products'), {
        price: price.value
    }, {
        preserveState: true
    })
    // console.log(query.price)
}
</script>
