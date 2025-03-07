<template>
    <ul class="space-x-2 flex justify-center items-center">
        <Link
            :href="route('products')"
            :data="{ page: 1 }"
            :class="[
                products.current_page == 1
                ? 'pointer-events-none opacity-20'
                : 'hover:bg-slate-500 hover:text-white'
                , 'rounded-full w-10 h-10 flex items-center justify-center'
            ]"
        >
            <i class="pi pi-angle-double-left"></i>
        </Link>
        <template v-for="pageNumber in products.last_page">
            <span v-if="pageNumber == products.last_page && Math.abs(pageNumber - products.current_page) > centerNumber">...</span>
            <li
                v-if="Math.abs(pageNumber - products.current_page) < centerNumber
                || pageNumber == 1
                || pageNumber == products.last_page"
            >
                <Link
                    :href="route('products')"
                    :data="{ page: pageNumber }"
                    :class="[
                        pageNumber == products.current_page
                            ? 'text-white bg-purple-400'
                            : 'hover:bg-slate-500 hover:text-white transition ease-in-out'
                            , 'rounded-full w-10 h-10 flex items-center justify-center'
                    ]"
                >
                    {{ pageNumber }}
                </Link>
            </li>
            <span v-if="pageNumber == 1 && Math.abs(pageNumber - products.current_page) > centerNumber">...</span>
        </template>
         <Link
            :href="route('products')"
            :data="{ page: products.last_page }"
            :class="[
                products.current_page == products.last_page
                ? 'pointer-events-none opacity-20'
                : 'hover:bg-slate-500 hover:text-white'
                , 'rounded-full w-10 h-10 flex items-center justify-center'
            ]"
         >
            <i class="pi pi-angle-double-right"></i>
        </Link>
    </ul>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    products: {
        type: Object,
    }
})

const centerNumber = 3;
</script>
