<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Đơn hàng" />
            <h1 class="mb-8 text-3xl font-bold">Đơn hàng</h1>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <DataTable
                    :value="orders"
                    v-model:filters="filters"
                    filterDisplay="row"
                    sortMode="multiple"
                    paginator
                    :rows="5"
                    tableStyle="min-width: 50rem"
                    selectionMode="single"
                    @rowSelect="onRowSelect"
                >
                    <template #empty> Chưa có đơn hàng nào. </template>

                    <Column field="order_id" header="Mã đơn hàng" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.order_id }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo mã đơn hàng" />
                        </template>
                    </Column>
                    <Column field="trans_id" header="Mã giao dịch" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.trans_id }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo mã giao dịch" />
                        </template>
                    </Column>
                    <Column field="status" header="Trạng thái" :showFilterMenu="false" style="min-width: 12rem">
                        <template #body="{ data }">
                            <Tag :value="getVietnameseStatus(data.status)" :severity="getSeverity(data.status)" />
                        </template>
                        <template #filter="{ filterModel, filterCallback }">
                            <Select v-model="filterModel.value" @change="filterCallback()" :options="statuses" placeholder="Chọn" style="min-width: 12rem" :showClear="true">
                                <template #option="slotProps">
                                    <Tag :value="getVietnameseStatus(slotProps.option)" :severity="getSeverity(slotProps.option)" />
                                </template>
                            </Select>
                        </template>
                    </Column>
                    <Column field="name" header="Tên" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.name }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo tên" />
                        </template>
                    </Column>
                    <Column field="email" header="Email" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.email }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo email" />
                        </template>
                    </Column>
                    <Column field="phone_number" header="Số điện thoại" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.phone_number }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo số điện thoại" />
                        </template>
                    </Column>
                    <Column field="city" header="Thành phố" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.city }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo thành phố" />
                        </template>
                    </Column>
                    <Column field="district" header="Quận/Huyện" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.district }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo quận/huyện" />
                        </template>
                    </Column>
                    <Column field="ward" header="Xã/Phường" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.ward }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo xã/phường" />
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
                    <Column field="total_price" header="Tổng tiền" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.total_price }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo tổng tiền" />
                        </template>
                    </Column>
                    <Column field="payment_mode" header="Phương thức thanh toán" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.payment_mode }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo phương thức thanh toán" />
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
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Select from 'primevue/select';
import Tag from 'primevue/tag';
import Toast from 'primevue/toast';
import { FilterMatchMode } from '@primevue/core/api';
import InputText from 'primevue/inputtext';

const props = defineProps({
    orders: Object,
})

const statuses = ref([
    'processing',
    'pending',
    'completed',
    'cancelled',
])

const filters = ref({
    order_id: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    trans_id: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    email: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    phone_number: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    city: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    district: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    ward: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    quantity: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    total_price: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    status: { value: null, matchMode: FilterMatchMode.EQUALS },
    payment_mode: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
});

function getSeverity(status) {
    switch (status) {
        case 'processing':
            return 'warn';

        case 'cancelled':
            return 'danger';

        case 'pending':
            return 'info';

        case 'completed':
            return 'success';

    }
}

function getVietnameseStatus(status) {
    switch (status) {
        case 'processing':
            return 'Đang xử lý (processing)';

        case 'pending':
            return 'Chờ xác nhận (pending)';

        case 'cancelled':
            return 'Đã hủy (cancelled)';

        case 'completed':
            return 'Hoàn thành (completed)';
    }
}

function onRowSelect(event) {
    router.get(route('admin.orders.edit', { orderId: event.data.order_id }))
}
</script>
