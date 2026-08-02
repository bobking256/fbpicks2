<script setup>
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import { create as createPick531 } from '@/routes/pick531';
import { create as createPickall } from '@/routes/pickall';
import results from '@/routes/results';
import resultsall from '@/routes/resultsall';

const page = usePage();
const user = page.props.auth.user;

const games = computed(() => [
    {
        key: 'pick531',
        enabled: user.pick531,
        title: 'Pick 5-3-1',
        description: 'Rank your favorite picks by confidence — 5, 3, and 1 points, plus a bonus.',
        createHref: createPick531(),
        standingsHref: results.standings(),
    },
    {
        key: 'pickall',
        enabled: user.pickall,
        title: 'Pick All',
        description: 'Pick every game against the spread, plus a Monday Night total-points tiebreaker.',
        createHref: createPickall(),
        standingsHref: resultsall.standings(),
    },
].filter((game) => game.enabled));
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

                <div v-if="games.length" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div
                        v-for="game in games"
                        :key="game.key"
                        class="bg-white overflow-hidden shadow-xl rounded-lg p-6 flex flex-col"
                        :class="{ 'sm:col-span-2': games.length === 1 }"
                    >
                        <h4 class="font-display text-lg font-semibold text-nfl-navy-800 tracking-wide">{{ game.title }}</h4>
                        <p class="mt-1 text-sm text-gray-500 grow">{{ game.description }}</p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <Link :href="game.createHref" class="inline-flex items-center px-4 py-2 bg-nfl-navy-700 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-nfl-navy-600 transition">
                                Make Your Picks
                            </Link>
                            <Link :href="game.standingsHref" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">
                                Standings
                            </Link>
                        </div>
                    </div>
                </div>

                <div v-else class="bg-white overflow-hidden shadow-xl rounded-lg p-6 text-sm text-gray-500">
                    You're not enrolled in any pick'em games yet. Contact an admin to get set up.
                </div>
            </div>
        </div>
    </AppLayout>
</template>
