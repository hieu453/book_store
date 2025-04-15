<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Orders" />
            <h1 class="mb-8 text-3xl font-bold">Orders</h1>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <DataTable
                    :value="orders"
                    v-model:selection="selectedOrders"
                    v-model:filters="filters"
                    filterDisplay="row"
                    :globalFilterFields="['name']"
                    sortMode="multiple"
                    paginator
                    :rows="5"
                    tableStyle="min-width: 50rem"
                    selectionMode="single"
                    @rowSelect="onRowSelect"
                >
                    <template #empty> No categories found. </template>

                    <Column field="order_id" header="Order Id" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.order_id }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by order id" />
                        </template>
                    </Column>
                    <Column field="trans_id" header="Transaction Id" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.trans_id }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by transaction id" />
                        </template>
                    </Column>
                    <Column field="fullname" header="Fullname" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.fullname }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by fullname" />
                        </template>
                    </Column>
                    <Column field="email" header="Email" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.email }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by email" />
                        </template>
                    </Column>
                    <Column field="phone_number" header="Phone number" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.phone_number }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by phone number" />
                        </template>
                    </Column>
                    <Column field="city" header="City" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.city }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by city" />
                        </template>
                    </Column>
                    <Column field="district" header="District" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.district }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by district" />
                        </template>
                    </Column>
                    <Column field="ward" header="Ward" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.ward }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by ward" />
                        </template>
                    </Column>
                    <Column field="quantity" header="Quantity" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.quantity }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by quantity" />
                        </template>
                    </Column>
                    <Column field="total_price" header="Total price" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.total_price }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by total price" />
                        </template>
                    </Column>
                    <Column field="status" header="Status" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.status }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by status" />
                        </template>
                    </Column>
                    <Column field="payment_mode" header="Payment mode" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.payment_mode }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by payment mode" />
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

const props = defineProps({
    orders: Object,
})

const selectedOrders = ref()


const filters = ref({
    order_id: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    trans_id: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    fullname: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    email: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    phone_number: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    city: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    district: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    ward: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    quantity: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    total_price: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    status: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    payment_mode: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
});

function onRowSelect(event) {
    router.get(route('admin.orders.edit', { orderId: event.data.order_id }))
}
</script>
