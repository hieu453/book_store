<template>
    <div class="flex flex-col">
        <div class="sticky top-0 z-10">
            <Disclosure as="nav" class="bg-blue-600" v-slot="{open}">
                <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                    <div class="relative flex h-16 items-center justify-between">
                        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                            <!-- Mobile menu button-->
                            <DisclosureButton
                                class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                                <span class="absolute -inset-0.5" />
                                <span class="sr-only">Open main menu</span>
                                <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true" />
                                <XMarkIcon v-else class="block size-6" aria-hidden="true" />
                            </DisclosureButton>
                        </div>
                        <div class="flex items-center justify-center sm:items-stretch sm:justify-start">
                            <div class="flex shrink-0 items-center">
                                <img class="h-8 w-auto"
                                    src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                                    alt="Your Company" />
                            </div>
                            <div class="hidden sm:ml-6 sm:block">
                                <div class="flex space-x-4">
                                    <div class="group relative cursor-pointer">
                                        <div class="flex justify-between text-gray-300 hover:bg-gray-700 hover:text-white rounded-md space-x-2 px-3 py-2">
                                            <a class="menu-hover text-sm font-medium">
                                                Danh mục
                                            </a>
                                            <span>
                                                <i class="pi pi-bars"></i>
                                            </span>
                                        </div>
                                        <div class="invisible md:w-max md:text-center md:grid md:grid-cols-3 absolute z-50 flex flex-col bg-gray-100 py-1 px-4 text-gray-800 shadow-xl group-hover:visible">
                                            <Link
                                                v-for="category in categories"
                                                :href="route('category.show', { slug: category.slug })"
                                                class="my-2 block border-b border-b-slate-600 py-1 font-semibold text-gray-500 hover:text-black md:mx-2"
                                            >
                                                {{ category.name }}
                                            </Link>
                                        </div>
                                    </div>
                                    <Link
                                        :href="route('home')"
                                        :class="[page.url === '/' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                    >
                                        Trang chủ
                                    </Link>
                                    <Link
                                        :href="route('products')"
                                        :class="[page.url.startsWith('/products') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                    >
                                        Sản phẩm
                                    </Link>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-1 absolute left-0 right-0 w-32 ms-20 md:mx-auto md:w-96">
                            <form class="w-full mx-auto" @submit.prevent="searchProduct">
                                <label class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="search" v-model="keyword" @input="isSearching = true;" autocomplete="off" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tìm kiếm sản phẩm" required />
                                    <button type="submit" class="hidden md:block text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tìm kiếm</button>
                                    <div v-if="isSearching" class="absolute hidden md:block w-full text-center bg-white border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                                        Đang tìm kiếm...
                                    </div>
                                    <div  v-if="products && products.length > 0" class="bg-white hidden md:block absolute rounded-md w-full">
                                        <ul class="bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                                            <li v-for="product in products" class="p-4 border-b hover:bg-slate-100">
                                                <Link :href="route('product.show', { slug: product.slug, id: product.id })">
                                                    <div class="flex justify-between items-center">
                                                        <div class="flex items-center gap-2">
                                                            <img class="w-10 h-10 rounded-md" v-if="product.images.length > 0" :src="product.images[0].url" alt="">
                                                            <div>
                                                                <p class="font-bold">{{ product.category.name }}</p>
                                                                <span v-html="highlightKeyword(product.name)"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </Link>
                                            </li>
                                            <Link :href="route('home.search')" :data="{ keyword }">
                                                <p class="text-center hover:bg-slate-100">
                                                    Xem tất cả kết quả
                                                </p>
                                            </Link>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex gap-2 items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                            <Link
                                type="button"
                                :href="route('cart')"
                                class="relative group rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none"
                            >
                                <span class="absolute -inset-1.5" />
                                <span class="sr-only">View cart</span>
                                <ShoppingCartIcon class="size-6" aria-hidden="true" />
                                <div v-if="page.props.cartNumber">
                                    <div
                                        class="rounded-full absolute -top-3 left-4 text-xs bg-red-500 px-2 py-0.5 text-white"
                                    >
                                        {{ page.props.cartNumber }}
                                    </div>
                                </div>
                            </Link>
                            <button type="button" v-if="user"
                                class="relative rounded-full bg-gray-800 p-1 group text-gray-400 focus:outline-none">
                                <span class="absolute -inset-1.5" />
                                <span class="sr-only">View notifications</span>
                                <BellIcon class="size-6 group-hover:text-white" aria-hidden="true" />
                                <template v-if="page.props.unreadNotifications > 0">
                                    <div
                                        v-if="page.props.unreadNotifications > 9"
                                        class="rounded-full absolute -top-3 left-4 text-xs bg-red-500 px-2 py-0.5 text-white"
                                    >
                                        9+
                                    </div>
                                    <div
                                        v-else
                                        class="rounded-full absolute -top-3 left-4 text-xs bg-red-500 px-2 py-0.5 text-white"
                                    >
                                        {{ page.props.unreadNotifications }}
                                    </div>
                                </template>
                                <div
                                    class="absolute hidden group-hover:block text-gray-600 bg-gray-50 top-10 right-1 h-auto min-h-48 rounded-md"
                                >
                                    <div class="absolute right-1 -top-2 border-solid border-b-gray-50 border-b-8 border-x-transparent border-x-8 border-t-0"></div>
                                    <div class="px-3 pt-3 pb-1">
                                        <h1 class="font-bold text-xl text-left">Thông báo</h1>
                                        <template v-if="page.props.notifications.length > 0">
                                            <ul class="mt-2 max-w-96 min-w-80 max-h-80 overflow-auto">
                                                <template v-for="notification in page.props.notifications">
                                                    <li
                                                        :class="[notification.read_at ? '' : 'bg-gray-300', 'rounded-md shadow-md my-2 p-2 hover:bg-gray-200']"
                                                    >
                                                        <Link href="#" @click.prevent="show(notification.data.link, notification.read_at, notification.id)">
                                                            <div class="flex items-center gap-2">
                                                                <div class="border border-gray-600 p-1 w-9 h-8 rounded-full">
                                                                    <i class="pi pi-truck"></i>
                                                                </div>
                                                                <div class="">
                                                                    <h1 class="text-left font-semibold">
                                                                        {{ notification.data.message }} {{ notification.data.order_id }}: {{ notification.data.order_status }}
                                                                    </h1 >
                                                                    <p class="text-left">{{ dayjs(notification.created_at).locale('vi').fromNow() }}</p>
                                                                </div>
                                                            </div>
                                                        </Link>
                                                    </li>
                                                </template>
                                            </ul>
                                            <div class="h-10 flex justify-center items-center">
                                                <Link
                                                    :href="user.is_admin == 1 ? route('admin.notifications') : route('notifications')"
                                                >
                                                    Xem tất cả
                                                </Link>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="mt-2 max-w-96 min-w-80 h-52 flex justify-center items-center">Chưa có thông báo nào</div>
                                        </template>
                                    </div>
                                </div>
                            </button>
                            <!-- Profile dropdown -->
                            <Menu v-if="user" as="div" class="relative">
                                <div>
                                    <MenuButton
                                        class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                        <span class="absolute -inset-1.5" />
                                        <span class="sr-only">Open user menu</span>
                                        <img class="size-8 rounded-full"
                                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                            alt="" />
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100"
                                    enter-from-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-none">
                                        <MenuItem v-slot="{active}">
                                            <Link
                                                :href="route('profile.edit')"
                                                :class="[active ? 'bg-gray-100 outline-none' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                            >
                                                <i class="pi pi-user"></i>
                                                Thông tin cá nhân
                                            </Link>
                                        </MenuItem>
                                        <MenuItem v-slot="{active}">
                                            <Link
                                                :href="route('orders')"
                                                :class="[active ? 'bg-gray-100 outline-none' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                            >
                                                <i class="pi pi-shopping-bag"></i>
                                                Đơn hàng
                                            </Link>
                                        </MenuItem>
                                        <MenuItem v-slot="{active}">
                                            <Link
                                                :href="route('wishlist')"
                                                :class="[active ? 'bg-gray-100 outline-none' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                            >
                                                <i class="pi pi-heart"></i>
                                                Danh sách yêu thích
                                            </Link>
                                        </MenuItem>
                                        <MenuItem v-slot="{active}">
                                            <Link
                                                :href="route('logout')"
                                                method="post"
                                                :class="[active ? 'bg-gray-100 outline-none' : '', 'block w-full text-left px-4 py-2 text-sm text-gray-700']"
                                            >
                                                <i class="pi pi-sign-out"></i>
                                                Đăng xuất
                                            </Link>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                            <Menu v-else>
                                <Link :href="route('login')" class="text-white">Đăng nhập</Link>
                            </Menu>
                        </div>
                    </div>
                </div>
                <DisclosurePanel class="sm:hidden">
                    <div class="space-y-1 px-2 pb-3 pt-2">
                        <div class="group relative cursor-pointer">
                            <Disclosure>
                                <DisclosureButton class="w-full">
                                    <div class="flex justify-between text-gray-300 hover:bg-gray-700 rounded-md px-3 py-2">
                                        Danh mục
                                    </div>
                                </DisclosureButton>
                                <DisclosurePanel class="text-white">
                                    <div class="invisible absolute z-50 flex w-full flex-col bg-gray-100 py-1 px-4 text-gray-800 shadow-xl group-hover:visible">
                                        <DisclosureButton
                                            v-for="category in categories"
                                            :key="category.id"
                                            class="my-2 block border-b border-gray-100 py-1 font-semibold text-gray-500 hover:text-black md:mx-2"
                                            :href="route('category.show', { slug: category.slug })"
                                            as="a"
                                        >
                                            {{ category.name }}
                                        </DisclosureButton>
                                    </div>
                                </DisclosurePanel>
                            </Disclosure>
                        </div>
                        <DisclosureButton>
                            <Link
                                :href="route('home')"
                                :class="[ page.url === '/' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                            >
                                Trang chủ
                            </Link>
                        </DisclosureButton>
                        <DisclosureButton>
                            <Link
                                :href="route('products')"
                                :class="[ page.url.startsWith('/products') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                            >
                                Sản phẩm
                            </Link>
                        </DisclosureButton>
                    </div>
                </DisclosurePanel>
            </Disclosure>
        </div>

        <main>
            <slot />
        </main>

        <footer class="bg-gray-100 mt-12 dark:bg-gray-900">
            <div class="mx-auto w-full max-w-screen-xl">
            <div class="grid grid-cols-1 gap-8 px-4 py-6 lg:py-8 md:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Nhà sách ABC</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="#" class=" hover:underline">About</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Careers</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Brand Center</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Blog</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Thông tin</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Discord Server</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Twitter</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Facebook</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Contact Us</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Chính sách</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Privacy Policy</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Licensing</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="px-4 pt-6 bg-gray-100 dark:bg-gray-700 md:flex md:items-center md:justify-center">
                <span class="text-sm text-gray-500 dark:text-gray-300 sm:text-center">© 2025 <a href="https://flowbite.com/">Nhà sách ABC</a>.
                </span>
            </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon, ShoppingCartIcon } from '@heroicons/vue/24/outline'
import { Link, usePage, router } from '@inertiajs/vue3'
import { computed, ref, watch } from 'vue'
import debounce from 'lodash/debounce'
import dayjs from 'dayjs'

const page = usePage();
const props = defineProps({
    filters: Object
})


const isSearching = ref(false)
const keyword = ref(props.filters ? props.filters.keyword : '')
const products = ref([])
const categories = computed(() => page.props.categories);
const user = computed(() => page.props.auth.user);

router.on('navigate', () => {
    router.reload({ only: ['cartNumber'] })
    products.value = []
})

watch(keyword, debounce(async function (newKeyword) {
    const res = await axios.get(route('product.search', { keyword: newKeyword }));
    products.value = res.data.products;
    isSearching.value = false;
}, 250));

function searchProduct() {
    router.get(route('home.search'), {
        keyword: keyword.value,
    })
}

function show(link, read_at, notificationId) {
    if (!read_at) {
        router.post(route('notifications.read', { notificationId }), {}, {
            onSuccess: () => {
                link ? router.get(link) : router.reload()
            }
        })
    } else {
        router.get(link)
    }
}

function capitalize(s)
{
    return String(s[0]).toUpperCase() + String(s).slice(1);
}

function highlightKeyword(productName) {
    const regex = new RegExp(`${keyword.value}`, 'gi')

    return productName.replace(
        regex,
        `<span class="text-red-500">${keyword.value[0] === productName[0].toLowerCase() ? capitalize(keyword.value) : keyword.value}</span>`
    )
}
</script>
