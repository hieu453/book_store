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
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left">
                            <th v-if="cancelledOrdersLength > 0" class="pb-4 pt-6 px-4">
                                <input type="checkbox" v-model="selectAll" @change="checkAll">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Mã đơn hàng
                                </h1>
                                <input type="text" v-model="orderId" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Khách hàng
                                </h1>
                                <input type="text" v-model="name" class="font-normal rounded" @input="filter">
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in cancelledOrders.data" :key="order.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t px-4">
                                <input type="checkbox"
                                    v-model="selectedOrderIds"
                                    :checked="selectedOrderIds.includes(order.order_id)"
                                    :value="order.order_id"
                                    @change="select"
                                >
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4 cursor-pointer">
                                    {{ order.order_id }}
                                </div>
                            </td>
                            <td class="border-t">
                                <div class="flex items-center px-6 py-4 cursor-pointer">
                                    {{ order.user.name }}
                                </div>
                            </td>
                        </tr>
                        <tr v-if="cancelledOrders.data.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">Không tìm thấy.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :links="cancelledOrders.links" class="mt-2" />
        </div>
    </Dashboard>
</template>
<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import Toast from 'primevue/toast';
import { ref } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import Pagination from '@/Components/Pagination.vue';
import { debounce } from 'lodash';


const props = defineProps({
    cancelledOrders: Object,
    filters: Object,
    cancelledOrdersLength: Number
})

const toast = useToast();
const page = usePage();
const orderId = ref(props.filters.orderId ?? '')
const name = ref(props.filters.name ?? '')

// Xu ly select
const selectedOrderIds = ref(JSON.parse(localStorage.getItem('selectedOrderIds')) ?? [])
const selectAll = ref(selectedOrderIds.value.length === props.cancelledOrdersLength ? true : false)

async function checkAll() {
    if (selectAll.value) {
        props.cancelledOrders.data.forEach(order => {
            if (!selectedOrderIds.value.includes(order.order_id)) {
                selectedOrderIds.value.push(order.order_id)
            }
        })
    } else {
        props.cancelledOrders.data.forEach(order => {
            if (selectedOrderIds.value.includes(order.order_id)) {
                const index = selectedOrderIds.value.indexOf(order.order_id)
                selectedOrderIds.value.splice(index, 1)
            }
        })
    }

    const res = await axios.post(route('admin.orders.cancelled.check.all'), { selectAll: selectAll.value })
    selectedOrderIds.value = res.data.selectedOrderIds
    localStorage.setItem('selectedOrderIds', JSON.stringify(selectedOrderIds.value))
}

function select() {
    localStorage.setItem('selectedOrderIds', JSON.stringify(selectedOrderIds.value))
    selectAll.value = selectedOrderIds.value.length === props.cancelledOrdersLength ? true : false
}
// Ket thuc xu ly select

const filter = debounce(function () {
    const data = {
        name: name.value,
        orderId: orderId.value,
    }

    const filteredObject = Object.fromEntries(
        Object.entries(data).filter(([_, v]) => v != '')
    )

    router.get(route('admin.orders.cancelled'), filteredObject);
}, 250)

function cancelOrders() {
    if (selectedOrderIds.value.length <= 0) {
        return;
    }

    router.post(route('admin.orders.cancel'), {
        orderIds: selectedOrderIds.value
    }, {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
            localStorage.removeItem('selectedOrderIds')
        }
    });
}
</script>
