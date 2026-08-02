<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-nfl-navy-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-nfl-navy-600 focus:bg-nfl-navy-600 active:bg-nfl-navy-800 focus:outline-hidden focus:ring-2 focus:ring-nfl-navy-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
