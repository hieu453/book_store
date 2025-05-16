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
                <!-- <DataTable
                    :value="products"
                    v-model:selection="selectedProducts"
                    v-model:filters="filters"
                    filterDisplay="row"
                    :globalFilterFields="['name' ,'author', 'language', 'publisher']"
                    sortMode="multiple"
                    paginator
                    :rows="5"
                    tableStyle="min-width: 50rem"
                    selectionMode="single"
                    @rowSelect="onRowSelect"
                >
                    <template #empty> Chưa có sản phẩm nào. </template>

                    <Column field="name" header="Tên" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.name }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo tên" />
                        </template>
                    </Column>
                    <Column field="author" header="Tác giả" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.author }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo tác giả" />
                        </template>
                    </Column>
                    <Column field="language" header="Ngôn ngữ" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.language }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo ngôn ngữ" />
                        </template>
                    </Column>
                    <Column field="publisher" header="Nhà xuất bản" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.publisher }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo nhà xuất bản" />
                        </template>
                    </Column>
                </DataTable> -->
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left">
                            <th class="pb-4 pt-6 px-4">
                                <input type="checkbox">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tên sách
                                </h1>
                                <input type="text" class="font-normal rounded">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tác giả
                                </h1>
                                <input type="date" class="font-normal rounded">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Ngôn ngữ
                                </h1>
                                <input type="date" class="font-normal rounded">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Nhà xuất bản
                                </h1>
                                <input type="date" class="font-normal rounded">
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
import Toast from 'primevue/toast';
import { ref } from 'vue';

const props = defineProps({
    products: Object
})


</script>
