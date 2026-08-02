<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    action: String,
    buttonText: { type: String, default: 'Delete' },
});

const confirming = ref(false);

const destroy = () => {
    router.delete(props.action, { onFinish: () => (confirming.value = false) });
};
</script>

<template>
    <div class="text-sm flex items-center">
        <button
            v-if="!confirming"
            type="button"
            @click="confirming = true"
            class="text-white p-1 rounded-sm bg-nfl-red-600 hover:bg-nfl-red-700"
        >
            {{ buttonText }}
        </button>

        <div v-else class="flex items-center space-x-3">
            <span>Are you sure?</span>
            <button type="button" @click="destroy" class="text-white p-1 rounded-sm bg-nfl-red-600 hover:bg-nfl-red-700">Yes</button>
            <button type="button" @click="confirming = false" class="text-white p-1 rounded-sm bg-gray-600 hover:bg-gray-700">No</button>
        </div>
    </div>
</template>
