<template>
    <div class="container px-4 py-8 mx-auto">
        <Head title="Search results" />
        <Breadcrumb :data="breadCrumb" />
        <div class="mt-3 flex space-x-2">
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
                <div class="grid md:grid-cols-4 gap-4">
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
                <Pagination :products="products" class="mt-2" />
            </div>
            <div v-else>
                <div class="px-5 py-5 max-w-sm mx-auto text-center">
                    <h1 class="text-2xl">No products found</h1>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Card } from 'primevue';
import { ref } from 'vue';

const props = defineProps({
    products: Object,
    filters: Object,
})

const breadCrumb = ref([
    {
        label: `Search results for keyword '${props.filters.keyword}'`,
    }
])

const price = ref(props.filters.price)
const priceOrder = ref({
    asc: 'asc',
    desc: 'desc',
})

function filter() {
    router.get(route('home.search'), {
        price: price.value,
        keyword: props.filters.keyword
    })
}
</script>
