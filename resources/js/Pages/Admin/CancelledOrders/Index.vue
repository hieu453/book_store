<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Yêu cầu hủy đơn hàng" />
            <h1 class="mb-8 text-3xl font-bold">Yêu cầu hủy đơn hàng</h1>
            <div class="flex items-center justify-between mb-6">
                <button
                    :class="[ selectedOrderIds.length > 0 ? 'btn-indigo' : 'btn-gray cursor-not-allowed' ]"
                    @click="cancelOrders"
                >
                <span>Hủy</span>
                <span class="hidden md:inline">&nbsp;Đơn hàng</span>
                </button>
            </div>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <DataTable
                    :value="cancelledOrders"
                    v-model:selection="selectedOrders"
                    v-model:filters="filters"
                    filterDisplay="row"
                    sortMode="multiple"
                    paginator
                    :rows="5"
                    tableStyle="min-width: 50rem"
                    selectionMode="multiple"
                    @rowSelect="onRowSelect"
                    @rowSelectAll="onSelectAll"
                    @rowUnselect="onRowUnselect"
                    @rowUnselectAll="onUnselectAll"
                >
                    <template #empty> Chưa có yêu cầu nào. </template>

                    <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                    <Column field="id" header="#" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.id }}
                        </template>
                    </Column>
                    <Column field="order_id" header="Mã đơn hàng" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.order_id }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo mã đơn hàng" />
                        </template>
                    </Column>
                    <Column field="user.name" header="Người dùng" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.user.name }}
                        </template>
                        <template #filter="{filterModel, filterCallback}">
                            <InputText v-model="filterModel.value" type="text" @input="filterCallback()"
                                placeholder="Tìm theo tên người dùng" />
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
import Toast from 'primevue/toast';
import { FilterMatchMode } from '@primevue/core/api';
import InputText from 'primevue/inputtext';
import { ref } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";


const props = defineProps({
    cancelledOrders: Array,
})

const selectedOrders = ref()
const selectedOrderIds = ref([])
const toast = useToast();
const page = usePage();

const filters = ref({
    order_id: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    'user.name': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    // status: { value: null, matchMode: FilterMatchMode.EQUALS },
})

function onRowSelect(event) {
    selectedOrderIds.value = selectedOrders.value.map(selectedOrder => selectedOrder.order_id)
}

function onRowUnselect() {
    selectedOrderIds.value = selectedOrders.value.map(selectedOrder => selectedOrder.order_id)
}

function onSelectAll(event) {
    selectedOrderIds.value = event.data.map(item => item.order_id)
}

function onUnselectAll() {
    selectedOrderIds.value = []
}

function cancelOrders() {
    if (selectedOrderIds.value.length <= 0) {
        return;
    }

    router.post(route('admin.orders.cancel'), {
        order_ids: selectedOrderIds.value
    }, {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        }
    });
}
</script>
