<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Sản phẩm" />
            <h1 class="mb-8 text-3xl font-bold">Sản phẩm</h1>
            <div class="flex items-center justify-between mb-6">
                <Link class="btn-indigo" :href="route('admin.products.create')">
                    <span>Thêm</span>
                    <span class="hidden md:inline">&nbsp;Sản phẩm</span>
                </Link>
            </div>

            <div class="bg-white rounded-md shadow overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left">
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tên sách
                                </h1>
                                <input type="text" v-model="name" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tác giả
                                </h1>
                                <input type="text" v-model="author" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Ngôn ngữ
                                </h1>
                                <input type="text" v-model="language" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Nhà xuất bản
                                </h1>
                                <input type="text" v-model="publisher" class="font-normal rounded" @input="filter">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="route('admin.products.edit', { productId: product.id })">
                                    {{ product.name }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.products.edit', { productId: product.id })" tabindex="-1">
                                    {{ product.author }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.products.edit', { productId: product.id })" tabindex="-1">
                                    {{ product.language }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.products.edit', { productId: product.id })" tabindex="-1">
                                    {{ product.publisher }}
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="products.data.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">Không tìm thấy sản phẩm nào.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :links="products.links" class="mt-2" />
        </div>
    </Dashboard>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import Toast from 'primevue/toast';
import { ref } from 'vue';

const props = defineProps({
    products: Object,
    filters: Object,
})

const name = ref(props.filters.name ?? '')
const author = ref(props.filters.author ?? '')
const language = ref(props.filters.language ?? '')
const publisher = ref(props.filters.publisher ?? '')

const filter = debounce(function () {
    const data = {
        name: name.value,
        author: author.value,
        language: language.value,
        publisher: publisher.value
    }

    const filteredObject = Object.fromEntries(
        Object.entries(data).filter(([_, v]) => v != '')
    )

    router.get(route('admin.products'), filteredObject, {
        preserveScroll: true,
        preserveState: true,
    });
}, 250)

</script>
