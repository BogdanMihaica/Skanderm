<template>
    <div class="rounded-xl w-full bg-white">
        <div class="flex justify-between items-center border-b-1 border-gray-300 p-2">
            <div class="font-bold">
                <slot name="title"></slot>
            </div>
            
            <slot name="tools"></slot>
        </div>
        
        <div class="p-4">
            <slot name="body"></slot>
        </div>
    </div>
</template>
