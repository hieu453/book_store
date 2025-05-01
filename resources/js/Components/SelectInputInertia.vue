<template>
    <div :class="$attrs.class">
        <label class="form-label">Trạng thái đơn hàng</label>
        <select @change="emit('update:modelValue', $event.target.value)">
            <option v-for="(v, k) in status" :value="k" :selected="k === order.status">
                {{ v }}
            </option>
        </select>
        <div v-if="error" class="form-error">{{ error }}</div>
    </div>
</template>
<script setup>
const props = defineProps({
    status: Object,
    order: Object,
    selectedStatus: String,
    modelValue: String,
    error: String,
})

const emit = defineEmits(['update:modelValue'])
</script>
