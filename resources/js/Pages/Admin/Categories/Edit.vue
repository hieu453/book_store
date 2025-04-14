<template>
    <Dashboard>
        <Toast />
        <Head :title="form.name" />
        <div>
            <h1 class="mb-8 text-3xl font-bold">
                <Link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.categories')">Categories</Link>
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
            <!-- <h2 class="mt-12 text-2xl font-bold">Contacts</h2>
            <div class="mt-6 bg-white rounded shadow overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <tr class="text-left font-bold">
                        <th class="pb-4 pt-6 px-6">Name</th>
                        <th class="pb-4 pt-6 px-6">City</th>
                        <th class="pb-4 pt-6 px-6" colspan="2">Phone</th>
                    </tr>
                    <tr v-for="contact in organization.contacts" :key="contact.id"
                        class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                                :href="`/contacts/${contact.id}/edit`">
                            {{ contact.name }}
                            <icon v-if="contact.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" />
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
                            {{ contact.city }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
                            {{ contact.phone }}
                            </Link>
                        </td>
                        <td class="w-px border-t">
                            <Link class="flex items-center px-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="organization.contacts.length === 0">
                        <td class="px-6 py-4 border-t" colspan="4">No contacts found.</td>
                    </tr>
                </table>
            </div> -->
        </div>
    </Dashboard>
</template>

<script setup>
import LoadingButton from '@/Components/LoadingButton.vue';
import TextInputInertia from '@/Components/TextInputInertia.vue';
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

const props = defineProps({
    category: Object,
    errors: Object,
})

const page = usePage();

const form = useForm({
    name: props.category.name,
})

const toast = useToast();

function update() {
    router.put(route('admin.categories.update', { categoryId: props.category.id }), form, {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        },
    })
}

function destroy() {
    router.delete(route('admin.categories.destroy', { categoryId: props.category.id }), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        }
    })
}
</script>
