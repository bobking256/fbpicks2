<script setup>
import { computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { store } from '@/routes/pickall';
import admin from '@/routes/admin';

const props = defineProps({
    scheds: Array,
    teams: Array,
    picks: Object,
    weekno: Number,
    picktime: String,
    adminUser: Object,
});

const fieldFor = (i) => 'p' + (i + 1);

const teamName = (id) => props.teams[id - 1]?.name ?? '';
const teamHelmet = (id) => props.teams[id - 1]?.gif ?? '';

const rows = computed(() => props.scheds.map((s, i) => {
    const favIsAway = s.awayteam_id === s.favoriteteam_id;
    const favId = favIsAway ? s.awayteam_id : s.hometeam_id;
    const dogId = favIsAway ? s.hometeam_id : s.awayteam_id;

    return {
        field: fieldFor(i),
        favId,
        dogId,
        favLabel: (favIsAway ? teamName(s.awayteam_id) : teamName(s.hometeam_id)).toUpperCase(),
        dogLabel: favIsAway ? teamName(s.hometeam_id) : teamName(s.awayteam_id),
        favHelmet: teamHelmet(favId),
        dogHelmet: teamHelmet(dogId),
        pointSpread: s.point_spread,
        noline: s.noline,
        isMondayNight: i === props.scheds.length - 1,
    };
}));

const formFields = Object.fromEntries(props.scheds.map((s, i) => [fieldFor(i), props.picks[fieldFor(i)] ?? null]));
const form = useForm({
    ...formFields,
    totpts: props.picks.totpts ?? 0,
});

const submit = () => {
    const action = props.adminUser
        ? admin.storepickall(props.adminUser.id)
        : store();

    form.post(action.url);
};
</script>

<template>
    <Head title="Pick All" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">
                Pick All - Home Teams in Caps for Week No. {{ weekno }}
                <span v-if="adminUser"> &mdash; {{ adminUser.name }}</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-4">
                    <form @submit.prevent="submit">
                        <div class="overflow-x-auto">
                        <table class="table table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="px-2 py-1"></th>
                                    <th class="px-2 py-1" colspan="2"><span class="style1">Favorite</span></th>
                                    <th class="px-2 py-1"><div align="center" class="style1">Points</div></th>
                                    <th class="px-2 py-1" colspan="2"><div align="right" class="style1">Underdog</div></th>
                                    <th class="px-2 py-1"></th>
                                    <th class="px-2 py-1"><span class="style4">Picks must be entered by: {{ picktime }}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="row in rows" :key="row.field">
                                    <tr v-if="row.isMondayNight">
                                        <th height="25"></th>
                                        <th colspan="8" align="center"><span class="style2">Monday Night</span></th>
                                    </tr>
                                    <tr>
                                        <td class="px-2 py-1" align="right" valign="middle">
                                            <input v-if="!row.noline" type="radio" :value="row.favId" v-model="form[row.field]" />
                                        </td>
                                        <td class="px-2 py-1" align="center" valign="middle"><img :src="`/images/nfl/${row.favHelmet}`" /></td>
                                        <td class="px-2 py-1" align="left" valign="middle">{{ row.favLabel }}</td>
                                        <td class="px-2 py-1" align="center" valign="middle">{{ row.pointSpread }}</td>
                                        <td class="px-2 py-1" align="right" valign="middle">{{ row.dogLabel }}</td>
                                        <td class="px-2 py-1" align="center" valign="middle"><img :src="`/images/nfl/${row.dogHelmet}`" /></td>
                                        <td class="px-2 py-1" align="left" valign="middle">
                                            <input v-if="!row.noline" type="radio" :value="row.dogId" v-model="form[row.field]" />
                                        </td>
                                        <td class="px-2 py-1"></td>
                                    </tr>
                                </template>

                                <tr>
                                    <td colspan="5" align="right" valign="middle"><span class="style2">Monday Night Football Total Pts </span></td>
                                    <td align="left" valign="middle" colspan="3">
                                        <input type="text" v-model="form.totpts" size="4" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" colspan="8">
                                        <button class="font-bold text-white rounded-lg bg-nfl-navy-700 hover:bg-nfl-navy-600 disabled:opacity-50 transition px-4 py-2" type="submit" :disabled="form.processing">
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
