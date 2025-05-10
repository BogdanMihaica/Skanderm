<template>
    <div :class="typeMap[type] || typeMap['primary']">
        <div v-if="to">
            <router-link v-if="typeof to === 'object'" :to="to">
                <i :class="icon"></i>
                {{ label }}
            </router-link>

            <a v-else :href="to" class="decoration-0" target="_blank">
                <i :class="icon"></i>
                {{ label }}
            </a>
        </div>
        
        <button
            v-else
            class="cursor-pointer p-1"
            @click.prevent="click"
        >
            <i :class="icon"></i>
            {{ label }}
        </button>
    </div>
</template>

<script>
export default {
    props: {
        label: String,
        to: [String, Object],
        icon: String,
        click: Function,
        type: {
            type: String,
            default: 'primary'
        }
    },

    data() {
        return {
            typeMap: {
                primary: 'text-blue-600',
                secondary: 'text-gray-600',
                success: 'text-green-600',
                danger: 'text-red-600',
                warning: 'text-yellow-600',
                info: 'text-cyan-600',
                light: 'text-white',
                dark: 'text-black',
                muted: 'text-gray-400'
            }
        }
    }
}
</script>
