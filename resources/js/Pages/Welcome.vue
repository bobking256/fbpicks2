<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { dashboard, login, register } from '@/routes';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    appVersion: String,
});

const page = usePage();
</script>

<template>
    <Head title="Paulie's Football Picks" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="page.props.auth.user" :href="dashboard()" class="text-sm text-gray-700 underline">Dashboard</Link>
            <template v-else>
                <Link :href="login()" class="text-sm text-gray-700 underline">Log in</Link>
                <Link v-if="canRegister" :href="register()" class="ml-4 text-sm text-gray-700 underline">Register</Link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 flex flex-column justify-center">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <img src="/assets/pauliefbp.png" />
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm text-center sm:rounded-lg px-6 py-4">
                Paulie's Football Picks 2025/26 Season. {{ appVersion }}
            </div>
        </div>
    </div>
</template>
