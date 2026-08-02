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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Point Spreads</h2>
        </template>

        <div class="py-12">
            <div class="container max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="page.props.flash.success" class="mb-4 text-green-700 font-bold px-4">
                    {{ page.props.flash.success }}
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="font-bold py-6 px-4">Week No.: {{ weekno }}</div>
                    <form @submit.prevent="submit">
                        <div class="overflow-x-auto">
                        <table class="table table-auto">
                            <thead>
                                <tr>
                                    <th>Default</th>
                                    <th>No<br />Line</th>
                                    <th align="center">Away Team</th>
                                    <th align="center">F A V</th>
                                    <th align="center">Final<br />Score</th>
                                    <th align="center">Point<br />Spread</th>
                                    <th align="center">F A V</th>
                                    <th align="center">Home Team</th>
                                    <th align="center">Final<br />Score</th>
                                    <th align="center">Game Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(game, i) in form.games" :key="game.id">
                                    <td align="right">
                                        <select v-model="game.default_game">
                                            <option value="0">0</option>
                                            <option value="5">5</option>
                                            <option value="3">3</option>
                                            <option value="1">1</option>
                                        </select>
                                    </td>
                                    <td align="center">
                                        <input v-model="game.noline" type="checkbox" />
                                    </td>
                                    <td align="left">
                                        <select v-model="game.awayteam_id">
                                            <option v-for="t in teams" :key="t.id" :value="t.id">{{ t.name }}</option>
                                        </select>
                                    </td>
                                    <td align="center">
                                        <input type="radio" :value="game.awayteam_id" v-model="game.favteam_id" />
                                    </td>
                                    <td align="center">
                                        <input v-model="game.awayteam_pts" type="text" size="4" />
                                    </td>
                                    <td align="center">
                                        <input v-model="game.point_spread" type="text" size="4" />
                                    </td>
                                    <td align="center">
                                        <input type="radio" :value="game.hometeam_id" v-model="game.favteam_id" />
                                    </td>
                                    <td align="left">
                                        <select v-model="game.hometeam_id">
                                            <option v-for="t in teams" :key="t.id" :value="t.id">{{ t.name }}</option>
                                        </select>
                                    </td>
                                    <td align="center">
                                        <input v-model="game.hometeam_pts" type="text" size="4" />
                                    </td>
                                    <td align="center">
                                        <input v-model="game.gamedate" type="datetime-local" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="10">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="10">Current Weekly State</td>
                                </tr>
                                <tr>
                                    <td colspan="10">
                                        <div class="mt-2">
                                            <div v-for="option in [
                                                [0, 'Initial State, Schedule Entered, No Point Spread'],
                                                [1, 'Point Spread Added, Users Can Enter Picks'],
                                                [2, 'Lock Picks, Process Default Picks'],
                                                [3, 'Picks are Locked'],
                                                [4, 'Final Scores Entered, Process Results'],
                                                [5, 'Results Processed'],
                                                [6, 'Delete Weekly Default Picks'],
                                                [7, 'Delete Weekly Results'],
                                            ]" :key="option[0]">
                                                <label class="inline-flex items-center">
                                                    <input class="form-radio" type="radio" :value="option[0]" v-model="form.state" />
                                                    <span class="ml-2">{{ option[1] }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="10">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="10">
                                        <button type="submit" class="border-gray-500 rounded-lg px-4 py-2 text-black hover:bg-red-500" :disabled="form.processing">
                                            Submit
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
