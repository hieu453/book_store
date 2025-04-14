<template>
    <Dashboard>
        <Head title="Create Category" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.products')">Products</Link>
            <span class="text-indigo-400 font-medium">/</span> Create
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="store">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <TextInputInertia v-model="form.name" :error="errors.name" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Name" />
                    <TextInputInertia v-model="form.author" :error="errors.author" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Author" />
                    <TextInputInertia v-model="form.language" :error="errors.language" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Language" />
                    <NumberInputInertia v-model="form.width" :error="errors.width" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Width" />
                    <NumberInputInertia v-model="form.height" :error="errors.height" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Height" />
                    <NumberInputInertia v-model="form.weight" :error="errors.weight" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Weight" />
                    <NumberInputInertia v-model="form.quantity" :error="errors.quantity" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Quantity" />
                    <NumberInputInertia v-model="form.price" :error="errors.price" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Price" />
                    <TextInputInertia v-model="form.publisher" :error="errors.publisher" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Publisher" />
                    <TextInputInertia v-model="form.published_date" :error="errors.pubished_date" type="date" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Published_date" />
                </div>
                <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <LoadingButton :loading="form.processing" class="btn-indigo" type="submit">Create
                        Product</LoadingButton>
                </div>
            </form>
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import TextInputInertia from '@/Components/TextInputInertia.vue';
import NumberInputInertia from '@/Components/NumberInputInertia.vue';
import LoadingButton from '@/Components/LoadingButton.vue';

defineProps({
    errors: Object,
})

const form = useForm({
    name: null,
    author: null,
    language: null,
    width: null,
    height: null,
    weight: null,
    price: null,
    quantity: null,
    publisher: null,
    published_date: null,
})

const toast = useToast();
const page = usePage();

function store() {
    router.post(route('admin.products.store'), form, {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        },
    })
}
</script>
