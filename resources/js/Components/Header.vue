<template>
    <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600">
        <div class="flex items-center">
            <button @click="useSidebar.isOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        <div class="flex items-center">
            <button class="flex relative group mx-4 text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <template v-if="page.props.unreadNotifications > 0">
                    <div v-if="page.props.unreadNotifications > 9" class="rounded-full absolute -top-3 left-4 text-xs bg-red-500 px-2 py-0.5 text-white">
                        9+
                    </div>
                    <div v-else class="rounded-full absolute -top-3 left-4 text-xs bg-red-500 px-2 py-0.5 text-white">
                        {{ page.props.unreadNotifications }}
                    </div>
                </template>
                <div
                    class="absolute hidden group-hover:block z-50 text-gray-600 bg-gray-50 top-8 right-1 h-auto min-h-48 rounded-md">
                    <div
                        class="absolute right-1 -top-2 border-solid border-b-gray-50 border-b-8 border-x-transparent border-x-8 border-t-0">
                    </div>
                    <div class="px-3 pt-3 pb-1">
                        <h1 class="font-bold text-xl text-left">Thông báo</h1>
                        <template v-if="page.props.notifications.length > 0">
                            <ul class="mt-2 max-w-96 min-w-80 max-h-80 overflow-auto">
                                <template v-for="notification in page.props.notifications">
                                    <li
                                        :class="[notification.read_at ? '' : 'bg-gray-300', 'rounded-md shadow-md my-2 p-2 hover:bg-gray-200']">
                                        <Link as="button" href="#" @click.prevent="show(notification.data.link, notification.read_at, notification.id)">
                                            <div class="flex items-center gap-2">
                                                <div class="border border-gray-600 p-1 w-9 h-8 rounded-full">
                                                    <i class="pi pi-truck"></i>
                                                </div>
                                                <div class="">
                                                    <h1 class="text-left font-semibold">
                                                        {{ notification.data.message }} {{ notification.data.order_id }}
                                                        <template v-if="notification.data.order_status">
                                                            {{ notification.data.order_status }}
                                                        </template>
                                                    </h1>
                                                    <p class="text-left">{{ dayjs(notification.created_at).locale('vi').fromNow() }}</p>
                                                </div>
                                            </div>
                                        </Link>
                                    </li>
                                </template>
                            </ul>
                            <div class="h-10 flex justify-center items-center">
                                <Link
                                    :href="route('admin.notifications')"
                                >
                                    Xem tất cả
                                </Link>
                            </div>
                        </template>
                        <template v-else>
                            <div class="mt-2 max-w-96 min-w-80 h-52 flex justify-center items-center">Chưa có thông báo
                                nào</div>
                        </template>
                    </div>
                </div>
            </button>

            <div class="relative">
                <button @click="useSidebar.toggleDropdown()"
                    class="relative z-10 block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                    <img class="object-cover w-full h-full"
                        src="https://images.unsplash.com/photo-1528892952291-009c663ce843?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=296&q=80"
                        alt="Your avatar" />
                </button>

                <div v-show="useSidebar.dropdownOpen" @click="useSidebar.dropdownOpen = false"
                    class="fixed inset-0 z-10 w-full h-full"></div>

                <transition enter-active-class="transition duration-150 ease-out transform"
                    enter-from-class="scale-95 opacity-0" enter-to-class="scale-100 opacity-100"
                    leave-active-class="transition duration-150 ease-in transform"
                    leave-from-class="scale-100 opacity-100" leave-to-class="scale-95 opacity-0">
                    <div v-show="useSidebar.dropdownOpen"
                        class="absolute right-0 z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profile</a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Products</a>
                        <Link href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Log
                        out</Link>
                    </div>
                </transition>
            </div>
        </div>
    </header>
</template>

<script setup>
import { useSidebar } from '@/store/useSidebar.js';
import { Link, router, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';

const page = usePage();

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

</script>
