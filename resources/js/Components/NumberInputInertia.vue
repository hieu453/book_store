<template>
    <div>
        <label v-if="label" class="form-label">{{ label }}:</label>
        <input ref="input" v-bind="{...$attrs, class: null}" class="form-input" :class="{error: error}"
            type="number" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
            :min="minValue" :step="step"
        />
        <div v-if="error" class="form-error">{{ error }}</div>
    </div>
</template>

<script setup>
import { onMounted, useTemplateRef } from 'vue';


defineProps({
    minValue: {
        type: Number,
        default: 0,
    },
    step: {
        type: String,
        default: "1",
    },
    error: String,
    label: String,
    modelValue: String,
})

const input = useTemplateRef('input');

onMounted(() => {
    input.value.focus();
    input.value.select();
})

</script>
