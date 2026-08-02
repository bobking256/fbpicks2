<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import admin from '@/routes/admin';

const props = defineProps({
    schedule: Array,
    teams: Array,
    weekno: Number,
    state: Number,
});

const page = usePage();

const form = useForm({
    games: props.schedule.map((s) => ({
        id: s.id,
        default_game: s.default_game ?? 0,
        noline: !!s.noline,
        awayteam_id: s.awayteam_id,
        hometeam_id: s.hometeam_id,
        favteam_id: s.favoriteteam_id || s.awayteam_id,
        awayteam_pts: s.awayteam_pts,
        point_spread: s.point_spread,
        hometeam_pts: s.hometeam_pts,
        gamedate: s.gamedate,
    })),
    state: props.state,
});

const submit = () => {
    form.post(admin.updatepointspread().url);
};
</script>

<template>
    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Admin Point Spreads</h2>
        </template>

        <div class="py-12">
            <div class="container max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="page.props.flash.success" class="mx-4 mb-4 text-green-700 font-bold px-4">
                    {{ page.props.flash.success }}
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="font-bold my-6 mx-6">Week No.: {{ weekno }}</div>
                    <form @submit.prevent="submit">
                        <div class="mx-6 overflow-x-auto">
                        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                    <th class="px-3 py-2 text-center">Default</th>
                                    <th class="px-3 py-2 text-center">No<br />Line</th>
                                    <th class="px-3 py-2 text-left">Away Team</th>
                                    <th class="px-3 py-2 text-center">Final<br />Score</th>
                                    <th class="px-3 py-2 text-center">Point<br />Spread</th>
                                    <th class="px-3 py-2 text-left">Home Team</th>
                                    <th class="px-3 py-2 text-center">Final<br />Score</th>
                                    <th class="px-3 py-2 text-center">Favorite</th>
                                    <th class="px-3 py-2 text-center">Game Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(game, i) in form.games" :key="game.id" class="border-t border-gray-200" :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'">
                                    <td class="px-3 py-2 text-center">
                                        <select v-model="game.default_game" class="rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500">
                                            <option value="0">0</option>
                                            <option value="5">5</option>
                                            <option value="3">3</option>
                                            <option value="1">1</option>
                                        </select>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <input v-model="game.noline" type="checkbox" class="rounded border-gray-300 text-nfl-navy-700 focus:ring-nfl-navy-500" />
                                    </td>
                                    <td class="px-3 py-2">
                                        <select v-model="game.awayteam_id" class="w-full rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500">
                                            <option v-for="t in teams" :key="t.id" :value="t.id">{{ t.name }}</option>
                                        </select>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <input v-model="game.awayteam_pts" type="text" size="4" class="w-16 rounded border-gray-300 text-sm text-center focus:border-nfl-navy-500 focus:ring-nfl-navy-500" />
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <input v-model="game.point_spread" type="text" size="4" class="w-16 rounded border-gray-300 text-sm text-center focus:border-nfl-navy-500 focus:ring-nfl-navy-500" />
                                    </td>
                                    <td class="px-3 py-2">
                                        <select v-model="game.hometeam_id" class="w-full rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500">
                                            <option v-for="t in teams" :key="t.id" :value="t.id">{{ t.name }}</option>
                                        </select>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <input v-model="game.hometeam_pts" type="text" size="4" class="w-16 rounded border-gray-300 text-sm text-center focus:border-nfl-navy-500 focus:ring-nfl-navy-500" />
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <select v-model="game.favteam_id" class="rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500">
                                            <option :value="game.awayteam_id">Away</option>
                                            <option :value="game.hometeam_id">Home</option>
                                        </select>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <input v-model="game.gamedate" type="datetime-local" class="rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>

                        <div class="mx-6 mt-6">
                            <div class="font-bold">Current Weekly State</div>
                            <div class="mt-2 space-y-1">
                                <label
                                    v-for="option in [
                                        [0, 'Initial State, Schedule Entered, No Point Spread'],
                                        [1, 'Point Spread Added, Users Can Enter Picks'],
                                        [2, 'Lock Picks, Process Default Picks'],
                                        [3, 'Picks are Locked'],
                                        [4, 'Final Scores Entered, Process Results'],
                                        [5, 'Results Processed'],
                                        [6, 'Delete Weekly Default Picks'],
                                        [7, 'Delete Weekly Results'],
                                    ]"
                                    :key="option[0]"
                                    class="flex items-center"
                                >
                                    <input class="border-gray-300 text-nfl-navy-700 focus:ring-nfl-navy-500" type="radio" :value="option[0]" v-model="form.state" />
                                    <span class="ml-2 text-sm">{{ option[1] }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="mx-6 my-6 text-center">
                            <button type="submit" class="font-bold rounded-lg px-4 py-2 text-white bg-nfl-navy-700 hover:bg-nfl-navy-600 disabled:opacity-50 transition" :disabled="form.processing">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
