<template>
    <div class="container px-4 py-8 mx-auto">
        <Head title="Orders" />
        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
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
    </div>
</template>
<script setup>
import { ref } from 'vue';
import Completed from './Completed.vue';
import Pending from './Pending.vue';
import Processing from './Processing.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    ordersPending: Array,
    ordersProcessing: Array,
    ordersCompleted: Array,
})

const tabs = {
    Pending,
    Processing,
    Completed,
}

const currentTab = ref('Pending')


</script>
