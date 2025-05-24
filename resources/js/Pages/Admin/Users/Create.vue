<template>
    <Dashboard>
        <Toast />
        <Head title="Tạo người dùng" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.users')">Người dùng</Link>
            <span class="text-indigo-400 font-medium">/</span> Tạo
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="store">
                <div class="flex flex-wrap -mb-8 -mr-6 p-4">
                    <TextInputInertia v-model="form.name" :error="errors.name" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Tên" />
                </div>
                <div class="flex flex-wrap -mb-8 -mr-6 p-4">
                    <TextInputInertia v-model="form.email" :error="errors.email" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Email" />
                </div>
                <div class="flex flex-wrap -mb-8 -mr-6 p-4">
                    <TextInputInertia v-model="form.password" type="password" :error="errors.password" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Mật khẩu" />
                </div>
                <div class="flex flex-wrap -mb-8 -mr-6 p-4">
                    <TextInputInertia v-model="form.password_confirmation" type="password" :error="errors.password_confirmation" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Xác nhận mật khẩu" />
                </div>

                <div class="flex flex-wrap -mb-8 -mr-6 p-4">
                    <div class="pb-8 pr-6 w-full lg:w-1/2">
                        <label class="form-label">Vai trò</label>
                        <select class="rounded" v-model="form.role">
                            <option value="0">Khách hàng</option>
                            <option value="1">Quản trị viên</option>
                        </select>
                        <div v-if="errors.role" class="form-error">{{ role }}</div>
                    </div>
                </div>

                <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <LoadingButton :loading="form.processing" class="btn-indigo" type="submit">Tạo danh mục</LoadingButton>
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
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';

defineProps({
    errors: Object
})

const page = usePage();
const toast = useToast()

const form = useForm({
    name: '',
    email: '',
    role: 0,
    password: '',
    password_confirmation: '',
})

function store() {
    router.post(route('admin.users.store'), form, {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        }
    });
}
</script>
