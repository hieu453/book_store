<template>
    <div class="container px-4 py-8 mx-auto">
        <Toast />
        <Head title="Đơn hàng" />
        <template v-if="orders.length > 0">
            <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-gray-200 dark:border-gray-700 dark:text-gray-400">
                <li v-for="(_, tab) in tabs" class="me-2">
                    <a @click="currentTab = tab"
                        href="#"
                        class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                        :class="{ 'text-blue-600 bg-gray-100 rounded-t-lg active': tab == currentTab }"
                    >
                        {{ tab }}
                    </a>
                </li>
            </ul>
            <component :is="tabs[currentTab]" v-bind="{ ...props }"></component>
        </template>
        <template v-else>
            <div>
                <p>Chưa có đơn hàng nào</p>
            </div>
        </template>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import Completed from './Completed.vue';
import Pending from './Pending.vue';
import Processing from './Processing.vue';
import { Head } from '@inertiajs/vue3';
import Cancelled from './Cancelled.vue';
import Toast from 'primevue/toast';


const props = defineProps({
    orders: Array,
})

const tabs = {
    'Chờ xác nhận': Pending,
    'Đang xử lý': Processing,
    'Hoàn thành': Completed,
    'Đã hủy': Cancelled
}

const currentTab = ref('Chờ xác nhận')


</script>
