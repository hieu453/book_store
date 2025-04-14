<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Products" />
            <h1 class="mb-8 text-3xl font-bold">Products</h1>
            <div class="flex items-center justify-between mb-6">
                <Link class="btn-indigo" :href="route('admin.products.create')">
                    <span>Create</span>
                    <span class="hidden md:inline">&nbsp;Products</span>
                </Link>
            </div>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <DataTable
                    :value="products"
                    v-model:selection="selectedProducts"
                    v-model:filters="filters"
                    filterDisplay="row"
                    :globalFilterFields="['name', 'author', 'publisher']"
                    sortMode="multiple"
                    paginator
                    :rows="5"
                    tableStyle="min-width: 50rem"
                    selectionMode="single"
                    @rowSelect="onRowSelect"
                >
                    <template #empty> No products found. </template>

                    <Column field="name" header="Name" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.name }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by name" />
                        </template>
                    </Column>
                    <Column field="author" header="Author" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.author }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by author" />
                        </template>
                    </Column>
                    <Column field="language" header="Language" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.language }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by language" />
                        </template>
                    </Column>
                    <Column field="publisher" header="Publisher" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.publisher }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by publisher" />
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
