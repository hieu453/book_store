<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Người dùng" />
            <h1 class="mb-8 text-3xl font-bold">Người dùng</h1>
            <div class="flex items-center justify-between mb-6">
                <Link class="btn-indigo" :href="route('admin.users.create')">
                <span>Tạo</span>
                <span class="hidden md:inline">&nbsp;Người dùng</span>
                </Link>
            </div>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <DataTable :value="users" v-model:selection="selectedUsers"
                    v-model:filters="filters" filterDisplay="row" dataKey="id" sortMode="multiple" paginator :rows="5"
                    tableStyle="min-width: 50rem" selectionMode="single" @rowSelect="onRowSelect">
                    <template #empty> Chưa có người dùng nào. </template>

                    <Column field="name" header="Tên người dùng" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.name }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo tên người dùng" />
                        </template>
                    </Column>
                    <Column field="email" header="Email" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.email }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo email người dùng" />
                        </template>
                    </Column>
                    <Column field="is_admin" header="Vai trò" :showFilterMenu="false" style="min-width: 12rem">
                        <template #body="{ data }">
                            <Tag :value="getRole(data.is_admin)" />
                        </template>
                        <template #filter="{ filterModel, filterCallback }">
                            <Select v-model="filterModel.value" @change="filterCallback()" class="border" :options="roles" placeholder="Chọn" style="min-width: 12rem" :showClear="true">
                                <template #option="slotProps">
                                    <Tag :value="(slotProps.option)" />
                                </template>
                            </Select>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </Dashboard>
</template>
<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { FilterMatchMode } from '@primevue/core/api';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toast from 'primevue/toast';
import Tag from 'primevue/tag';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';

defineProps({
    users: Object,
})

const selectedUsers = ref()

const filters = ref({
    name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    email: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    is_admin: { value: null, matchMode: FilterMatchMode.EQUALS },
});

const roles = ref([
    0,
    1
])

function getRole(role) {
    switch (role) {
        case 0:
            return 'user (0)'
        case 1:
            return 'admin (1)'
    }
}

function onRowSelect(event) {
    router.get(route('admin.users.edit', { userId: event.data.id }))
}
</script>
