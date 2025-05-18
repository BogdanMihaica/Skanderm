<template>
    <div class="max-w-xl mx-auto p-6 bg-white rounded-2xl shadow-lg space-y-6">
        <div class="text-center text-2xl">
            <slot name="title"></slot>
        </div>
        <div class="space-y-4">
            <slot name="inputs"></slot>
        </div>
        <div class="text-center">
            <app-form-button
                severity="contrast"
                :loading="loading"
                label="Submit"
                size="m"
                @click.prevent="onSubmit"
            />
        </div>
        <div class="text-center">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        onSubmit: Function,
        loading: {
            type: Boolean,
            default: false
        }
    }
}
</script>
