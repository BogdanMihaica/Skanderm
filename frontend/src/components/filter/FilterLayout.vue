<template>
    <div class="flex justify-between items-center max-sm:flex-col">
        <div class="flex gap-2 flex-wrap">
            <slot name="filters"></slot>
        </div>
        <div class="flex gap-2">
            <slot name="actions">
                <app-form-button 
                    severity="contrast" 
                    @click.prevent="onSearch" 
                    label="Search"
                    icon="pi pi-search"
                />
                <app-form-button 
                    severity="secondary"
                    icon="pi pi-ban"
                    @click.prevent="onCancel" 
                />
            </slot>
        </div>
    </div>
</template>
  
<script>
export default {
    props: {
        onSearch: Function,
        onCancel: Function
    }
}
</script>
  