<template>
    <Dashboard>
        <Toast />
        <Head :title="form.name" />
        <div>
            <h1 class="mb-8 text-3xl font-bold">
                <Link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.products')">Products</Link>
                <span class="text-indigo-400 font-medium">/</span>
                {{ form.name }}
            </h1>
            <!-- <trashed-message v-if="organization.deleted_at" class="mb-6" @restore="restore"> This organization has been
                deleted. </trashed-message> -->
            <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
                <form @submit.prevent="update">
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
                        <TextInputInertia v-model="form.published_date" :error="errors.published_date" type="date" class="pb-8 pr-6 w-full lg:w-1/2"
                            label="Published date" />
                    </div>
                    <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                        <button
                            class="text-red-600 hover:underline"
                            tabindex="-1"
                            type="button"
                            @click="destroy"
                        >
                            Delete Category
                        </button>
                        <LoadingButton :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update
                            Category</LoadingButton>
                    </div>
                </form>
            </div>
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import TextInputInertia from '@/Components/TextInputInertia.vue';
import LoadingButton from '@/Components/LoadingButton.vue';
import NumberInputInertia from '@/Components/NumberInputInertia.vue';

const props = defineProps({
    product: Object,
    errors: Object,
})

const form = useForm({
    name: props.product.name,
    author: props.product.author,
    width: props.product.width,
    height: props.product.height,
    weight: props.product.weight,
    quantity: props.product.quantity,
    price: props.product.price,
    language: props.product.language,
    publisher: props.product.publisher,
    published_date: props.product.published_date,
})

const toast = useToast();
const page = usePage();

function update() {
    router.put(route('admin.products.update', { productId: props.product.id }), form, {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        },
    })
}

function destroy() {
    router.delete(route('admin.products.destroy', { productId: props.product.id }), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        },
    })
}
</script>
