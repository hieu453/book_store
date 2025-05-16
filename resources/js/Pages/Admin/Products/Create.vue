<template>
    <Dashboard>
        <Head title="Tạo sản phẩm" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.products')">Sản phẩm</Link>
            <span class="text-indigo-400 font-medium">/</span> Tạo
        </h1>
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="store">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <TextInputInertia v-model="form.name" :error="errors.name" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Tên sản phẩm" />
                    <TextInputInertia v-model="form.author" :error="errors.author" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Tác giả" />
                    <TextInputInertia v-model="form.language" :error="errors.language" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Ngôn ngữ" />
                    <NumberInputInertia v-model="form.width" :error="errors.width" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Rộng" />
                    <NumberInputInertia v-model="form.height" :error="errors.height" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Dài" />
                    <NumberInputInertia v-model="form.weight" :error="errors.weight" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Cân nặng" />
                    <NumberInputInertia v-model="form.quantity" :error="errors.quantity" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Số lượng" />
                    <NumberInputInertia v-model="form.price" :error="errors.price" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Giá" />
                    <NumberInputInertia v-model="form.new_price" :error="errors.new_price" step="0.01" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Giá tiền mới" />
                    <TextInputInertia v-model="form.publisher" :error="errors.publisher" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Nhà xuất bản" />
                    <TextInputInertia v-model="form.published_date" :error="errors.published_date" type="date" class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Ngày xuất bản" />

                    <div class="pb-8 pr-6 w-full lg:w-1/2">
                        <label class="form-label">Mô tả</label>
                        <Textarea v-model="form.description" @input="form.description.trim()" class="flex-auto" autocomplete="off" />
                        <div v-if="errors.description" class="form-error"></div>
                    </div>

                    <!-- can dong thanh component -->
                    <div class="pb-8 pr-6 w-full lg:w-1/2">
                        <label class="form-label">Danh mục</label>
                        <select v-model="form.category_id">
                            <option v-for="category in categories" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <div v-if="errors.category_id" class="form-error">{{ errors.category_id }}</div>
                    </div>

                    <!-- Images -->
                    <div class="pb-8 pr-6 w-full">
                        <label class="form-label">Hình ảnh</label>
                        <input type="file" @input="form.images = $event.target.files" class="text-black" multiple>
                        <div v-if="errors.images" class="form-error">{{ errors.images }}</div>
                    </div>
                </div>
                <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <LoadingButton :loading="form.processing" class="btn-indigo" type="submit">Tạo sản phẩm</LoadingButton>
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
import { Textarea } from 'primevue';

defineProps({
    errors: Object,
    categories: Object,
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
    description: null,
    publisher: null,
    new_price: null,
    category_id: null,
    images: null,
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
