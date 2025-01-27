<template>
    <div class="sticky top-0 z-10">
        <Disclosure as="nav" class="bg-green-800" v-slot="{open}">
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
                    <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex shrink-0 items-center">
                            <img class="h-8 w-auto"
                                src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500"
                                alt="Your Company" />
                        </div>
                        <div class="hidden sm:ml-6 sm:block">
                            <div class="flex space-x-4">
                                <div class="group relative cursor-pointer">
                                    <div class="flex justify-between text-gray-300 rounded-md space-x-2 px-3 py-2">
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
                                            :data="{
                                                id: category.id,
                                                category_name: category.name,
                                            }"
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
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                        <Link
                            type="button"
                            :href="route('cart')"
                            class="relative group mr-2 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none"
                        >
                            <span class="absolute -inset-1.5" />
                            <span class="sr-only">View notifications</span>
                            <ShoppingCartIcon class="size-6" aria-hidden="true" />
                            <div v-if="page.props.cartNumber">
                                <div
                                    v-if="cartNumber"
                                    class="rounded-full absolute -top-3 left-4 text-xs bg-red-500 px-2 py-0.5 text-white"
                                >
                                    {{ cartNumber }}
                                </div>
                                <div
                                    v-else
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
                        <Menu v-if="user" as="div" class="relative ml-3">
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
                                        <a
                                            href="#"
                                            :class="[active ? 'bg-gray-100 outline-none' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                        >
                                            Your Profile
                                        </a>
                                    </MenuItem>
                                    <MenuItem v-slot="{active}">
                                        <a
                                            href="#"
                                            :class="[active ? 'bg-gray-100 outline-none' : '', 'block px-4 py-2 text-sm text-gray-700']"
                                        >
                                            Settings
                                        </a>
                                    </MenuItem>
                                    <MenuItem v-slot="{active}">
                                        <Link
                                            :href="route('logout')"
                                            method="post"
                                            :class="[active ? 'bg-gray-100 outline-none' : '', 'block w-full text-left px-4 py-2 text-sm text-gray-700']"
                                        >
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
                        <div class="flex justify-between text-gray-300 bg-gray-700 rounded-md px-3 py-2">
                            <a class="menu-hover text-sm font-medium">
                                Categories
                            </a>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </div>

                        <div
                            class="invisible absolute z-50 flex w-full flex-col bg-gray-100 py-1 px-4 text-gray-800 shadow-xl group-hover:visible">
                            <a v-for="category in categories" class="my-2 block border-b border-gray-100 py-1 font-semibold text-gray-500 hover:text-black md:mx-2">
                                {{ category.name }}
                            </a>
                        </div>
                    </div>
                    <Link v-for="(item, index) in navigation" :key="item.name" as="a" :href="item.href"
                        :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                        :aria-current="item.current ? 'page' : undefined"
                        @click="changeCurrent(index)"
                    >
                        {{ item.name }}
                    </Link>
                </div>
            </DisclosurePanel>
        </Disclosure>
    </div>
    <main>
        <slot />
    </main>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon, ShoppingCartIcon } from '@heroicons/vue/24/outline'
import { Link, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const page = usePage();

const cartNumber = computed(() => {
    if (page.props.cartItems) {
        return page.props.cartItems.reduce((acc, item) => {
            return acc + item.quantity
        }, 0)
    }
    return null;
})

const navigation = ref([
    { name: 'Home', href: route('home'), current: true },
    { name: 'Products', href: route('products'), current: false },
]);

const categories = computed(() => page.props.categories);
const user = computed(() => page.props.auth.user);

function isUrl(...urls) {
    let currentUrl = page.url.substring(1)
    if (urls[0] === 'home') {
        return currentUrl === ''
    }
    return urls.filter((url) => currentUrl.startsWith(url)).length
}
</script>
