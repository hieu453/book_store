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
                        <button
                            class="text-red-600 hover:underline"
                            tabindex="-1"
                            type="button"
                            @click="destroy"
                        >
                            Xóa đơn hàng
                        </button>
                        <LoadingButton :loading="form.processing" class="btn-indigo ml-auto" type="submit">Cập nhật
                            đơn hàng</LoadingButton>
                    </div>
                </form>
            </div>
            <h2 class="mt-12 text-2xl font-bold">Sản phẩm trong đơn hàng</h2>
            <div class="mt-6 bg-white rounded shadow overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left">
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tên sản phẩm
                                </h1>
                                <input type="text" v-model="productName" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Số lượng
                                </h1>
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Giá tiền
                                </h1>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in orderProducts.data" :key="item.product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="route('admin.products.edit', { productId: item.product.id })">
                                    {{ item.product.name }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.products.edit', { productId: item.product.id })" tabindex="-1">
                                    {{ item.quantity }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.products.edit', { productId: item.product.id })" tabindex="-1">
                                    {{ formatCurrency(item.price) }}
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="orderProducts.data.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">Không tìm thấy sản phẩm nào.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :links="orderProducts.links" class="mt-2" />
        </div>
    </Dashboard>
</template>

<script setup>
import LoadingButton from '@/Components/LoadingButton.vue';
import InfoField from '@/Components/InfoField.vue';
import SelectInputInertia from '@/Components/SelectInputInertia.vue';
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';
import { ref } from 'vue';
import formatCurrency from '@/helper/formatCurrency';
import Pagination from '@/Components/Pagination.vue';
import { debounce } from 'lodash';

const props = defineProps({
    order: Object,
    orderProducts: Object,
    errors: Object,
    filters: Object,
})

const form = useForm({
    status: props.order.status,
})

const status = ref({
    'pending': 'Chờ xác nhận',
    'processing': 'Đang xử lý',
    'completed': 'Hoàn thành',
    'cancelled': 'Đã hủy',
})

const page = usePage();
const toast = useToast();
const productName = ref(props.filters.name ?? '');

const filter = debounce(function () {
    router.get(route('admin.orders.edit', { orderId: props.order.order_id }), {
        productName: productName.value
    }, {
        preserveScroll: true,
        preserveState: true,
    })
}, 250)

function update() {
    router.put(route('admin.orders.update', { orderId: props.order.order_id }), form, {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        }
    })
}

function destroy() {
    router.delete(route('admin.orders.delete', { orderId: props.order.order_id }), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        }
    });
}
</script>
