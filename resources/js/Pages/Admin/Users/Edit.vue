<template>
    <Dashboard>
        <Head title="Người dùng" />
        <div class="flex items-center justify-between mb-6">
            <h1 class="mb-8 text-3xl font-bold">
                <Link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.users')">Người dùng</Link>
                <span class="text-indigo-400 font-medium">/{{ form.name }}</span>
            </h1>
        </div>
        <section>
            <div class="py-4">
                <div class="mx-auto max-w-7xl space-y-6">
                    <div
                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                    >
                        <h2 class="text-lg font-medium text-gray-900">
                            Hồ sơ
                        </h2>
                        <form
                            @submit.prevent="form.put(route('admin.users.update', { userId: props.user.id }))"
                            class="mt-6 space-y-6"
                        >
                            <div>
                                <InputLabel for="name" value="Tên" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div>
                                <InputLabel for="email" value="Email" />

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Lưu</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p
                                        v-if="form.recentlySuccessful"
                                        class="text-sm text-gray-600"
                                    >
                                        Đã lưu.
                                    </p>
                                </Transition>
                            </div>
                        </form>
                    </div>

                    <div
                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                    >
                        <h2 class="text-lg font-medium text-gray-900">
                            Xóa người dùng
                        </h2>
                        <div class="mt-2">
                            <DangerButton @click="showModal = true;">Xóa</DangerButton>
                            <Modal :show="showModal" @close="showModal = !showModal">
                                <div class="p-6">
                                    <h2
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        Bạn có chắc chắn muốn xóa tài khoản không?
                                    </h2>

                                    <div class="mt-6 flex justify-end">
                                        <SecondaryButton @click="showModal = false;">
                                            Hủy
                                        </SecondaryButton>

                                        <DangerButton
                                            class="ms-3"
                                            :class="{ 'opacity-25': processingDelete }"
                                            :disabled="processingDelete"
                                            @click="deleteUser"
                                        >
                                            Xóa tài khoản
                                        </DangerButton>
                                    </div>
                                </div>
                            </Modal>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Dashboard>
</template>

<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Dashboard from '@/Layouts/Admin/Dashboard.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useToast } from "primevue/usetoast";

const props = defineProps({
    user: Object
})

const page = usePage();
const toast = useToast();

const form = useForm({
    name: props.user.name,
    email: props.user.email,
})
const showModal = ref(false)
const processingDelete = ref(false);

function deleteUser() {
    router.delete(route('admin.users.delete', { userId: props.user.id }), {
        onSuccess: () => {
            processingDelete.value = false;
            toast.add({ severity: 'success', summary: page.props.flash.success, life: 2000 })
        }
    })
}
</script>
