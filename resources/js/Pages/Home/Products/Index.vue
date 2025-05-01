<template>
    <div class="container px-4 py-8 mx-auto">
        <Head title="Sản phẩm" />
        <div class="flex justify-between">
            <Breadcrumb :data="breadCrumb" />
            <div class="flex items-center space-x-2">
                <h1 class="">Bộ lọc</h1>
                <select v-model="price" class="rounded-lg" @change="filter">
                    <option :value="priceOrder.asc">Giá thấp đến cao</option>
                    <option :value="priceOrder.desc">Giá cao đến thấp</option>
                </select>
            </div>
        </div>
        <div class="mt-3 flex space-x-4">
            <div class="hidden md:block w-1/3 border border-black rounded-xl p-4 max-h-fit">
                <h1 class="font-bold text-gray-500">Danh mục</h1>
                <div class="bg-gray-200 h-1 max-w-8 mt-2 mb-4 rounded-xl"></div>
                <ul>
                    <li
                        v-for="category in page.props.categories"
                        class="py-2 border-b last:border-none"
                    >
                        <Link :href="route('category.show', { slug: category.slug })" class="text-green-800">
                            {{ category.name }}
                        </Link>
                    </li>
                </ul>
            </div>
            <div class="grid md:grid-cols-3 gap-4">
                <template v-if="products.data.length > 0">
                    <div v-for="product in products.data" :key="product.id">
                        <Card style="overflow: hidden; height: 500px;">
                            <template #header>
                                <img v-if="product.images.length > 0" :src="product.images[0].url" style="height: 300px; width: 100%;" />
                                <img v-else src="" alt="product image" style="height: 300px;">
                            </template>
                            <template #title>{{ product.category.name }}</template>
                            <template #subtitle>{{ product.name }}</template>
                            <template #content>
                                <p class="m-0">
                                    {{ product.price }}đ
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
                                        Xem
                                    </Link>
                                </div>
                            </template>
                        </Card>
                    </div>
                </template>
                <div
                    v-else
                    class="h-screen text-center content-center"
                >
                    <div class="px-5 py-5 max-w-sm mx-auto border rounded-lg">
                        <h1 class="text-2xl">Chưa có sản phẩm nào</h1>
                    </div>
                </div>
            </div>
        </div>
        <Pagination :links="products.links" class="my-3 text-center" />
    </div>
</template>

<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import Card from 'primevue/card';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Pagination from '@/Components/Pagination.vue';
import { reactive, ref } from 'vue';

const props = defineProps({
    products: Object,
    filters: Object,
})

const page = usePage()

const breadCrumb = ref([
    {
        label: 'Sản phẩm',
    }
])

const price = ref(props.filters.price)
const priceOrder = reactive({
    asc: 'asc',
    desc: 'desc',
})

function filter() {
    router.get(route('products'), {
        price: price.value
    })
}
</script>
