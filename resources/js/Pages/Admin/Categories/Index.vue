<template>
    <Dashboard>
        <Toast />
        <div>
            <Head title="Danh mục" />
            <h1 class="mb-8 text-3xl font-bold">Danh mục</h1>
            <div class="flex items-center justify-between mb-6">
                <Link class="btn-indigo" :href="route('admin.categories.create')">
                <span>Tạo</span>
                <span class="hidden md:inline">&nbsp;Danh mục</span>
                </Link>
            </div>

            <div class="bg-white rounded-md shadow overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left">
                            <th class="pb-4 pt-6 px-4">
                                <input type="checkbox" v-model="selectAll" @change="checkAll">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tên danh mục
                                </h1>
                                <input type="text" v-model="name" class="font-normal rounded" @input="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6">
                                <h1>
                                    Tạo lúc
                                </h1>
                                <input type="date" v-model="created_at" class="font-normal rounded" @change="filter">
                            </th>
                            <th class="pb-4 pt-6 px-6" colspan="2">
                                <h1>
                                    Sửa lúc
                                </h1>
                                <input type="date" v-model="updated_at" class="font-normal rounded" @change="filter">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories.data" :key="category.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t px-4">
                                <input type="checkbox"
                                    v-model="selectedIds"
                                    :checked="selectedIds.includes(category.id)"
                                    :value="category.id"
                                    @change="select"
                                >
                            </td>
                            <td class="border-t">
                            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="route('admin.categories.edit', { categoryId: category.id })">
                                {{ category.name }}
                            </Link>
                            </td>
                            <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="route('admin.categories.edit', { categoryId: category.id })" tabindex="-1">
                                {{ formatTimestamp(category.created_at) }}
                            </Link>
                            </td>
                            <td class="border-t">
                            <Link class="flex items-center px-6 py-4" :href="route('admin.categories.edit', { categoryId: category.id })" tabindex="-1">
                                {{ formatTimestamp(category.updated_at) }}
                            </Link>
                            </td>
                        </tr>
                        <tr v-if="categories.data.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">No categorys found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Pagination :links="categories.links" class="mt-2" />
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
    categories: Object,
    filters: Object,
    categoriesLength: Number,
})

const name = ref(props.filters.name ?? '');
const created_at = ref(props.filters.created_at ?? '');
const updated_at = ref(props.filters.updated_at ?? '')

// Xu ly select checkbox
const selectedIds = ref(JSON.parse(localStorage.getItem('selectedIds')) ?? [])
const selectAll = ref(selectedIds.value.length === props.categoriesLength ? true : false)

async function checkAll() {
    if (selectAll.value) {
        props.categories.data.forEach(category => {
            if (!selectedIds.value.includes(category.id)) {
                selectedIds.value.push(category.id)
            }
        })
    } else {
        props.categories.data.forEach(category => {
            if (selectedIds.value.includes(category.id)) {
                const index = selectedIds.value.indexOf(category.id)
                selectedIds.value.splice(index, 1)
            }
        })
    }

    const res = await axios.post(route('admin.categories.check.all'), { selectAll: selectAll.value })
    selectedIds.value = res.data.selectedIds
    localStorage.setItem('selectedIds', JSON.stringify(selectedIds.value))
}

function select() {
    localStorage.setItem('selectedIds', JSON.stringify(selectedIds.value))
    selectAll.value = selectedIds.value.length === props.categoriesLength ? true : false
}
// Ket thuc xu ly checkbox

const filter = debounce(function () {
    const data = {
        name: name.value,
        created_at: created_at.value,
        updated_at: updated_at.value,
    }

    const filteredObject = Object.fromEntries(
        Object.entries(data).filter(([_, v]) => v != '')
    )

    router.get(route('admin.categories'), filteredObject);
}, 250)

function formatTimestamp(timestamp) {
    return (new Date(timestamp)).toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    })
}

</script>
