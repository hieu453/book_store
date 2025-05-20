<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Đơn hàng" />
            <h1 class="mb-8 text-3xl font-bold">Đơn hàng</h1>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <!-- <DataTable
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
                            <Select v-model="filterModel.value" @change="filterCallback()" class="border" :options="statuses" placeholder="Chọn" style="min-width: 12rem" :showClear="true">
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
                </DataTable> -->
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left">
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Mã đơn hàng
                                </h1>
                                <input type="number" v-model="orderId" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Mã giao dịch
                                </h1>
                                <input type="number" v-model="transId" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Trạng thái
                                </h1>
                                <select v-model="status" class="font-normal rounded" @change="filter">
                                    <option value=""></option>
                                    <option value="pending">Chờ xác nhận</option>
                                    <option value="processing">Đang xử lý</option>
                                    <option value="completed">Hoàn thành</option>
                                    <option value="cancelled">Đã hủy</option>
                                </select>
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tên khách hàng
                                </h1>
                                <input type="text" v-model="name" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Email
                                </h1>
                                <input type="text" v-model="email" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    SĐT
                                </h1>
                                <input type="text" v-model="phoneNumber" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Thành phố
                                </h1>
                                <input type="text" v-model="city" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Quận/Huyện
                                </h1>
                                <input type="text" v-model="district" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Xã/Phường
                                </h1>
                                <input type="text" v-model="ward" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Phương thức thanh toán
                                </h1>
                                <input type="text" v-model="paymentMode" class="font-normal rounded" @input="filter">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders.data" :key="order.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="route('admin.orders.edit', { orderId: order.order_id })">
                                    {{ order.order_id }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.orders.edit', { orderId: order.order_id })" tabindex="-1">
                                    {{ order.trans_id }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.orders.edit', { orderId: order.order_id })" tabindex="-1">
                                    {{ getVietnameseStatus(order.status) }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.orders.edit', { orderId: order.order_id })" tabindex="-1">
                                    {{ order.name }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.orders.edit', { orderId: order.order_id })" tabindex="-1">
                                    {{ order.email }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.orders.edit', { orderId: order.order_id })" tabindex="-1">
                                    {{ order.phone_number }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.orders.edit', { orderId: order.order_id })" tabindex="-1">
                                    {{ order.city }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.orders.edit', { orderId: order.order_id })" tabindex="-1">
                                    {{ order.district }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.orders.edit', { orderId: order.order_id })" tabindex="-1">
                                    {{ order.ward }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.orders.edit', { orderId: order.order_id })" tabindex="-1">
                                    {{ order.payment_mode }}
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="orders.data.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">Không tìm thấy sản phẩm nào.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :links="orders.links" class="mt-2" />
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Toast from 'primevue/toast';
import Pagination from '@/Components/Pagination.vue';
import { debounce } from 'lodash';

const props = defineProps({
    orders: Object,
    filters: Object,
})

const orderId = ref(props.filters.orderId ?? '')
const transId = ref(props.filters.transId ?? '')
const status = ref(props.filters.status ?? '')
const name = ref(props.filters.name ?? '')
const email = ref(props.filters.email ?? '')
const phoneNumber = ref(props.filters.phoneNumber ?? '')
const city = ref(props.filters.city ?? '')
const district = ref(props.filters.district ?? '')
const ward = ref(props.filters.ward ?? '')
const paymentMode = ref(props.filters.paymentMode ?? '')

function getVietnameseStatus(status) {
    switch (status) {
        case 'processing':
            return 'Đang xử lý';

        case 'pending':
            return 'Chờ xác nhận';

        case 'cancelled':
            return 'Đã hủy';

        case 'completed':
            return 'Hoàn thành';
    }
}

const filter = debounce(function () {
    const data = {
        orderId: orderId.value,
        transId: transId.value,
        status: status.value,
        name: name.value,
        email: email.value,
        phoneNumber: phoneNumber.value,
        city: city.value,
        district: district.value,
        ward: ward.value,
        paymentMode: paymentMode.value,
    }

    const filteredObject = Object.fromEntries(
        Object.entries(data).filter(([_, v]) => v != '')
    )

    router.get(route('admin.orders'), filteredObject, {
        preserveState: true,
    });
}, 250)

</script>

<style scoped>
.pending {
    color: green;
}
</style>
