<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Người dùng" />
            <h1 class="mb-8 text-3xl font-bold">Người dùng</h1>
            <div class="flex items-center justify-between mb-6">
                <Link class="btn-indigo" :href="route('admin.users.create')">
                <span>Tạo</span>
                <span class="hidden md:inline">&nbsp;Người dùng</span>
                </Link>
            </div>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left">
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tên người dùng
                                </h1>
                                <input type="text" v-model="name" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Email
                                </h1>
                                <input type="text" v-model="email" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Vai trò
                                </h1>
                                <select class="font-normal rounded" v-model="role" @change="filter">
                                    <option value=""></option>
                                    <option value="1">Quản trị viên</option>
                                    <option value="0">Khách hàng</option>
                                </select>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="route('admin.users.edit', { userId: user.id })">
                                    {{ user.name }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.users.edit', { userId: user.id })" tabindex="-1">
                                    {{ user.email }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4" :href="route('admin.users.edit', { userId: user.id })" tabindex="-1">
                                    {{ getRole(user.is_admin) }}
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="users.data.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">Không tìm thấy danh mục nào.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :links="users.links" class="mt-2" />
        </div>
    </Dashboard>
</template>
<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Toast from 'primevue/toast';
import Pagination from '@/Components/Pagination.vue';
import { debounce } from 'lodash';

const props = defineProps({
    users: Object,
    filters: Object,
})

const name = ref(props.filters.name ?? '')
const email = ref(props.filters.email ?? '')
const role = ref(props.filters.role ?? '')

function getRole(role) {
    switch (role) {
        case 0:
            return 'Khách hàng';
        case 1:
            return 'Quản trị viên';
    }
}

const filter = debounce(function () {
    const data = {
        name: name.value,
        email: email.value,
        role: role.value,
    }

    const filteredObject = Object.fromEntries(
        Object.entries(data).filter(([_, v]) => v != '')
    )

    router.get(route('admin.users'), filteredObject, {
        preserveScroll: true,
        preserveState: true,
    });
}, 250)
</script>
