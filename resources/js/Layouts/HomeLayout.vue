<template>
    <div>
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
                                                Categories
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
                                    <Link v-for="(item, index) in navigation" :key="item.name" :href="item.href"
                                        :class="[isUrl(item.name.toLowerCase()) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                        :aria-current="item.current ? 'page' : undefined"
                                    >
                                        {{ item.name }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-1">
                            <form class="w-2/3 mx-auto" @submit.prevent="searchProduct">
                                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="search" v-model="keyword" autocomplete="off" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search products" required />
                                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                                    <div  v-if="products.length > 0" class="bg-white absolute rounded-md w-full">
                                        <div v-if="isSearching" class="loading-indicator border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                                            Đang tìm kiếm...
                                        </div>
                                        <ul class="bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                                            <li v-for="product in products" class="p-4 border-b hover:bg-slate-100">
                                                <Link :href="route('product.show', { slug: product.slug, id: product.id })">
                                                    <div class="flex justify-between items-center">
                                                        <div class="flex items-center gap-2">
                                                            <img class="w-10 h-10" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/apple-watch-light.svg" alt="">
                                                            <div>
                                                                <p class="font-bold">{{ product.category.name }}</p>
                                                                <span v-html="highlightKeyword(product.name)"></span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span>{{ product.price }}$</span>
                                                        </div>
                                                    </div>
                                                </Link>
                                            </li>
                                            <Link :href="route('home.search')" :data="{ keyword }">
                                                <p class="text-center hover:bg-slate-100">
                                                    View all results
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
                            <button type="button"
                                class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none">
                                <span class="absolute -inset-1.5" />
                                <span class="sr-only">View notifications</span>
                                <BellIcon class="size-6" aria-hidden="true" />
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
                                                Your Profile
                                            </Link>
                                        </MenuItem>
                                        <MenuItem v-slot="{active}">
                                            <Link
                                                :href="route('orders')"
                                                :class="[active ? 'bg-gray-100 outline-none' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                            >
                                                <i class="pi pi-shopping-bag"></i>
                                                Orders
                                            </Link>
                                        </MenuItem>
                                        <MenuItem v-slot="{active}">
                                            <Link
                                                :href="route('wishlist')"
                                                :class="[active ? 'bg-gray-100 outline-none' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                            >
                                                <i class="pi pi-heart"></i>
                                                Wishlists
                                            </Link>
                                        </MenuItem>
                                        <MenuItem v-slot="{active}">
                                            <Link
                                                :href="route('logout')"
                                                method="post"
                                                :class="[active ? 'bg-gray-100 outline-none' : '', 'block w-full text-left px-4 py-2 text-sm text-gray-700']"
                                            >
                                                <i class="pi pi-sign-out"></i>
                                                Logout
                                            </Link>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                            <Menu v-else>
                                <Link :href="route('login')" class="text-white">Sign in</Link>
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
                                        Categories
                                    </div>
                                </DisclosureButton>
                                <DisclosurePanel class="text-white">
                                    <div class="invisible absolute z-50 flex w-full flex-col bg-gray-100 py-1 px-4 text-gray-800 shadow-xl group-hover:visible">
                                        <DisclosureButton
                                            v-for="category in categories"
                                            :key="category.id"
                                            class="my-2 block border-b border-gray-100 py-1 font-semibold text-gray-500 hover:text-black md:mx-2"
                                            :href="route('category.show', { slug: category.slug, id: category.id, category_name: category.name })"
                                            as="a"
                                        >
                                            {{ category.name }}
                                        </DisclosureButton>
                                    </div>
                                </DisclosurePanel>
                            </Disclosure>
                        </div>
                        <DisclosureButton v-for="(item, index) in navigation" :key="item.name" as="a" :href="item.href"
                            :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                            :aria-current="item.current ? 'page' : undefined"
                        >
                            {{ item.name }}
                        </DisclosureButton>
                    </div>
                </DisclosurePanel>
            </Disclosure>
        </div>

        <main>
            <slot />
        </main>

        <footer class="bg-gray-100 dark:bg-gray-900 min-h-screen">
            <div class="mx-auto w-full max-w-screen-xl">
            <div class="grid grid-cols-2 gap-8 px-4 py-6 lg:py-8 md:grid-cols-4">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Company</h2>
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
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Help center</h2>
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
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
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
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Download</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">iOS</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Android</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Windows</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:underline">MacOS</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="px-4 py-6 bg-gray-100 dark:bg-gray-700 md:flex md:items-center md:justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-300 sm:text-center">© 2023 <a href="https://flowbite.com/">Flowbite™</a>. All Rights Reserved.
                </span>
                <div class="flex mt-4 sm:justify-center md:mt-0 space-x-5 rtl:space-x-reverse">
                    <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                                <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                            </svg>
                        <span class="sr-only">Facebook page</span>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 21 16">
                                <path d="M16.942 1.556a16.3 16.3 0 0 0-4.126-1.3 12.04 12.04 0 0 0-.529 1.1 15.175 15.175 0 0 0-4.573 0 11.585 11.585 0 0 0-.535-1.1 16.274 16.274 0 0 0-4.129 1.3A17.392 17.392 0 0 0 .182 13.218a15.785 15.785 0 0 0 4.963 2.521c.41-.564.773-1.16 1.084-1.785a10.63 10.63 0 0 1-1.706-.83c.143-.106.283-.217.418-.33a11.664 11.664 0 0 0 10.118 0c.137.113.277.224.418.33-.544.328-1.116.606-1.71.832a12.52 12.52 0 0 0 1.084 1.785 16.46 16.46 0 0 0 5.064-2.595 17.286 17.286 0 0 0-2.973-11.59ZM6.678 10.813a1.941 1.941 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.919 1.919 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Zm6.644 0a1.94 1.94 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.918 1.918 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Z"/>
                            </svg>
                        <span class="sr-only">Discord community</span>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
                            <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="sr-only">Twitter page</span>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="sr-only">GitHub account</span>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 0a10 10 0 1 0 10 10A10.009 10.009 0 0 0 10 0Zm6.613 4.614a8.523 8.523 0 0 1 1.93 5.32 20.094 20.094 0 0 0-5.949-.274c-.059-.149-.122-.292-.184-.441a23.879 23.879 0 0 0-.566-1.239 11.41 11.41 0 0 0 4.769-3.366ZM8 1.707a8.821 8.821 0 0 1 2-.238 8.5 8.5 0 0 1 5.664 2.152 9.608 9.608 0 0 1-4.476 3.087A45.758 45.758 0 0 0 8 1.707ZM1.642 8.262a8.57 8.57 0 0 1 4.73-5.981A53.998 53.998 0 0 1 9.54 7.222a32.078 32.078 0 0 1-7.9 1.04h.002Zm2.01 7.46a8.51 8.51 0 0 1-2.2-5.707v-.262a31.64 31.64 0 0 0 8.777-1.219c.243.477.477.964.692 1.449-.114.032-.227.067-.336.1a13.569 13.569 0 0 0-6.942 5.636l.009.003ZM10 18.556a8.508 8.508 0 0 1-5.243-1.8 11.717 11.717 0 0 1 6.7-5.332.509.509 0 0 1 .055-.02 35.65 35.65 0 0 1 1.819 6.476 8.476 8.476 0 0 1-3.331.676Zm4.772-1.462A37.232 37.232 0 0 0 13.113 11a12.513 12.513 0 0 1 5.321.364 8.56 8.56 0 0 1-3.66 5.73h-.002Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="sr-only">Dribbble account</span>
                    </a>
                </div>
            </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon, ShoppingCartIcon } from '@heroicons/vue/24/outline'
import { Link, usePage, router } from '@inertiajs/vue3'
import { computed, onMounted, ref, watch } from 'vue'
import debounce from 'lodash/debounce'

const page = usePage();
const props = defineProps({
    filters: Object
})


const navigation = ref([
    { name: 'Home', href: route('home'), current: true },
    { name: 'Products', href: route('products'), current: false },
]);

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
    isSearching.value = true;

    const res = await axios.get(route('product.search', { keyword: newKeyword }))
    products.value = res.data.products

    isSearching.value = false;
}, 250));

function isUrl(...urls) {
    let currentUrl = page.url.substring(1)
    if (urls[0] === 'home') {
        return currentUrl === ''
    }
    return urls.filter((url) => currentUrl.startsWith(url)).length
}

function searchProduct() {
    router.get(route('home.search'), {
        keyword: keyword.value,
    })
}

function capitalize(s)
{
    return String(s[0]).toUpperCase() + String(s).slice(1);
}

function highlightKeyword(productName) {
    const regex = new RegExp(`${keyword.value}`, 'gi')

    return productName.replace(
        regex,
        `<mark class="text-red-500">${keyword.value[0] === productName[0].toLowerCase() ? capitalize(keyword.value) : keyword.value}</mark>`
    )
}
</script>
