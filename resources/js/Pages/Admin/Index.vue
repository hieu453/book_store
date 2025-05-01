<template>
    <Dashboard>
        <div>
            <h2>Thống kê doanh thu theo tháng</h2>

            <div class="filters">
                <label>Từ tháng: <input type="month" v-model="fromMonth" /></label>
                <label>Đến tháng: <input type="month" v-model="toMonth" /></label>
                <button class="mt-2 btn-indigo" @click="fetchData">Xem thống kê</button>
            </div>

            <canvas ref="chartRef"></canvas>
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import Chart from 'chart.js/auto'
import { onMounted, ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    from: String,
    to: String,
    revenues: Array,
})

const chartRef = ref(null)
let chartInstance = null

const fromMonth = ref(props.from || '')
const toMonth = ref(props.to || '')
const revenues = ref(props.revenues || []);

function renderChart() {
    if (chartInstance) chartInstance.destroy()

    const labels = revenues.value.map(item => item.month)
    const data = revenues.value.map(item => item.revenue)

    chartInstance = new Chart(chartRef.value, {
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
                        text: 'Doanh thu'
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
