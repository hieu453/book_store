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
                            <th class="pb-4 pt-6 px-4">
                                <input type="checkbox">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tên danh mục
                                </h1>
                                <input type="text" v-model="name" class="font-normal rounded"">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tạo lúc
                                </h1>
                                <input type="date" v-model="created_at" class="font-normal rounded">
                            </th>
                            <th class="pb-4 pt-6 px-6" colspan="2">
                                <h1>
                                    Sửa lúc
                                </h1>
                                <input type="date" v-model="updated_at" class="font-normal rounded">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t px-4">
                                <input type="checkbox"
                                >
                            </td>
                            <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="route('admin.products.edit', { productId: product.id })">
                                {{ category.name }}
                            </Link>
                            </td>
                            <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="route('admin.categories.edit', { categoryId: category.id })" tabindex="-1">
                                {{ formatTimestamp(category.created_at) }}
                            </Link>
                            </td>
                            <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="route('admin.categories.edit', { categoryId: category.id })" tabindex="-1">
                                {{ formatTimestamp(category.updated_at) }}
                            </Link>
                            </td>
                        </tr>
                        <tr v-if="categories.data.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">No categorys found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import { ref } from 'vue';

const props = defineProps({
    products: Object
})




</script>
