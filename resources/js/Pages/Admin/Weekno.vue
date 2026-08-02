<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import admin from '@/routes/admin';

const props = defineProps({
    weekno: Object,
});

const page = usePage();

const toLocalInput = (value) => {
    if (!value || value === 'now') return '';
    const d = new Date(value);
    const pad = (n) => String(n).padStart(2, '0');
    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
};

const fields = {};
for (let i = 0; i < 18; i++) {
    fields[`weektime${i}`] = toLocalInput(props.weekno[`weektime${i}`]);
    fields[`picktime${i}`] = toLocalInput(props.weekno[`picktime${i}`]);
}
const form = useForm(fields);

const submit = () => {
    form.post(admin.storeweekno().url);
};
</script>

<template>
    <Head title="Weekly Schedule" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Weekly Schedule</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <p class="mb-2 text-sm text-gray-600">
                    Week Time is the date and time that ends a week and begins the next. Typically this is a
                    Wednesday 9am or noon time where the point spread is entered for the next week and users can
                    begin selecting picks.
                </p>
                <p class="mb-4 text-sm text-gray-600">Pick Time is the deadline for getting picks in.</p>

                <div v-if="page.props.flash.success" class="mb-4 text-green-700 font-bold px-4">
                    {{ page.props.flash.success }}
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                    <th class="px-3 py-2 text-center">Wk No</th>
                                    <th class="px-3 py-2 text-left">Week Time</th>
                                    <th class="px-3 py-2 text-left">Pick Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="i in 18"
                                    :key="i"
                                    class="border-t border-gray-200"
                                    :class="i % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
                                >
                                    <td class="px-3 py-2 text-center font-semibold text-nfl-navy-800">{{ i }}</td>
                                    <td class="px-3 py-2">
                                        <input type="datetime-local" v-model="form[`weektime${i - 1}`]" class="rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500" />
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="datetime-local" v-model="form[`picktime${i - 1}`]" class="rounded border-gray-300 text-sm focus:border-nfl-navy-500 focus:ring-nfl-navy-500" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>

                        <div class="mt-6 mb-4 text-center">
                            <button
                                class="px-4 py-2 text-white bg-nfl-navy-700 hover:bg-nfl-navy-600 disabled:opacity-50 transition font-bold rounded-lg"
                                type="submit"
                                :disabled="form.processing"
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
