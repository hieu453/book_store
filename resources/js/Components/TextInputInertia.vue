<template>
    <div>
        <label v-if="label" class="form-label">{{ label }}:</label>
        <input ref="input" v-bind="{...$attrs, class: null}" class="form-input" :class="{error: error}"
            :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :disabled="disabled" />
        <div v-if="error" class="form-error">{{ error }}</div>
    </div>
</template>

<script setup>
import { onMounted, useTemplateRef } from 'vue';


defineProps({
    type: {
        type: String,
        default: 'text',
    },
    error: String,
    label: String,
    modelValue: String,
    disabled: {
        type: Boolean,
        default: false,
    }
})

const input = useTemplateRef('input');

onMounted(() => {
    input.value.focus();
    input.value.select();
})

</script>
