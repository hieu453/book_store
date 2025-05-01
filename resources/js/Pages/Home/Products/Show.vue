<template>
    <div class="bg-gray-100">
        <Head :title="product.name" />
        <div class="container mx-auto px-4 py-8">
            <Breadcrumb :data="breadCrumb" />
            <div class="flex flex-wrap -mx-4 mt-4">
                <!-- Product Images -->
                <div v-if="product.images.length > 0" class="w-full md:w-1/2 px-4 mb-8">
                    <Swiper
                        :spaceBetween="10"
                        :navigation="true"
                        :thumbs="{ swiper: thumbsSwiper }"
                        :modules="modules"
                        :loop="true"
                        class="mySwiper2"
                    >
                        <SwiperSlide v-for="image in product.images">
                            <img :src="image.url"
                            alt="Product" class="w-full h-96 rounded-lg shadow-md mb-4 select-none" id="mainImage">
                        </SwiperSlide>
                    </swiper>
                    <swiper
                        @swiper="setThumbsSwiper"
                        :spaceBetween="2"
                        :slidesPerView="4"
                        :freeMode="true"
                        :watchSlidesProgress="true"
                        :modules="modules"
                        :loop="true"
                        class="mySwiper"
                    >
                        <SwiperSlide v-for="image in product.images">
                            <img :src="image.url"
                                alt="Thumbnail 1"
                                class="size-16 sm:size-20 object-cover rounded-md cursor-pointer opacity-60 hover:opacity-100 transition duration-300"
                            >
                        </SwiperSlide>
                    </swiper>
                </div>
                <div v-else class="w-full md:w-1/2 px-4 mb-8">
                    <img src=""
                        alt="Product" class="w-full h-96 rounded-lg shadow-md mb-4 select-none" id="mainImage">
                </div>

                <!-- Product Details -->
                <div class="w-full md:w-1/2 px-4">
                    <h2 class="text-3xl font-bold mb-2 dark:text-black">{{ product.name }}</h2>
                    <p class="text-gray-600 mb-4">{{ product.category.name }}</p>
                    <div class="mb-4">
                        <span class="text-2xl font-bold mr-2 dark:text-black">{{ product.price }}đ</span>
                        <!-- <span class="text-gray-500 line-through">$399.99</span> -->
                    </div>
                    <div class="flex items-center mb-4">
                        <svg v-for="i in 5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-yellow-500">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-gray-600">{{ product.reviews.length <= 0 ? 'Chưa có đánh giá nào' : '' }}</span>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2 dark:text-black">Thông tin:</h3>
                        <ul class="list-disc list-inside text-gray-700">
                            <li>Tác giả: {{ product.author }}</li>
                            <li>Kích thước: {{ product.width }} x {{ product.height }}cm</li>
                            <li>Ngôn ngữ: {{ product.language }}</li>
                            <li>Nhà xuất bản: {{ product.publisher }}</li>
                            <li>Năm xuất bản: {{ formatTimestamp(product.published_date) }}</li>
                        </ul>
                    </div>
                    <div class="mb-6">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Số lượng:</label>
                        <input
                            ref="quantity-input"
                            type="number"
                            id="quantity"
                            name="quantity"
                            min="1"
                            value="1"
                            step="1"
                            :max="product.quantity"
                            :disabled="product.quantity == 0"
                            :class="[ product.quantity == 0 ? 'opacity-50' : '', 'w-12 text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50' ]">
                    </div>
                    <div class="sm:flex sm:space-x-4 sm:mb-6">
                        <Toast />
                        <button
                            :disabled="disabled"
                            @click="addToCart"
                            :class="{ 'bg-indigo-900': disabled }"
                            class="bg-indigo-600 mb-2 w-full sm:w-auto sm:mb-0 flex justify-center gap-2 items-center text-white px-6 py-2 rounded-md hover:bg-indigo-900 disabled:cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            Thêm vào giỏ hàng
                        </button>
                        <div class="flex mb-6 sm:mb-0 gap-4 justify-between">
                            <button
                                :disabled="disabled"
                                @click="buyNow"
                                :class="{ 'bg-indigo-600 text-white': disabled }"
                                class="flex justify-center items-center w-full gap-2 border border-indigo-600 text-indigo-600 px-4 py-2 sm:px-6 sm:py-0 rounded-md hover:text-white hover:bg-indigo-600 disabled:cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                                Mua ngay
                            </button>
                            <button
                                :disabled="disabled"
                                @click="addToWishlist"
                                class="bg-gray-200 flex justify-center items-center gap-2 text-gray-800 rounded-md px-4 py-2 sm:px-6 sm:py-0 hover:bg-gray-300 focus:outline-none focus:ring-2 disabled:cursor-not-allowed focus:ring-gray-500 focus:ring-offset-2">
                                <svg v-if="initialInWishlist" xmlns="http://www.w3.org/2000/svg" fill="true" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                                Yêu thích
                            </button>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6">
                        Experience premium sound quality and industry-leading noise
                        cancellation
                        with
                        these wireless headphones. Perfect for music lovers and frequent travelers.
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <h1 class="text-xl">Đánh giá sản phẩm</h1>
                <Review :product="product" />
            </div>

            <div class="mt-4">
                <h1 class="text-xl">Có thể bạn sẽ thích</h1>
                <Swiper
                    :slidesPerView="1"
                    :spaceBetween="30"
                    :breakpoints="{
                        '640': {
                            slidesPerView: 2,
                        },
                        '768': {
                            slidesPerView: 3,
                        },
                        '1024': {
                            slidesPerView: 5,
                        }
                    }"
                    :modules="modules"
                    class="mt-4"
                >
                    <SwiperSlide v-for="product in relatedProducts">
                        <Card style="overflow: hidden; height: 500px;">
                            <template #header>
                                <img v-if="product.images.length > 0" :src="product.images[0].url" style="height: 300px; width: 100%;" />
                                <img v-else src="" alt="product image" style="height: 300px; width: 100%;">
                            </template>
                            <template #title>{{ product.category.name }}</template>
                            <template #subtitle>{{ product.name }}</template>
                            <template #content>
                                <p class="m-0">
                                    {{ product.price }}đ
                                </p>
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
                    </SwiperSlide>
                </Swiper>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Review from '@/Components/Review.vue';
import { computed, onMounted, ref, useTemplateRef } from 'vue';
import Card from 'primevue/card';
import formatTimestamp from '@/helper/formatDate';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { FreeMode, Navigation, Pagination, Thumbs } from 'swiper/modules';
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';

const props = defineProps({
    product: Object,
    isInWishlist: Boolean,
    relatedProducts: Object,
})

const page = usePage();
const breadCrumb = ref([
    {
        label: props.product.category.name,
        link: route('category.show', {
            slug: props.product.category.slug,
            id: props.product.category.id,
            category_name: props.product.category.name,
        }),
    },
])
const disabled = ref(false)
const toast = useToast()
const quantityInput = useTemplateRef('quantity-input')
const user = computed(() => page.props.auth.user)
const productCart = ref({})
const initialInWishlist = ref(props.isInWishlist);

//Swiper
const modules = [FreeMode, Navigation, Thumbs, Pagination]
const thumbsSwiper = ref(null);
const setThumbsSwiper = (swiper) => {
    thumbsSwiper.value = swiper;
};

const totalStars = computed(() => {
    const total = props.product.reviews.reduce((acc, review) => acc + review.rate.stars, 0)

    return total / props.product.reviews.length;
})



// khoi tao gia tri cho 1 san pham (de user thay doi so luong se thay doi theo)
if (user.value != null) {
    productCart.value = {
        productId: props.product.id,
        userId: user.value.id,
        quantity: 1,
    }
}

onMounted(() => {
    quantityInput.value.onchange = function (e) {
        if (this.value < 1) {
            this.value = 1;
        }

        productCart.value.quantity = parseInt(this.value);
    }
})

function addToCart() {
    disabled.value = true;

    axios.post(route('cart.add'), {
        product: productCart.value,
    })
        .then(function (res) {
            disabled.value = false;
            router.reload({ only: ['cartNumber'] })
            toast.add({ severity: 'success', summary: 'Đã thêm vào giỏ hàng', life: 2000 })
        })
        .catch(function (error) {
            disabled.value = false;

            switch (error.status) {
                case 401:
                    toast.add({ severity: 'info', summary: 'Info', detail: 'Bạn cần đăng nhập để thực hiện hành động này', life: 2000 })
                    break;
                case 400:
                    toast.add({ severity: 'info', summary: 'Info', detail: 'Số lượng trong kho không đủ', life: 2000 })
                    break;
                default:
                    toast.add({ severity: 'info', summary: 'Info', detail: error.message, life: 2000 })
                    break;
            }
        })
}

function buyNow() {
    disabled.value = true;
    productCart.value.checked = true;

    axios.post(route('cart.add'), {
        product: productCart.value
    })
        .then(function (res) {
            router.get(route('cart'), {}, {
                onSuccess: () => {
                    disabled.value = false;
                }
            })
        })
        .catch(function (error) {
            disabled.value = false;

            switch (error.status) {
                case 401:
                    toast.add({ severity: 'info', summary: 'Info', detail: 'Bạn cần đăng nhập để thực hiện hành động này', life: 2000 })
                    break;
                case 400:
                    toast.add({ severity: 'info', summary: 'Info', detail: 'Số lượng trong kho không đủ', life: 2000 })
                    break;
                default:
                    toast.add({ severity: 'info', summary: 'Info', detail: error.message, life: 2000 })
                    break;
            }
        })
}

async function addToWishlist() {
    try {
        const res = await axios.post(route('wishlist.add', { productId: props.product.id }))
        initialInWishlist.value = !initialInWishlist.value
        toast.add({ severity: 'success', summary: res.data.message, life: 2000 })
        router.reload({
            only: ['isInWishlist']
        })
    } catch (error) {
        switch (error.status) {
            case 401:
                toast.add({ severity: 'info', summary: 'Info', detail: 'Bạn cần đăng nhập để thực hiện hành động này', life: 2000 })
                break;
            default:
                toast.add({ severity: 'info', summary: 'Info', detail: error.message, life: 2000 })
                break;
        }
    }
}

</script>

<style scoped>
.mySwiper2 {
  height: 80%;
  width: 100%;
}

.mySwiper {
  height: 20%;
  box-sizing: border-box;
  padding: 10px 0;
}

.mySwiper .swiper-slide {
  width: 25%;
  height: 100%;
  opacity: 0.4;
}

.mySwiper .swiper-slide-thumb-active {
  opacity: 1;
}
</style>
