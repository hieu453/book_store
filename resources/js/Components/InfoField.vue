<template>
    <div>
        <label v-if="label" class="form-label">{{ label }}</label>
        <em v-if="info" class="font-italic select-none">{{ info }}</em>
    </div>
</template>
<script setup>
defineProps({
    label: String,
    info: [String, Number],
})
</script>
