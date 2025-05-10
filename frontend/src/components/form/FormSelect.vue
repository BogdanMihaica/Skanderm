<template>
    <label class="flex flex-col">
        {{ label }}
        <select 
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            class="border border-gray-200 rounded-xs p-1 mb-1"
        >    
            <option v-if="defaultOption" value="">-</option>

            <div v-if="options?.length">
                <option v-for="option in options" :key="option.value" :value="option.value" :selected="option.selected">
                    {{ option.label }}
                </option>
            </div>
            
            <div v-if="boolean">
                <option :value="1">Yes</option>
                <option :value="0">No</option>
            </div>
        </select>
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
            modelValue: {
                type: [String, Number, Boolean],
                default: '',
            },
            error: {
                type: Array,
            },
            options: {
                type: Array,
                default: [],
            },
            boolean: {
                type: Boolean,
                default: false,
            },
            defaultOption: {
                type: Boolean,
                default: true,
            },
        },
    }
</script>