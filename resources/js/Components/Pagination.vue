<template>
    <ul>
        <template v-for="pageNumber in products.last_page">
            <span v-if="pageNumber == products.last_page && Math.abs(pageNumber - products.current_page) > 3">...</span>
            <li
                v-if="Math.abs(pageNumber - products.current_page) < 3
                || pageNumber == 1
                || pageNumber == products.last_page"
                class="rounded-xl bg-purple-700"
            >
                <Link
                    :href="route('products')"
                    :data="{ page: pageNumber }"
                    :class="{
                        current: pageNumber == products.current_page,
                        // first: (pageNumber == 1 && Math.abs(pageNumber - products.current_page) > 3),
                        // last: (pageNumber == products.last_page && Math.abs(pageNumber - products.current_page) > 3),
                    }"
                >
                    {{ pageNumber }}
                </Link>
            </li>
            <span v-if="pageNumber == 1 && Math.abs(pageNumber - products.current_page) > 3">...</span>
        </template>
    </ul>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    products: {
        type: Object,
    }
})
console.log(props.products)
const itemsPerPage = 3

// const totalPage =
</script>

<style scoped>
li {
    display: inline-block;
    margin: 5px 5px;
}
a.first::after {
    content: '...';
}
a.last::before {
    content: '...';
}
.current {
    color: red;
}
</style>
