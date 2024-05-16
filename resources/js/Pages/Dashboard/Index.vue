<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TasksList from "@/Pages/Dashboard/Partials/TasksList.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import TaskInfo from "@/Pages/Dashboard/Partials/TaskInfo.vue";

defineProps({
    tasks: {
        type: Array,
    },
});

const displayCreateTaskModal = ref(null);

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <section class="max-w-7xl mx-auto sm:px-6 lg:px-4 py-4 my-4">
            <section class="py-4 my-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="p-6 text-gray-900">Welcome {{ $page.props.auth.user.name }}</h2>
                </div>
            </section>

            <tasks-list :tasks="tasks"/>

            <modal :show="displayCreateTaskModal" @close="null">
                <task-info :task="null" @update:completed="null"/>
            </modal>
        </section>
    </AuthenticatedLayout>
</template>
