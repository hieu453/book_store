<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Categories" />
            <h1 class="mb-8 text-3xl font-bold">Categories</h1>
            <div class="flex items-center justify-between mb-6">
                <Link class="btn-indigo" :href="route('admin.categories.create')">
                <span>Create</span>
                <span class="hidden md:inline">&nbsp;Category</span>
                </Link>
            </div>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <DataTable
                    :value="categories.data"
                    v-model:selection="selectedProducts"
                    v-model:filters="filters"
                    filterDisplay="row"
                    :globalFilterFields="['name', 'created_at', 'updated_at']"
                    sortMode="multiple"
                    paginator
                    :rows="5"
                    tableStyle="min-width: 50rem"
                    selectionMode="single"
                    @rowSelect="onRowSelect"
                >
                    <template #empty> No categories found. </template>

                    <Column field="name" header="Name" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.name }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by name" />
                        </template>
                    </Column>
                    <Column field="created_at" header="Created At" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.created_at }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by created date" />
                        </template>
                    </Column>
                    <Column field="updated_at" header="Updated At" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.updated_at }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by updated date" />
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
import { ref } from 'vue';
import Toast from 'primevue/toast';
import { FilterMatchMode } from '@primevue/core/api';
import InputText from 'primevue/inputtext';

defineProps({
    categories: Object,
})

const selectedProducts = ref()

const filters = ref({
    name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    created_at: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    updated_at: { value: null, matchMode: FilterMatchMode.STARTS_WITH }
});

function onRowSelect(event) {
    router.get(route('admin.categories.edit', { categoryId: event.data.id }))
}

</script>
