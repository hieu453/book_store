<template>
    <div>
        <ul class="flex space-x-2">
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
                        :class="[link.active ? 'text-red-600' : '', 'px-4 py-2 bg-purple-700 rounded-full text-white']"
                    >
                        <span v-html="link.label"></span>
                    </Link>
                </li>
            </template>
        </ul>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: Array,
})

</script>
