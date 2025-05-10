<template>
    <div>
        <Button
            :label="label"
            :icon="icon"
            :loading="loading"
            :severity="severity"
            :class="sizeMap[size]"
        />
    </div>
</template>

<script>
import { Button } from 'primevue';

export default {
    components: {
        Button,
    },
    
    props: {
        label: {
            type: String,
        },
        icon: {
            type: String,
            default: null,
        },
        loading: {
            type: Boolean,
            default: false,
        },
        severity: {
            type: String,
            default: 'primary',
        },
        size: {
            type: String,
            default: 'm',
        },
    },
    
    data() {
        return {
            sizeMap: {
                xs: 'text-xs px-2 py-1',
                s: 'text-sm px-3 py-1.5',
                m: 'text-base px-4 py-2',
                l: 'text-lg px-5 py-3',
                xl: 'text-xl px-6 py-4',
            }
        };
    },
};
</script>
