<template>
<Dashboard>
        <Toast />
        <Head :title="'Order' + order.order_id" />
        <div>
            <h1 class="mb-8 text-3xl font-bold">
                <Link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.orders')">Orders</Link>
                <span class="text-indigo-400 font-medium">/</span>
                {{ order.order_id }}
            </h1>
            <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
                <form @submit.prevent="update">
                    <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Fullname" :info="order.fullname" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Email" :info="order.email" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Phone number" :info="order.phone_number" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="City" :info="order.city" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="District" :info="order.district" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Ward" :info="order.ward" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Payment mode" :info="order.payment_mode" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Total quantity" :info="order.quantity" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Total price" :info="order.total_price" />

                        <SelectInputInertia v-model="form.status" :status="status" :order="order" class="pb-8 pr-6 w-full lg:w-1/2" />
                    </div>
                    <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                        <button
                            class="text-red-600 hover:underline"
                            tabindex="-1"
                            type="button"
                            @click="destroy"
                        >
                            Delete Order
                        </button>
                        <LoadingButton :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update
                            Order</LoadingButton>
                    </div>
                </form>
            </div>
            <h2 class="mt-12 text-2xl font-bold">Order Items</h2>
            <div class="mt-6 bg-white rounded shadow overflow-x-auto">
                <DataTable
                    :value="order.order_items"
                    v-model:filters="filters"
                    filterDisplay="row"
                    :globalFilterFields="['product.name']"
                    sortMode="multiple"
                    paginator
                    :rows="5"
                    tableStyle="min-width: 50rem"
                    selectionMode="single"
                >
                    <template #empty> No order items found. </template>

                    <Column field="product.name" header="Product Name" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.product.name }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by product name" />
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
                    <Column field="price" header="Price" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.price }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Search by price" />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </Dashboard>
</template>

<script setup>
import LoadingButton from '@/Components/LoadingButton.vue';
import InfoField from '@/Components/InfoField.vue';
import DataTable from 'primevue/datatable';
import { FilterMatchMode } from '@primevue/core/api';
import InputText from 'primevue/inputtext';
import Column from 'primevue/column';
import SelectInputInertia from '@/Components/SelectInputInertia.vue';
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';
import { ref } from 'vue';


const props = defineProps({
    order: Object,
    errors: Object,
})

const form = useForm({
    status: props.order.status,
})
console.log(form.status);


const filters = ref({
    'product.name': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    'quantity': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    'price': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
});

const status = ref([
    'pending',
    'processing',
    'completed',
    'failed',
])

const page = usePage();
const toast = useToast();

function update() {
    router.put(route('admin.orders.update', { orderId: props.order.order_id }), form, {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        }
    })
}
</script>
