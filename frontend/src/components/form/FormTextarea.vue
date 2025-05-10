<template>
    <label class="mb-4">{{ label }}
        <textarea  
            :value="modelValue"     
            @input="$emit('update:modelValue', $event.target.value)"
            class="w-full p-1 border border-gray-200 rounded-xs focus:outline-none h-auto"
            :placeholder="placeholder || `Enter agent ${label.toLowerCase()}`"
            :rows="rows"
        >
        </textarea>
        <app-form-error v-if="error" :error="error"/>
    </label>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            required: true,
        },
        placeholder: {
            type: String,
            default: '',
        },
        error: {
            type: Array
        },
        modelValue: {
            type: String,
            default: '',
        },
        rows: {
            type: Number,
            default: 4
        }
    },
};
</script>
