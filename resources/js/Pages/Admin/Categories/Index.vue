<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Danh mục" />
            <h1 class="mb-8 text-3xl font-bold">Danh mục</h1>
            <div class="flex items-center justify-between mb-6">
                <Link class="btn-indigo" :href="route('admin.categories.create')">
                <span>Tạo</span>
                <span class="hidden md:inline">&nbsp;Danh mục</span>
                </Link>
            </div>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <DataTable
                    :value="formattedDateCategories"
                    v-model:selection="selectedCategories"
                    v-model:filters="filters"
                    filterDisplay="row"
                    dataKey="id"
                    sortMode="multiple"
                    showGridlines
                    paginator
                    :rows="5"
                    tableStyle="min-width: 50rem"
                    selectionMode="single"
                    @rowSelect="onRowSelect"
                >
                    <template #empty> Chưa có danh mục nào. </template>

                    <Column field="name" header="Name" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.name }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo tên danh mục" />
                        </template>
                    </Column>
                    <Column header="Ngày tạo" filterField="created_at" dataType="date" style="min-width: 10rem">
                        <template #body="{ data }">
                            {{ formatTimestamp(data.created_at) }}
                        </template>
                        <template #filter="{ filterModel, filterCallback }">
                            <DatePicker v-model="filterModel.value" dateFormat="dd/mm/yy" placeholder="dd/mm/yyyy" @input="filterCallback()" @dateSelect="filterCallback()" />
                        </template>
                    </Column>
                    <Column header="Ngày cập nhật" filterField="updated_at" dataType="date" style="min-width: 10rem">
                        <template #body="{ data }">
                            {{ formatTimestamp(data.updated_at) }}
                        </template>
                        <template #filter="{ filterModel, filterCallback }">
                            <DatePicker v-model="filterModel.value" dateFormat="dd/mm/yy" placeholder="dd/mm/yyyy" @input="filterCallback()" @dateSelect="filterCallback()" />
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
import { computed, ref } from 'vue';
import DatePicker from 'primevue/datepicker';
import Toast from 'primevue/toast';
import { FilterMatchMode } from '@primevue/core/api';
import InputText from 'primevue/inputtext';

const props = defineProps({
    categories: Object,
})

const selectedCategories = ref()

const formattedDateCategories = computed(() => props.categories.map(category => {
        category.created_at = new Date(category.created_at)
        category.updated_at = new Date(category.updated_at)

        return category
    })
)

const filters = ref({
    name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    created_at: { value: null, matchMode: FilterMatchMode.DATE_IS },
    updated_at: { value: null, matchMode: FilterMatchMode.DATE_IS },
});

function onRowSelect(event) {
    router.get(route('admin.categories.edit', { categoryId: event.data.id }))
}


function formatTimestamp(timestamp) {
    return (new Date(timestamp)).toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    })
}

</script>
