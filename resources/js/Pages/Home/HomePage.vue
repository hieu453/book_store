<template>
    <div class="container px-4 py-8 mx-auto">

        <Head title="Trang chủ" />
        <Breadcrumb />
        <div class="mt-2">
            <Swiper
                :spaceBetween="30"
                :centeredSlides="true"
                :loop="true"
                :autoplay="{
                    delay: 2500,
                    disableOnInteraction: false,
                }"
                :pagination="{
                    clickable: true,
                }"
                :navigation="true"
                :modules="modules"
            >
                <swiper-slide v-for="banner in banners">
                    <img :src="banner" class="rounded-md" alt="banner">
                </swiper-slide>
            </Swiper>
        </div>

        <div class="mt-6 text-center">
            <h1 class="text-3xl my-4 font-bold">Sản phẩm mới</h1>
            <div class="grid md:grid-cols-3 gap-4">
                <template v-if="newProducts.length > 0">
                    <template v-for="product in newProducts" :key="product.id">
                        <Card style="overflow: hidden; min-height: 500px;">
                            <template #header>
                                <img v-if="product.images.length > 0" :src="product.images[0].url" style="height: 300px; width: 100%;" />
                                <img v-else src="" alt="product image" style="height: 300px;">
                            </template>
                            <template #title>
                                <div class="line-clamp-1 has-tooltip">
                                    <h1>
                                        {{ product.name }}
                                    </h1>
                                    <div class="tooltip text-sm font-thin -mt-20 bg-gray-100 shadow-md text-black rounded-sm p-2">
                                        {{ product.name }}
                                    </div>
                                </div>
                            </template>
                            <template #content>
                                <span class="text-xl font-bold mr-2 dark:text-black">{{ formatCurrency(product.new_price ?? product.price) }}</span>
                                <span v-if="product.new_price" class="text-gray-500 line-through">{{ formatCurrency(product.price) }}</span>
                            </template>
                            <template #footer>
                                <div class="flex gap-2 mt-1 items-center">
                                    <Link
                                        :href="route('product.show', {
                                            slug: product.slug,
                                            id: product.id,
                                        })"
                                        class="w-full btn bg-purple-800 hover:bg-purple-600">
                                        Xem
                                    </Link>
                                </div>
                            </template>
                        </Card>
                    </template>
                </template>
            </div>
        </div>

        <div class="mt-6 text-center">
            <h1 class="text-3xl my-4 font-bold">Sách bán chạy</h1>
            <div class="grid md:grid-cols-3 gap-4">
                <template v-if="bestSellingProducts.length > 0">
                    <template v-for="product in bestSellingProducts" :key="product.id">
                        <Card style="overflow: hidden; min-height: 500px;">
                            <template #header>
                                <img v-if="product.images.length > 0" :src="product.images[0].url" style="height: 300px; width: 100%;" />
                                <img v-else src="" alt="product image" style="height: 300px;">
                            </template>
                            <template #title>
                                <div class="line-clamp-1 has-tooltip">
                                    <h1>
                                        {{ product.name }}
                                    </h1>
                                    <div class="tooltip text-sm font-thin -mt-20 bg-gray-100 shadow-md text-black rounded-sm p-2">
                                        {{ product.name }}
                                    </div>
                                </div>
                            </template>
                            <template #content>
                                <span class="text-xl font-bold mr-2 dark:text-black">{{ formatCurrency(product.new_price ?? product.price) }}</span>
                                <span v-if="product.new_price" class="text-gray-500 line-through">{{ formatCurrency(product.price) }}</span>
                            </template>
                            <template #footer>
                                <div class="flex gap-2 mt-1 items-center">
                                    <Link
                                        :href="route('product.show', {
                                            slug: product.slug,
                                            id: product.id,
                                        })"
                                        class="w-full btn bg-purple-800 hover:bg-purple-600">
                                        Xem
                                    </Link>
                                </div>
                            </template>
                        </Card>
                    </template>
                </template>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import Card from 'primevue/card';
import formatCurrency from '@/helper/formatCurrency';

const props = defineProps({
    banners: Array,
    newProducts: Object,
    bestSellingProducts: Object,
})

const modules = [ Autoplay, Pagination, Navigation ]
</script>
