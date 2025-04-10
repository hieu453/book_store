<template>
    <Dashboard>
        <div>
            <Head title="Categories" />
            <h1 class="mb-8 text-3xl font-bold">Categories</h1>
            <div class="flex items-center justify-between mb-6">
                <Link class="btn-indigo" href="/organizations/create">
                    <span>Create</span>
                    <span class="hidden md:inline">&nbsp;Organization</span>
                </Link>
            </div>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">Name</th>
                            <th class="pb-4 pt-6 px-6">Created At</th>
                            <th class="pb-4 pt-6 px-6">Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr v-for="category in categories.data" :key="category.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('admin.category.edit', { categoryId: category.id })">
                                {{ category.name }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('admin.category.edit', { categoryId: category.id })">
                                {{ category.created_at }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="route('admin.category.edit', { categoryId: category.id })">
                                {{ category.updated_at }}
                                </Link>
                            </td>
                            <td class="w-px border-t">
                                <Link class="flex items-center px-4" :href="route('admin.category.edit', { categoryId: category.id })"
                                    tabindex="-1">
                                <Icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="categories.data.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">No categories found.</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
            <!-- <pagination class="mt-6" :links="organizations.links" /> -->
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';

</script>
