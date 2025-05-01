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
                            label="Tên" />
                        <TextInputInertia v-model="form.author" :error="errors.author" class="pb-8 pr-6 w-full lg:w-1/2"
                            label="Tác giả" />
                        <TextInputInertia v-model="form.language" :error="errors.language" class="pb-8 pr-6 w-full lg:w-1/2"
                            label="Ngôn ngữ" />
                        <NumberInputInertia v-model="form.width" :error="errors.width" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                            label="Rộng" />
                        <NumberInputInertia v-model="form.height" :error="errors.height" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                            label="Dày" />
                        <NumberInputInertia v-model="form.weight" :error="errors.weight" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                            label="Nặng" />
                        <NumberInputInertia v-model="form.quantity" :error="errors.quantity" class="pb-8 pr-6 w-full lg:w-1/2"
                            label="Số lượng" />
                        <NumberInputInertia v-model="form.price" :error="errors.price" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                            label="Giá tiên" />
                        <TextInputInertia v-model="form.publisher" :error="errors.publisher" class="pb-8 pr-6 w-full lg:w-1/2"
                            label="Nhà xuất bản" />
                        <TextInputInertia v-model="form.published_date" :error="errors.published_date" type="date" class="pb-8 pr-6 w-full lg:w-1/2"
                            label="Năm xuất bản" />

                        <!-- Can dong thanh component -->
                        <div class="pb-8 pr-6 w-full lg:w-1/2">
                            <label class="form-label">Danh mục</label>
                            <select v-model="form.category_id">
                                <option v-for="category in categories" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        <div v-if="errors.category_id" class="form-error">{{ errors.category_id }}</div>

                        <!-- Images -->
                        <div class="pb-8 pr-6 w-full">
                            <label class="form-label">Hình ảnh</label>
                            <input type="file" @input="form.images = $event.target.files" class="text-black" multiple>
                            <div v-if="errors.images" class="form-error">{{ errors.images }}</div>

                            <div class="mt-4">
                                <ul class="flex justify-start items-center gap-4">
                                    <li v-for="image in product.images">
                                        <div class="flex justify-start items-center gap-2">
                                            <img :src="image.url" alt="" width="100" height="60">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
                        <button
                            class="text-red-600 hover:underline"
                            tabindex="-1"
                            type="button"
                            @click="destroy"
                        >
                            Xóa sản phẩm
                        </button>
                        <LoadingButton :loading="form.processing" class="btn-indigo ml-auto" type="submit">Cập nhật sản phẩm</LoadingButton>
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
    categories: Object,
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
    images: null,
    category_id: props.product.category_id,
    language: props.product.language,
    publisher: props.product.publisher,
    published_date: props.product.published_date,
    _method: 'put',
})

const toast = useToast();
const page = usePage();

function update() {
    router.post(route('admin.products.update', { productId: props.product.id }), form, {
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
