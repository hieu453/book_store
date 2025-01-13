<template>
    <Head title="Products" />
    <div class="container px-5 py-5 mx-auto">
        <div v-if="products.length > 0">
            <DataView
                :value="products"
                :sortField="sortField"
                :sortOrder="sortOrder"
                paginator
                :alwaysShowPaginator="false"
                :rows="9"
                currentPageReportTemplate
                layout="grid"
                :pt="{
                    pcPaginator: {
                        PaginatorContainer: 'mt-2',
                    },
                    // content: 'text-center',
                    header: {
                        style: {
                            border: 'none'
                        }
                    }
                }">
                <template #header>
                    <div class="space-x-2.5 flex justify-center md:justify-end">
                        <Select v-model="sortKey" :options="sortOptions" optionLabel="label" placeholder="Sort By Price" @change="onSortChange($event)" />
                        <Select v-model="sortKey" :options="sortName" optionLabel="label" placeholder="Sort By Name" @change="onSortChange($event)" />
                    </div>
                </template>
                <template #grid="slotProps">
                    <div class="grid md:grid-cols-3 gap-4">
                        <div v-for="product in slotProps.items" :key="product.id">
                            <div class="border rounded-lg h-full max-w-md mx-auto flex flex-col sm:flex-row sm:items-center p-6 gap-4">
                                <div class="md:w-40 relative">
                                    <img class="block xl:block mx-auto rounded w-full"
                                        src="https://eu.rosefieldwatches.com/cdn/shop/files/0008337_315x@2x.jpg?v=1722950153" />
                                    <div class="absolute bg-black/70 rounded-border" style="left: 4px; top: 4px">
                                        <Tag
                                            :severity="product.quantity ? 'success' : 'danger'"
                                            :value="product.quantity ? 'In Stock' : 'Out Of Stock'"
                                        >
                                        </Tag>
                                    </div>
                                </div>
                                <div class="flex flex-col md:flex-row justify-between md:items-center flex-1 gap-6">
                                    <div class="flex flex-row md:flex-col justify-between items-start gap-2">
                                        <div>
                                            <span class="font-medium text-surface-500 dark:text-surface-400 text-sm">{{ product.category.name }}</span>
                                            <div class="text-lg font-medium mt-2">{{ product.name }}</div>
                                        </div>
                                        <div class="bg-surface-100 p-1" style="border-radius: 30px">
                                            <div class="bg-surface-0 flex items-center gap-2 justify-center py-1 px-2"
                                            style="border-radius: 30px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.04), 0px 1px 2px 0px rgba(0, 0, 0, 0.06)">
                                                <span class="text-surface-900 font-medium text-sm">55</span>
                                                <i class="pi pi-star-fill text-yellow-500"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col md:items-end gap-8">
                                        <span class="text-xl font-semibold">${{ product.price }}</span>
                                        <div class="flex flex-row-reverse md:flex-row gap-2">
                                            <Button icon="pi pi-heart" outlined></Button>
                                            <Button icon="pi pi-shopping-cart" label="Buy Now"
                                                class="flex-auto md:flex-initial whitespace-nowrap"></Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </DataView>
        </div>

        <div
            v-else
            class="h-screen text-center content-center"
        >
            <div class="px-5 py-5 rounded max-w-sm mx-auto border rounded-lg">
                <h1 class="text-2xl">No products</h1>
            </div>
        </div>
    </div>

</template>

<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import Tag from 'primevue/tag';
import Button from 'primevue/button';
import DataView from 'primevue/dataview';
import Select from 'primevue/select';
import { ref } from 'vue';

const page = usePage();
const props = defineProps({
    'products': {
        type: Object,
    }
})

const sortKey = ref();
const sortOrder = ref();
const sortField = ref();
const sortOptions = ref([
    {label: 'Price High to Low', value: '!price'},
    {label: 'Price Low to High', value: 'price'},
]);
const sortName = ref([
    {label: 'Name Ascending', value: '!name'},
    {label: 'Name Descending', value: 'name'},
])

const onSortChange = (event) => {
    const value = event.value.value;
    const sortValue = event.value;

    if (value.indexOf('!') === 0) {
        sortOrder.value = -1;
        sortField.value = value.substring(1, value.length);
        sortKey.value = sortValue;
    }
    else {
        sortOrder.value = 1;
        sortField.value = value;
        sortKey.value = sortValue;
    }
};
</script>
