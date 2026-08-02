<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import { create as createPick531 } from '@/routes/pick531';
import { create as createPickall } from '@/routes/pickall';
import results from '@/routes/results';
import resultsall from '@/routes/resultsall';

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-nfl-navy-800 overflow-hidden shadow-xl rounded-lg">
                    <div class="h-1.5 bg-nfl-red-500"></div>
                    <div class="px-6 py-8 sm:px-10 flex items-center gap-4">
                        <ApplicationMark class="hidden sm:block size-12 shrink-0 text-nfl-red-500" />
                        <div>
                            <h3 class="font-display text-2xl sm:text-3xl font-semibold text-white tracking-wide">
                                Welcome back, {{ user.name }}
                            </h3>
                            <p class="mt-1 text-nfl-navy-200">
                                Ready to make your picks for this week?
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div v-if="user.pick531" class="bg-white overflow-hidden shadow-xl rounded-lg p-6 flex flex-col">
                        <h4 class="font-display text-lg font-semibold text-nfl-navy-800 tracking-wide">Pick 5-3-1</h4>
                        <p class="mt-1 text-sm text-gray-500 grow">
                            Rank your favorite picks by confidence &mdash; 5, 3, and 1 points, plus a bonus.
                        </p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <Link :href="createPick531()" class="inline-flex items-center px-4 py-2 bg-nfl-navy-700 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-nfl-navy-600 transition">
                                Make Your Picks
                            </Link>
                            <Link :href="results.standings()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">
                                Standings
                            </Link>
                        </div>
                    </div>

                    <div v-if="user.pickall" class="bg-white overflow-hidden shadow-xl rounded-lg p-6 flex flex-col">
                        <h4 class="font-display text-lg font-semibold text-nfl-navy-800 tracking-wide">Pick All</h4>
                        <p class="mt-1 text-sm text-gray-500 grow">
                            Pick every game against the spread, plus a Monday Night total-points tiebreaker.
                        </p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <Link :href="createPickall()" class="inline-flex items-center px-4 py-2 bg-nfl-navy-700 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-nfl-navy-600 transition">
                                Make Your Picks
                            </Link>
                            <Link :href="resultsall.standings()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">
                                Standings
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
