<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center justify-center px-4 py-2 bg-nfl-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-nfl-red-500 active:bg-nfl-red-700 focus:outline-hidden focus:ring-2 focus:ring-nfl-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
