<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { dashboard, login, register } from '@/routes';
import ApplicationMark from '@/Components/ApplicationMark.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    appVersion: String,
});

const page = usePage();
</script>

<template>
    <Head title="Paulie's Football Picks" />

    <div class="relative flex items-top justify-center min-h-screen bg-nfl-navy-800 sm:items-center py-4 sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="page.props.auth.user" :href="dashboard()" class="text-sm text-nfl-navy-200 hover:text-white underline">Dashboard</Link>
            <template v-else>
                <Link :href="login()" class="text-sm text-nfl-navy-200 hover:text-white underline">Log in</Link>
                <Link v-if="canRegister" :href="register()" class="ml-4 text-sm text-nfl-navy-200 hover:text-white underline">Register</Link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 flex flex-column items-center justify-center">
            <ApplicationMark class="size-20 text-nfl-red-500 mb-2" />

            <div class="flex justify-center pt-4 sm:pt-0">
                <img src="/assets/pauliefbp.png" class="rounded shadow-lg" />
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm text-center rounded-lg px-6 py-4">
                <span class="font-display font-medium tracking-wide text-nfl-navy-800">Paulie's Football Picks 2025/26 Season.</span>
                <span class="text-gray-500"> {{ appVersion }}</span>
            </div>
        </div>
    </div>
</template>
