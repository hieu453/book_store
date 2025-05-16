<template>
    <Dashboard>
        <Head title="Thông báo" />
        <div class="container max-w-lg mx-auto">
            <h1 class="text-2xl font-bold mb-2">Thông báo</h1>
            <ul>
                <li v-for="notification in notifications" class="mb-2 shadow-md">
                    <Link href="#" as="button" @click.prevent="show(notification.data.link, notification.read_at ,notification.id)" class="w-full">
                        <div :class="[notification.read_at ? 'bg-white' : 'bg-gray-300' ,'flex text-left gap-2 p-4 hover:bg-gray-200 rounded-md']">
                            <div class="border border-black flex items-center justify-center px-4 rounded-full">
                                <i class="pi pi-truck"></i>
                            </div>
                            <div>
                                <h1 class="text-lg">
                                    {{ notification.data.message }}
                                    {{ notification.data.order_id }}
                                </h1>
                                <span>{{ dayjs(notification.created_at).locale('vi').fromNow() }}</span>
                            </div>
                        </div>
                    </Link>
                </li>
            </ul>
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import dayjs from 'dayjs';

defineProps({
    notifications: Object
})

function show(link, readAt, notificationId) {
    if (!readAt) {
        router.post(route('notifications.read', { notificationId }), {} , {
            onSuccess: () => {
                router.get(link)
            }
        })
    } else {
        router.get(link)
    }
}
</script>
