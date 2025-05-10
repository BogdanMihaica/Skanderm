<template>
    <div class="mb-1">
        <label>
            {{ type !== 'checkbox' ? label : '' }}
            <input 
                :type="type || 'text'"
                :value="modelValue"
                :checked="type === 'checkbox' && !!modelValue"
                @input="updateValue($event)"
                class="p-1 border border-gray-200 rounded-xs focus:outline-none"
                :class="type !== 'checkbox' ? 'w-full': ''"
                :placeholder="placeholder || `Enter ${label.toLowerCase()}`"
            />
            {{ type === 'checkbox' ? label : '' }}

            <app-form-error v-if="error" :error="error"/>
        </label>
    </div>
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
            type: Array,
        },
        modelValue: {
            type: [String, Number, Boolean],
            default: '',
        },
        type: {
            type: String,
            default: 'text',
        },
        boolean: {
            type: Boolean,
            default: false,
        },
    },

    methods: {
        /**
         * 
         * @param event 
         */
        updateValue(event) {
            if (this.type === 'checkbox' && this.boolean) {
                this.$emit('update:modelValue', event.target.checked);
            } else {
                this.$emit('update:modelValue', event.target.value);
            }
        }
    },
}
</script>
