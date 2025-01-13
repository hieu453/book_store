<template>
    <Head title="Products" />
    <div class="container px-5 py-5 mx-auto">
        <DataView
            v-if="products.length > 0"
            :value="products"
            paginator
            :alwaysShowPaginator="false"
            :rows="9"
            currentPageReportTemplate
            layout="grid"
            :pt="{
                pcPaginator: {
                    PaginatorContainer: 'mt-2',
                },
                content: 'text-center'
            }">
            <template #grid="slotProps">
                <div class="grid md:grid-cols-3 gap-4">
                    <div v-for="product in slotProps.items">
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
import { Head } from '@inertiajs/vue3';
import Tag from 'primevue/tag';
import Button from 'primevue/button';
import DataView from 'primevue/dataview';

const props = defineProps({
    'products': {
        type: Object,
    }
})

console.log(props.products)
</script>
