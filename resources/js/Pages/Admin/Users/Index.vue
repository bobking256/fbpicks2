<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmDeleteButton from '@/Components/ConfirmDeleteButton.vue';
import admin from '@/routes/admin';

defineProps({
    users: Array,
});
</script>

<template>
    <Head title="Users" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Users</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                <th class="px-3 py-2 text-left">Id</th>
                                <th class="px-3 py-2 text-left">Name</th>
                                <th class="px-3 py-2 text-left">Email</th>
                                <th class="px-3 py-2 text-center">Pick 5-3-1</th>
                                <th class="px-3 py-2 text-center">Pick All</th>
                                <th class="px-3 py-2 text-center">Admin</th>
                                <th class="px-3 py-2 text-center" colspan="3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(u, i) in users"
                                :key="u.id"
                                class="border-t border-gray-200"
                                :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'"
                            >
                                <td class="px-3 py-2 text-left">
                                    <Link class="underline text-nfl-navy-700" :href="admin.edituser(u.id)">{{ u.id }}</Link>
                                </td>
                                <td class="px-3 py-2 text-left font-semibold text-nfl-navy-800">{{ u.name }}</td>
                                <td class="px-3 py-2 text-left text-gray-600">{{ u.email }}</td>
                                <td class="px-3 py-2 text-center" :class="u.pick531 ? 'text-green-600' : 'text-gray-300'">{{ u.pick531 ? '✓' : '—' }}</td>
                                <td class="px-3 py-2 text-center" :class="u.pickall ? 'text-green-600' : 'text-gray-300'">{{ u.pickall ? '✓' : '—' }}</td>
                                <td class="px-3 py-2 text-center" :class="u.admin ? 'text-green-600' : 'text-gray-300'">{{ u.admin ? '✓' : '—' }}</td>
                                <td class="px-3 py-2 text-center">
                                    <Link :href="admin.pick531(u.id)" class="underline text-nfl-navy-600 hover:text-nfl-red-600">Pick 5-3-1</Link>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <Link :href="admin.pickall(u.id)" class="underline text-nfl-navy-600 hover:text-nfl-red-600">Pick All</Link>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <ConfirmDeleteButton :action="admin.destroyuser(u.id).url" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
