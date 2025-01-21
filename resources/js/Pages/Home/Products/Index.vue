<template>
    <div class="container px-4 py-8 mx-auto">
        <Head title="Products" />
        <Breadcrumb :data="breadCrumb" />
        <WhenVisible data="permissions" :buffer="500">
            <template #fallback>
                <DataView :value="products" layout="grid">
                    <template #grid>
                        <div class="grid md:grid-cols-3">
                            <div v-for="i in 12" :key="i" class="col-12 sm:col-6 lg:col-12 xl:col-4 p-2">
                                <div class="p-4 border-1 surface-border surface-card border-round">
                                    <div class="flex flex-wrap align-items-center justify-content-between gap-2">
                                        <Skeleton class="w-6rem border-round h-2rem" />
                                        <Skeleton class="w-3rem border-round h-1rem" />
                                    </div>
                                    <div class="flex flex-column align-items-center gap-3 py-5">
                                        <Skeleton class="w-9 border-round h-10rem" />
                                        <Skeleton class="w-8rem border-round h-2rem" />
                                        <Skeleton class="w-6rem border-round h-1rem" />
                                    </div>
                                    <div class="flex align-items-center justify-content-between">
                                        <Skeleton class="w-4rem border-round h-2rem" />
                                        <Skeleton shape="circle" class="w-3rem h-3rem" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </DataView>
            </template>

            <div class="">
                <div v-if="products.length > 0">
                    <DataView
                        :value="products"
                        :sortField="sortField"
                        :sortOrder="sortOrder"
                        paginator
                        :alwaysShowPaginator="false"
                        :rows="12"
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
                            <div class="grid md:grid-cols-4 gap-4">
                                <div v-for="product in slotProps.items" :key="product.id">
                                    <Card style="overflow: hidden;">
                                        <template #header>
                                            <img alt="user header" src="https://primefaces.org/cdn/primevue/images/usercard.png" />
                                        </template>
                                        <template #title>{{ product.category.name }}</template>
                                        <template #subtitle>{{ product.name }}</template>
                                        <template #content>
                                            <p class="m-0">
                                                ${{ product.price }}
                                            </p>
                                        </template>
                                        <template #footer>
                                            <div class="flex gap-2 mt-1 items-center">
                                                <Link
                                                    :href="route('product.show', {
                                                        slug: product.slug,
                                                        id: product.id,
                                                    })"
                                                    class="w-full btn bg-purple-800 hover:bg-purple-600">
                                                    View
                                                </Link>
                                            </div>
                                        </template>
                                    </Card>
                                </div>
                            </div>
                        </template>
                    </DataView>
                </div>

                <div
                    v-else
                    class="h-screen text-center content-center"
                >
                    <div class="px-5 py-5 max-w-sm mx-auto border rounded-lg">
                        <h1 class="text-2xl">No products</h1>
                    </div>
                </div>
            </div>
        </WhenVisible>
    </div>
</template>

<script setup>
import { Head, WhenVisible, Link } from '@inertiajs/vue3';
import DataView from 'primevue/dataview';
import Select from 'primevue/select';
import Skeleton from 'primevue/skeleton';
import Card from 'primevue/card';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { ref } from 'vue';

const props = defineProps({
    'products': {
        type: Object,
    }
})

const breadCrumb = ref([
    {
        label: 'Products',
    }
])

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
