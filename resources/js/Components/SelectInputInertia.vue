<template>
    <div :class="$attrs.class">
        <label class="form-label">Status</label>
        <select @change="emit('update:modelValue', $event.target.value)">
            <option v-for="s in status" :value="s" :selected="s === order.status">{{ s }}</option>
        </select>
        <div v-if="error" class="form-error">{{ error }}</div>
    </div>
</template>
<script setup>
const props = defineProps({
    status: Array,
    order: Object,
    selectedStatus: String,
    modelValue: String,
    error: String,
})

const emit = defineEmits(['update:modelValue'])
</script>
