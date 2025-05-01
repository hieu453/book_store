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
                <DataTable
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
                </DataTable>
            </div>
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { Head, Link, router } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import { FilterMatchMode } from '@primevue/core/api';
import InputText from 'primevue/inputtext';
import { ref } from 'vue';

const props = defineProps({
    products: Object
})

const selectedProducts = ref()

const filters = ref({
    name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    author: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    language: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    publisher: { value: null, matchMode: FilterMatchMode.STARTS_WITH }
});

function onRowSelect(event) {
    router.get(route('admin.products.edit', { productId: event.data.id }))
}
</script>
