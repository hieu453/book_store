<template>
    <Dashboard>
        <Toast />
        <Head :title="'Đơn hàng ' + order.order_id" />
        <div>
            <h1 class="mb-8 text-3xl font-bold">
                <Link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.orders')">Đơn hàng</Link>
                <span class="text-indigo-400 font-medium">/</span>
                {{ order.order_id }}
            </h1>
            <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
                <form @submit.prevent="update">
                    <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Tên" :info="order.name" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Email" :info="order.email" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Số điện thoại" :info="order.phone_number" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Thành phố" :info="order.city" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Quận/Huyện" :info="order.district" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Phường/Xã" :info="order.ward" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Phương thức thanh toán" :info="order.payment_mode" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Tổng số lượng" :info="order.quantity" />
                        <InfoField class="pb-8 pr-6 w-full lg:w-1/2" label="Tổng tiền" :info="formatCurrency(order.total_price)" />

                        <SelectInputInertia v-model="form.status" :status="status" :order="order" class="pb-8 pr-6 w-full lg:w-1/2" />
                    </div>
                    <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                        <!-- <button
                            class="text-red-600 hover:underline"
                            tabindex="-1"
                            type="button"
                            @click="destroy"
                        >
                            Delete Order
                        </button> -->
                        <LoadingButton :loading="form.processing" class="btn-indigo ml-auto" type="submit">Cập nhật
                            đơn hàng</LoadingButton>
                    </div>
                </form>
            </div>
            <h2 class="mt-12 text-2xl font-bold">Sản phẩm trong đơn hàng</h2>
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
                    <Column field="product.name" header="Tên sản phẩm" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.product.name }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo tên sản phẩm" />
                        </template>
                    </Column>
                    <Column field="quantity" header="Số lượng" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.quantity }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo số lượng" />
                        </template>
                    </Column>
                    <Column field="price" header="Giá tiền" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.price }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo giá" />
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
import formatCurrency from '@/helper/formatCurrency';


const props = defineProps({
    order: Object,
    errors: Object,
})

const form = useForm({
    status: props.order.status,
})

const filters = ref({
    'product.name': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    'quantity': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    'price': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
});

const status = ref({
    'pending': 'Chờ xác nhận',
    'processing': 'Đang xử lý',
    'completed': 'Hoàn thành',
    'cancelled': 'Đã hủy',
})

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
