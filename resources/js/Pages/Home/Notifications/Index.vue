<template>
    <div class="container max-w-lg my-6 mx-auto">
        <Head title="Thông báo" />
        <h1 class="font-bold text-2xl mb-2">Thông báo</h1>
        <ul>
            <template v-if="notifications.length > 0">
                <li v-for="notification in notifications" class="mb-2 shadow-md">
                    <button as="button"
                        @click="show(notification.data.link, notification.read_at ,notification.id)"
                        class="w-full"
                    >
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
                    </button>
                </li>
            </template>
            <template v-else>
                <div>Chưa có thông báo nào</div>
            </template>
        </ul>
    </div>
</template>

<script setup>
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
            },
        })
    } else {
        router.get(link, {}, {
            onError: (error) => {
                console.log('vl')
            }
        })
    }
}
</script>
