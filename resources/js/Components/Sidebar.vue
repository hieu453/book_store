<template>
    <div class="flex">
        <!-- Backdrop -->
        <div :class="useSidebar.isOpen ? 'block' : 'hidden'" @click="useSidebar.isOpen = false"
            class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
        <!-- End Backdrop -->

        <div :class="useSidebar.isOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
            class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-purple-600 lg:translate-x-0 lg:static lg:inset-0">
            <Link :href="route('admin.dashboard')">
                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <svg class="w-12 h-12" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z"
                                fill="#4C51BF" stroke="#4C51BF" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z"
                                fill="white" />
                        </svg>

                        <span class="mx-2 text-2xl font-semibold text-white">Dashboard</span>
                    </div>
                </div>
            </Link>

            <nav class="mt-10">
                <Link :href="route('admin.dashboard')" class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4"
                    :class="[ page.component === 'Admin/Index' ? activeClass : inactiveClass ]"
                >
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 10C2 5.58172 5.58172 2 10 2V10H18C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10Z"
                            fill="currentColor" />
                        <path d="M12 2.25195C14.8113 2.97552 17.0245 5.18877 17.748 8.00004H12V2.25195Z"
                            fill="currentColor" />
                    </svg>

                    <span class="mx-4">Dashboard</span>
                </Link>

                <Link :href="route('admin.categories')" class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4"
                    :class="[ page.url.startsWith('/admin/categories') ? activeClass : inactiveClass ]"
                >
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 3C3.89543 3 3 3.89543 3 5V7C3 8.10457 3.89543 9 5 9H7C8.10457 9 9 8.10457 9 7V5C9 3.89543 8.10457 3 7 3H5Z"
                            fill="currentColor" />
                        <path
                            d="M5 11C3.89543 11 3 11.8954 3 13V15C3 16.1046 3.89543 17 5 17H7C8.10457 17 9 16.1046 9 15V13C9 11.8954 8.10457 11 7 11H5Z"
                            fill="currentColor" />
                        <path
                            d="M11 5C11 3.89543 11.8954 3 13 3H15C16.1046 3 17 3.89543 17 5V7C17 8.10457 16.1046 9 15 9H13C11.8954 9 11 8.10457 11 7V5Z"
                            fill="currentColor" />
                        <path
                            d="M11 13C11 11.8954 11.8954 11 13 11H15C16.1046 11 17 11.8954 17 13V15C17 16.1046 16.1046 17 15 17H13C11.8954 17 11 16.1046 11 15V13Z"
                            fill="currentColor" />
                    </svg>

                    <span class="mx-4">Danh mục</span>
                </Link>

                <Link :href="route('admin.products')" class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4"
                    :class="[ page.url.startsWith('/admin/products') ? activeClass : inactiveClass ]"
                >
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 3C6.44772 3 6 3.44772 6 4C6 4.55228 6.44772 5 7 5H13C13.5523 5 14 4.55228 14 4C14 3.44772 13.5523 3 13 3H7Z"
                            fill="currentColor" />
                        <path
                            d="M4 7C4 6.44772 4.44772 6 5 6H15C15.5523 6 16 6.44772 16 7C16 7.55228 15.5523 8 15 8H5C4.44772 8 4 7.55228 4 7Z"
                            fill="currentColor" />
                        <path
                            d="M2 11C2 9.89543 2.89543 9 4 9H16C17.1046 9 18 9.89543 18 11V15C18 16.1046 17.1046 17 16 17H4C2.89543 17 2 16.1046 2 15V11Z"
                            fill="currentColor" />
                    </svg>

                    <span class="mx-4">Sản phẩm</span>
                </Link>

                <Link :href="route('admin.orders')" class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4"
                    :class="[ page.url.startsWith('/admin/orders') ? activeClass : inactiveClass ]"
                >
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 3C6.44772 3 6 3.44772 6 4C6 4.55228 6.44772 5 7 5H13C13.5523 5 14 4.55228 14 4C14 3.44772 13.5523 3 13 3H7Z"
                            fill="currentColor" />
                        <path
                            d="M4 7C4 6.44772 4.44772 6 5 6H15C15.5523 6 16 6.44772 16 7C16 7.55228 15.5523 8 15 8H5C4.44772 8 4 7.55228 4 7Z"
                            fill="currentColor" />
                        <path
                            d="M2 11C2 9.89543 2.89543 9 4 9H16C17.1046 9 18 9.89543 18 11V15C18 16.1046 17.1046 17 16 17H4C2.89543 17 2 16.1046 2 15V11Z"
                            fill="currentColor" />
                    </svg>

                    <span class="mx-4">Đơn hàng</span>
                </Link>

                <Link :href="route('admin.orders.cancelled')" class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4"
                    :class="[ page.url.startsWith('/admin/cancelled-orders') ? activeClass : inactiveClass ]"
                >
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 3C6.44772 3 6 3.44772 6 4C6 4.55228 6.44772 5 7 5H13C13.5523 5 14 4.55228 14 4C14 3.44772 13.5523 3 13 3H7Z"
                            fill="currentColor" />
                        <path
                            d="M4 7C4 6.44772 4.44772 6 5 6H15C15.5523 6 16 6.44772 16 7C16 7.55228 15.5523 8 15 8H5C4.44772 8 4 7.55228 4 7Z"
                            fill="currentColor" />
                        <path
                            d="M2 11C2 9.89543 2.89543 9 4 9H16C17.1046 9 18 9.89543 18 11V15C18 16.1046 17.1046 17 16 17H4C2.89543 17 2 16.1046 2 15V11Z"
                            fill="currentColor" />
                    </svg>

                    <span class="mx-4">Yêu cầu hủy đơn hàng</span>
                </Link>

                <Link :href="route('admin.users')" class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4"
                    :class="[ page.url.startsWith('/admin/users') ? activeClass : inactiveClass ]"
                >
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 3C6.44772 3 6 3.44772 6 4C6 4.55228 6.44772 5 7 5H13C13.5523 5 14 4.55228 14 4C14 3.44772 13.5523 3 13 3H7Z"
                            fill="currentColor" />
                        <path
                            d="M4 7C4 6.44772 4.44772 6 5 6H15C15.5523 6 16 6.44772 16 7C16 7.55228 15.5523 8 15 8H5C4.44772 8 4 7.55228 4 7Z"
                            fill="currentColor" />
                        <path
                            d="M2 11C2 9.89543 2.89543 9 4 9H16C17.1046 9 18 9.89543 18 11V15C18 16.1046 17.1046 17 16 17H4C2.89543 17 2 16.1046 2 15V11Z"
                            fill="currentColor" />
                    </svg>

                    <span class="mx-4">Người dùng</span>
                </Link>
            </nav>
        </div>
    </div>
</template>

<script setup>
import { useSidebar } from '@/store/useSidebar.js';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage()

const activeClass = ref(
      "bg-gray-600 bg-opacity-25 text-gray-100 border-gray-100"
);

const inactiveClass = ref(
    "border-gray-900 text-black hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100"
);

</script>
