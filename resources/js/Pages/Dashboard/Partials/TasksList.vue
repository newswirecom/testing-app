<script setup>
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import TaskInfo from "@/Pages/Dashboard/Partials/TaskInfo.vue";
import { router } from '@inertiajs/vue3'
import normalizeTaskStatus from "../../../helpers/normalizeTaskStatus.js";
import TaskStatusEnum from "@/Enums/TaskStatusEnum.ts";

const displayTaskInfoModal = ref(null);
const selectedTask = ref(null);

defineProps({
    tasks: {
        type: Array,
    },
});

const displayTaskInfoModalDetails = (task) => {
    displayTaskInfoModal.value = true;
    selectedTask.value = task;
};


const takeOn = (task_id) => {
    router.post(route('tasks.takeon', {task: task_id}), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => console.log('error'), // Handle Error here - Add a message to user or something like that
    });
};

const closeModal = () => {
    displayTaskInfoModal.value = false;
};

</script>

<template>
    <section class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Owner</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">View</span>
                </th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Take On</span>
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">

            <template v-for="(task, index) in tasks" :key="index">
                <tr>
                    <td class="text-wrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                        {{ task.name }}
                    </td>
                    <td class="text-wrap px-3 py-4 text-sm text-gray-500">
                        {{ task.description }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ task.user_name ?? "-" }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ normalizeTaskStatus[task.status] }}
                    </td>
                    <td class="relative whitespace-nowrap py-4 px-3 text-right text-sm font-medium sm:pr-6">
                        <span @click="displayTaskInfoModalDetails(task)" class="text-indigo-600 hover:text-indigo-900 cursor-pointer">View</span>
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                        <template v-if="task.user_id !== $page.props.auth.user.id">
                            <span @click="takeOn(task.id)" class="text-indigo-600 hover:text-indigo-900 cursor-pointer">Take On</span>
                        </template>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </section>

    <modal :show="displayTaskInfoModal" @close="closeModal">
        <task-info :task="selectedTask" @close-modal="closeModal"/>
    </modal>
</template>
