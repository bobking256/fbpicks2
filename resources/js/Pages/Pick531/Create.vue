<script setup>
import { computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { store } from '@/routes/pick531';
import admin from '@/routes/admin';

const props = defineProps({
    picks: Object,
    teams: Array,
    rembonus: Number,
    scheds: Array,
    weekno: Number,
    adminUser: Object,
});

const initialSelection = (schedIndex) => {
    const s = props.scheds[schedIndex];
    const favIsAway = s.awayteam_id === s.favoriteteam_id;
    const favTeam = favIsAway ? s.awayteam_id : s.hometeam_id;
    const dogTeam = favIsAway ? s.hometeam_id : s.awayteam_id;

    const valueFor = (teamId) => {
        if (!props.picks) return '0';
        if (teamId === props.picks.pt5) return '5';
        if (teamId === props.picks.pt3) return '3';
        if (teamId === props.picks.pt1) return '1';
        return '0';
    };

    return { sela: valueFor(favTeam), selb: valueFor(dogTeam) };
};

const form = useForm({
    games: props.scheds.map((s, i) => initialSelection(i)),
    bonus: props.picks?.bonus ?? 0,
});

const teamName = (id) => props.teams[id - 1]?.name ?? '';
const teamHelmet = (id) => props.teams[id - 1]?.gif ?? '';

const rows = computed(() => props.scheds.map((s) => {
    const favIsAway = s.awayteam_id === s.favoriteteam_id;
    const favId = favIsAway ? s.awayteam_id : s.hometeam_id;
    const dogId = favIsAway ? s.hometeam_id : s.awayteam_id;
    let favLabel = favIsAway ? teamName(s.awayteam_id) : teamName(s.hometeam_id).toUpperCase();
    if (favIsAway) favLabel = favLabel.toUpperCase();
    if (s.default_game == 5) favLabel += ' [5]';
    if (s.default_game == 3) favLabel += ' [3]';
    if (s.default_game == 1) favLabel += ' [1]';

    return {
        favId,
        dogId,
        favLabel,
        favHelmet: teamHelmet(favId),
        dogLabel: teamName(dogId),
        dogHelmet: teamHelmet(dogId),
        pointSpread: s.point_spread,
        noline: s.noline,
        gamedate: new Date(s.gamedate).toLocaleString('en-US', {
            weekday: 'long', month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit',
        }),
    };
}));

const showBonus = computed(() => props.weekno > 2 && props.weekno < 18);

const rowHasDoublePick = computed(() => form.games.some((g) => g.sela !== '0' && g.selb !== '0'));

const pointsUsedOnce = computed(() => {
    const values = form.games.flatMap((g) => [g.sela, g.selb]);
    return ['5', '3', '1'].every((points) => values.filter((v) => v === points).length === 1);
});

const bonusForbiddenTeamIds = computed(() => {
    const forbidden = new Set();
    rows.value.forEach((row, i) => {
        const game = form.games[i];
        if (game.sela !== '0') forbidden.add(row.dogId);
        if (game.selb !== '0') forbidden.add(row.favId);
    });
    return forbidden;
});

const availableBonusTeams = computed(() => props.teams.filter((t) => !bonusForbiddenTeamIds.value.has(t.id)));

const validationError = computed(() => {
    if (rowHasDoublePick.value) return 'A game cannot have picks on both the favorite and the underdog.';
    if (!pointsUsedOnce.value) return 'Each of 5, 3, and 1 points must be picked exactly once.';
    if (form.bonus && bonusForbiddenTeamIds.value.has(form.bonus)) {
        return 'The bonus pick cannot be the opponent of a team you already picked for 5, 3, or 1 points.';
    }
    return null;
});

const submit = () => {
    if (validationError.value) return;

    const action = props.adminUser
        ? admin.storepick531(props.adminUser.id)
        : store();

    form.post(action.url);
};
</script>

<template>
    <Head title="Pick 5-3-1" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">
                Pick 5-3-1 for Week No. {{ weekno }}
                <span v-if="adminUser"> &mdash; {{ adminUser.name }}</span>
            </h2>
        </template>

        <div v-if="form.errors.games" class="text-red-800 font-bold px-4 py-4">
            {{ form.errors.games }}
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-4">
                    <form @submit.prevent="submit">
                        <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                    <th class="px-2 py-2"></th>
                                    <th class="px-2 py-2" colspan="2">Favored Team</th>
                                    <th class="px-2 py-2">Pt Spread</th>
                                    <th class="px-2 py-2" colspan="2">Underdog Team</th>
                                    <th class="px-2 py-2"></th>
                                    <th class="px-2 py-2">Game Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, i) in rows" :key="i" class="border-t border-gray-200" :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'">
                                    <td class="px-2 py-1 text-right align-middle">
                                        <select v-if="!row.noline" v-model="form.games[i].sela" class="rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500">
                                            <option value="0">0</option>
                                            <option value="5">5</option>
                                            <option value="3">3</option>
                                            <option value="1">1</option>
                                        </select>
                                    </td>
                                    <td class="px-2 py-1 text-center align-middle"><img :src="`/images/nfl/${row.favHelmet}`" class="inline-block h-6 w-auto" /></td>
                                    <td class="px-2 py-1 text-left align-middle font-semibold">{{ row.favLabel }}</td>
                                    <td class="px-2 py-1 text-center align-middle font-semibold">{{ row.pointSpread }}</td>
                                    <td class="px-2 py-1 text-right align-middle font-semibold">{{ row.dogLabel }}</td>
                                    <td class="px-2 py-1 text-center align-middle"><img :src="`/images/nfl/${row.dogHelmet}`" class="inline-block h-6 w-auto" /></td>
                                    <td class="px-2 py-1 text-left align-middle">
                                        <select v-if="!row.noline" v-model="form.games[i].selb" class="rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500">
                                            <option value="0">0</option>
                                            <option value="5">5</option>
                                            <option value="3">3</option>
                                            <option value="1">1</option>
                                        </select>
                                    </td>
                                    <td class="px-2 py-1 text-sm text-gray-600">{{ row.gamedate }}</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>

                        <div class="mt-4 flex flex-wrap items-center gap-x-8 gap-y-2">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold">Bonus Pick:</span>
                                <select v-if="showBonus" v-model="form.bonus" class="rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500">
                                    <option :value="0"></option>
                                    <option v-for="t in availableBonusTeams" :key="t.id" :value="t.id">{{ t.name }}</option>
                                </select>
                                <span v-else class="text-gray-500">Not Available.</span>
                            </div>
                            <span class="font-semibold">Current Bonus Remaining: {{ rembonus }}</span>
                        </div>

                        <div v-if="validationError" class="mt-4 text-center text-red-800 font-bold">
                            {{ validationError }}
                        </div>

                        <div class="mt-6 text-center">
                            <button
                                class="font-bold rounded-lg text-white bg-nfl-navy-700 hover:bg-nfl-navy-600 disabled:opacity-50 transition px-4 py-2"
                                type="submit"
                                :disabled="form.processing || !!validationError"
                            >
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
