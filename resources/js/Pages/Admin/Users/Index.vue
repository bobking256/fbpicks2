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
            <h2 class="font-semibold text-xl text-gray-700 leading-tight">Users</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="table table-auto px-8 py-4">
                        <thead>
                            <tr>
                                <th class="px-2 py-1">Id</th>
                                <th class="px-2 py-1">Name</th>
                                <th class="px-2 py-1">eMail</th>
                                <th class="px-2 py-1">Pick 5-3-1</th>
                                <th class="px-2 py-1">Pick All</th>
                                <th class="px-2 py-1">Admin</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="u in users" :key="u.id">
                                <td class="px-2 py-1">
                                    <Link class="underline text-blue-700" :href="admin.edituser(u.id)">{{ u.id }}</Link>
                                </td>
                                <td class="px-2 py-1">{{ u.name }}</td>
                                <td class="px-2 py-1">{{ u.email }}</td>
                                <td class="px-2 py-1"><input disabled type="checkbox" :checked="!!u.pick531" /></td>
                                <td class="px-2 py-1"><input disabled type="checkbox" :checked="!!u.pickall" /></td>
                                <td class="px-2 py-1"><input disabled type="checkbox" :checked="!!u.admin" /></td>
                                <td class="px-2 py-1">
                                    <Link :href="admin.pick531(u.id)" class="underline text-blue-500 hover:text-red-700">Pick 5-3-1</Link>
                                </td>
                                <td class="px-2 py-1">
                                    <Link :href="admin.pickall(u.id)" class="underline text-blue-500 hover:text-red-700">Pick All</Link>
                                </td>
                                <td class="px-2 py-1">
                                    <ConfirmDeleteButton :action="admin.destroyuser(u.id).url" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
