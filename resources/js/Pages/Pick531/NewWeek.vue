<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <Head title="Pick 5-3-1" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pick 5-3-1</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-8 py-4">
                    The points spread has not yet been entered. Once it has been entered, you will receive email
                    notification to enter picks. Please contact
                    <a href="mailto:pjwasi@comcast.net">pjwasi@comcast.net</a> if you have questions.
                </div>
            </div>
        </div>
    </AppLayout>
</template>
