<template>
    <p class="text-red-500">
        {{ Array.isArray(error) ? error[0] : error }}
    </p>
</template>

<script>
export default {
    props: {
        error: {
            type: [Array, String],
            required: true
        }
    }
}
</script>
