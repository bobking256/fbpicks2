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
                    <p class="text-sm text-gray-500 mb-4">Picks must be entered by: <span class="font-semibold text-nfl-navy-800">{{ picktime }}</span></p>

                    <form @submit.prevent="submit">
                        <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                    <th class="px-2 py-2"></th>
                                    <th class="px-2 py-2" colspan="2">Favorite</th>
                                    <th class="px-2 py-2 text-center">Points</th>
                                    <th class="px-2 py-2 text-right" colspan="2">Underdog</th>
                                    <th class="px-2 py-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(row, i) in rows" :key="row.field">
                                    <tr v-if="row.isMondayNight">
                                        <th colspan="7" class="px-2 pt-4 pb-1 text-center font-semibold text-nfl-navy-800">Monday Night</th>
                                    </tr>
                                    <tr class="border-t border-gray-200" :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'">
                                        <td class="px-2 py-1 text-right align-middle">
                                            <input v-if="!row.noline" type="radio" :value="row.favId" v-model="form[row.field]" :aria-label="`Pick ${row.favLabel} to win`" class="border-gray-300 text-nfl-navy-700 focus:ring-nfl-navy-500" />
                                        </td>
                                        <td class="px-2 py-1 text-center align-middle"><img :src="`/images/nfl/${row.favHelmet}`" class="inline-block h-6 w-auto" /></td>
                                        <td class="px-2 py-1 text-left align-middle font-semibold">{{ row.favLabel }}</td>
                                        <td class="px-2 py-1 text-center align-middle font-semibold">{{ row.pointSpread }}</td>
                                        <td class="px-2 py-1 text-right align-middle font-semibold">{{ row.dogLabel }}</td>
                                        <td class="px-2 py-1 text-center align-middle"><img :src="`/images/nfl/${row.dogHelmet}`" class="inline-block h-6 w-auto" /></td>
                                        <td class="px-2 py-1 text-left align-middle">
                                            <input v-if="!row.noline" type="radio" :value="row.dogId" v-model="form[row.field]" :aria-label="`Pick ${row.dogLabel} to win`" class="border-gray-300 text-nfl-navy-700 focus:ring-nfl-navy-500" />
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <span class="font-semibold">Monday Night Football Total Pts:</span>
                            <input type="text" v-model="form.totpts" size="4" class="rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500" />
                        </div>

                        <div class="mt-6 text-center">
                            <button class="font-bold text-white rounded-lg bg-nfl-navy-700 hover:bg-nfl-navy-600 disabled:opacity-50 transition px-4 py-2" type="submit" :disabled="form.processing">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
