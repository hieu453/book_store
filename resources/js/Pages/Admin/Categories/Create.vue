<template>
    <Dashboard>
        <Head title="Create Category" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.categories')">Categories</Link>
            <span class="text-indigo-400 font-medium">/</span> Create
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="store">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <TextInputInertia v-model="form.name" :error="errors.name" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Name" />
                </div>
                <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <LoadingButton :loading="form.processing" class="btn-indigo" type="submit">Create
                        Category</LoadingButton>
                </div>
            </form>
        </div>
    </Dashboard>
</template>

<script setup>
import LoadingButton from '@/Components/LoadingButton.vue';
import TextInputInertia from '@/Components/TextInputInertia.vue';
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";

defineProps({
    errors: Object,
})

const form = useForm({
    name: null
})
const page = usePage()
const toast = useToast();

function store() {
    router.post(route('admin.categories'), form, {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        },
    });
}

</script>
