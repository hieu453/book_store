<template>
    <Dashboard>
        <Head title="Dashboard" />
        <div class="mb-6">
            <h1 class="font-bold">Dữ liệu</h1>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-2 items-center">
                <div class="rounded-lg bg-blue-300">
                    <div class="p-2">
                        <h1 class="text-gray-600">Tổng số sản phẩm</h1>
                        <h1 class="text-2xl">{{ productsCount }}</h1>
                    </div>
                </div>
                <div class="rounded-lg bg-green-300">
                    <div class="p-2">
                        <h1 class="text-gray-600">Tổng số danh mục</h1>
                        <h1 class="text-2xl">{{ categoriesCount }}</h1>
                    </div>
                </div>
                <div class="rounded-lg bg-yellow-300">
                    <div class="p-2">
                        <h1 class="text-gray-600">Tổng số người dùng</h1>
                        <h1 class="text-2xl">{{ usersCount }}</h1>
                    </div>
                </div>
                <div class="rounded-lg bg-red-300">
                    <div class="p-2">
                        <h1 class="text-gray-600">Tổng doanh thu</h1>
                        <h1 class="text-2xl">{{ formatCurrency(totalRevenues) }}</h1>
                    </div>
                </div>
                <div class="rounded-lg bg-indigo-300">
                    <div class="p-2">
                        <h1 class="text-gray-600">Tổng số đơn hàng</h1>
                        <h1 class="text-2xl">{{ ordersCount }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h1 class="font-bold">Thống kê doanh thu theo tháng</h1>

            <div class="md:flex gap-2 mt-2 items-center">
                <div class="flex gap-2 items-center">
                    <label>Từ tháng: <input type="month" class="rounded-md" v-model="fromMonth" /></label>
                    <label>Đến tháng: <input type="month" class="rounded-md" v-model="toMonth" /></label>
                </div>
                <button class="mt-2 md:mt-0 btn-indigo" @click="fetchData">Xem thống kê</button>
            </div>

            <canvas ref="chartRef"></canvas>
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import Chart from 'chart.js/auto'
import { onMounted, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import format from '@/helper/formatDateLabel';
import formatCurrency from '@/helper/formatCurrency';


const props = defineProps({
    from: String,
    to: String,
    revenues: Array,
    usersCount: Number,
    categoriesCount: Number,
    productsCount: Number,
    ordersCount: Number,
    totalRevenues: Number,
})

const chartRef = ref(null)

const fromMonth = ref(props.from || '')
const toMonth = ref(props.to || '')
const revenues = ref(props.revenues || []);

function renderChart() {
    const labels = revenues.value.map(item => format(item.month))
    const data = revenues.value.map(item => item.revenue)

    new Chart(chartRef.value, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Doanh thu (VND)',
                data,
                backgroundColor: '#4bc0c0'
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tháng'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Doanh thu (VND)'
                    }
                }
            }
        }
    })
}

function fetchData() {
    if (!fromMonth.value || !toMonth.value) {
        alert('Vui lòng chọn khoảng tháng hợp lệ!')
        return
    }

    router.get(route('admin.dashboard'), {
        from: fromMonth.value,
        to: toMonth.value
    }, {
        preserveScroll: true
    })
}

onMounted(renderChart)
</script>
