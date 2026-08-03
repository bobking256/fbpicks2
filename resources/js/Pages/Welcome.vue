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

    <div class="flex flex-col min-h-screen bg-nfl-navy-800">
        <div v-if="canLogin" class="flex justify-end gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <Link v-if="page.props.auth.user" :href="dashboard()" class="text-sm text-nfl-navy-200 hover:text-white underline">Dashboard</Link>
            <template v-else>
                <Link :href="login()" class="text-sm text-nfl-navy-200 hover:text-white underline">Log in</Link>
                <Link v-if="canRegister" :href="register()" class="text-sm text-nfl-navy-200 hover:text-white underline">Register</Link>
            </template>
        </div>

        <div class="flex-1 flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="w-full max-w-6xl mx-auto flex flex-col items-center justify-center">
                <ApplicationMark class="size-20 text-nfl-red-500 mb-2" />

                <div class="flex justify-center pt-4 sm:pt-0 rounded-lg shadow-lg overflow-hidden">
                    <img src="/assets/pauliefbp.png" class="rounded-lg shadow-lg overflow-hidden max-w-full" />
                </div>

                <div class="mt-8 w-full max-w-md bg-white overflow-hidden shadow-sm text-center rounded px-6 py-4">
                    <span class="font-display font-medium tracking-wide text-nfl-navy-800">Paulie's Football Picks 2026/27 Season.</span>
                    <span class="text-gray-500"> {{ appVersion }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
