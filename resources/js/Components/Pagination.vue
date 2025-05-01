<template>
    <div>
        <!-- <ul class="flex flex-wrap space-y-4 space-x-2 items-center py-2 justify-center">
            <template v-for="link in links">
                <li
                    v-if="link.label === '...'"
                >
                    {{ link.label }}
                </li>
                <li
                    v-if="link.url != null"

                >
                    <Link
                        :href="link.url"
                        :class="[link.active ? 'text-red-600' : 'text-white', 'px-4 py-2 bg-purple-700 rounded-full']"
                    >
                        <span v-html="link.label"></span>
                    </Link>
                </li>
            </template>
        </ul> -->
        <nav aria-label="Page navigation example">
            <ul class="inline-flex flex-wrap gap-x-2 gap-y-1 -space-x-px text-base h-10">
                <template v-for="link in links">
                    <li v-if="link.label === '...'">
                        <span class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ link.label }}</span>
                    </li>
                    <li v-else>
                        <Link
                            v-if="link.url != null"
                            :href="link.url"
                            :class="[link.active ? 'text-blue-600 hover:text-blue-700 hover:bg-blue-100' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' ,'flex items-center justify-center px-4 h-10 leading-tight bg-white border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white']"
                        >
                            <span v-html="link.label"></span>
                        </Link>
                    </li>
                </template>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: Array,
})

</script>
