<template>
    <div class="container px-4 py-8 mx-auto">
        <Head title="Products" />
        <Breadcrumb :data="breadCrumb" />
        <div class="flex mt-3 space-x-2">
            <div class="w-1/3">
                <div>
                    <h1 class="text-lg font-bold">Filter</h1>
                </div>
                <div>
                    <h1 class="text-lg font-bold">Price:</h1>
                    <select v-model="price" @change="filter">
                        <option :value="priceOrder.asc">Low to high</option>
                        <option :value="priceOrder.desc">High to low</option>
                    </select>
                </div>
            </div>
            <div v-if="products.data.length > 0">
                    <div class="grid grid-cols-3 gap-2">
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
                <Pagination :links="products.links" class="mt-4" />
            </div>
            <div
                v-else
                class="h-screen text-center content-center"
            >
                <div class="px-5 py-5 max-w-sm mx-auto border rounded-lg">
                    <h1 class="text-2xl">No products</h1>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Card from 'primevue/card';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref, reactive } from 'vue';

const props = defineProps({
    products: Object,
    category_slug: String,
    filters: Object,
})


const breadCrumb = ref([
    {
        label: 'Categories',
    },
    {
        label: props.category_name,
    }
])

const price = ref(props.filters.price)
const priceOrder = reactive({
    asc: 'asc',
    desc: 'desc',
})

function filter() {
    router.get(route('category.show', { slug: props.category_slug }), {
        price: price.value
    })
}

</script>
