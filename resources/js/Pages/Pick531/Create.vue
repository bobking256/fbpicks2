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

const submit = () => {
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
                        <table class="table table-fixed">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th colspan="2">Favored Team</th>
                                    <th>Pt Spread</th>
                                    <th colspan="2">Underdog Team</th>
                                    <th></th>
                                    <th>Game Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, i) in rows" :key="i">
                                    <td class="px-2 py-1" valign="middle" align="right">
                                        <select v-if="!row.noline" v-model="form.games[i].sela">
                                            <option value="0">0</option>
                                            <option value="5">5</option>
                                            <option value="3">3</option>
                                            <option value="1">1</option>
                                        </select>
                                    </td>
                                    <td class="px-2 py-1" align="center" valign="middle"><img :src="`/images/nfl/${row.favHelmet}`" /></td>
                                    <td class="px-2 py-1" align="left" valign="middle"><div align="left" class="style2">{{ row.favLabel }}</div></td>
                                    <td class="px-2 py-1" align="center" valign="middle"><div align="center" class="style2">{{ row.pointSpread }}</div></td>
                                    <td class="px-2 py-1" align="right" valign="middle"><div align="right" class="style2">{{ row.dogLabel }}</div></td>
                                    <td class="px-2 py-1" align="center" valign="middle"><img :src="`/images/nfl/${row.dogHelmet}`" /></td>
                                    <td class="px-2 py-1" align="left" valign="middle">
                                        <select v-if="!row.noline" v-model="form.games[i].selb">
                                            <option value="0">0</option>
                                            <option value="5">5</option>
                                            <option value="3">3</option>
                                            <option value="1">1</option>
                                        </select>
                                    </td>
                                    <td class="px-2 py-1">{{ row.gamedate }}</td>
                                </tr>

                                <tr class="my-2">
                                    <td colspan="3" align="right" valign="top"><span class="style2">Bonus Pick: </span></td>
                                    <td colspan="2" valign="top">
                                        <select v-if="showBonus" v-model="form.bonus">
                                            <option :value="0"></option>
                                            <option v-for="t in teams" :key="t.id" :value="t.id">{{ t.name }}</option>
                                        </select>
                                        <span v-else>Not Available.</span>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td colspan="2" valign="middle"><span class="style2">Current Bonus Remaining:&nbsp;&nbsp; {{ rembonus }}</span></td>
                                </tr>
                                <tr class="my-2">
                                    <td align="center" colspan="8">
                                        <button
                                            class="font-bold rounded-lg border-2 text-black bg-red-800 hover:bg-red-500 px-4 py-2"
                                            type="submit"
                                            :disabled="form.processing"
                                        >
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
