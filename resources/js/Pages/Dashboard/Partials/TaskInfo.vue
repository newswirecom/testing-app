<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {router, useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import normalizeTaskStatus from "@/helpers/normalizeTaskStatus.js";
import normalizeTaskPriority from "@/helpers/normalizeTaskPriority.js";
import TextareaInput from "@/Components/TextareaInput.vue";
import TaskStatusEnum from "@/Enums/TaskStatusEnum.ts";


const form = useForm(props.task);
const editingInfo = ref(false);
const nameInput = ref(null);
const descriptionInput = ref(null);
const statusInput = ref(null);
const priorityInput = ref(null);
const deadlineInput = ref(null);

const emit = defineEmits(['update:completed']);

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});

const cancelEdit = () => {
    editingInfo.value = false;
    form.reset();
};

const save = () => {
    form.patch(route('tasks.update', {task: props.task.id}), {
        preserveScroll: true,
        onSuccess: () => {
            editingInfo.value = false;
        },
        onError: () => {
            // Handle Error here - Add a message to user or something like that
            // Reset the form field to initial value?
        },
    });
};

const completeTask = () => {
    const url = route('tasks.update', {task: props.task.id});

    router.patch(url, { status: TaskStatusEnum.COMPLETED }, {
        preserveScroll: true,
        onSuccess: () => {
            emit('update:completed');
        },
        onError: () => console.log('error'), // Handle Error here - Add a message to user or something like that
    });
};

</script>

<template>
    <div class="p-6 my-4">
        <div class="flex flex-row justify-between">
            <h3 class="text-base font-semibold leading-7 text-gray-900">Task Details</h3>

            <template v-if="task.user_id === $page.props.auth.user.id && !editingInfo">
                <div class="space-x-2">
                    <SecondaryButton @click="editingInfo=true">Edit</SecondaryButton>

                    <template v-if="form.status === TaskStatusEnum.IN_PROGRESS">
                        <SecondaryButton @click="completeTask">Complete</SecondaryButton>
                    </template>
                </div>
            </template>

            <template v-else-if="editingInfo">
                <div class="space-x-2">
                    <SecondaryButton @click="cancelEdit">Cancel</SecondaryButton>
                    <SecondaryButton @click="save">Save</SecondaryButton>
                </div>
            </template>
        </div>
        <div class="mt-6 border-t border-gray-100">

                <div class="mt-6">
                    <InputLabel for="Name" value="Name" />

                    <TextInput
                        id="name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        :class="[`mt-1 w-full`, !editingInfo ? 'bg-gray-100' : '']"
                        placeholder="Name"
                        :disabled="!editingInfo"
                    />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="mt-6">
                    <InputLabel for="Description" value="Description" />

                    <TextareaInput
                        id="description"
                        ref="descriptionInput"
                        v-model="form.description"
                        type="text"
                        :class="[`mt-1 w-full`, !editingInfo ? 'bg-gray-100' : '']"
                        placeholder="Description"
                        :disabled="!editingInfo"
                    />

                    <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <div class="mt-6">
                    <InputLabel for="Status" value="Status" />

                    <SelectInput
                        id="status"
                        ref="statusInput"
                        v-model="form.status"
                        :values="normalizeTaskStatus"
                        type="text"
                        :class="[`mt-1 w-full`, !editingInfo ? 'bg-gray-100' : '']"
                        placeholder="Status"
                        :disabled="!editingInfo"
                    />

                    <InputError :message="form.errors.status" class="mt-2" />
                </div>

                <div class="mt-6">
                    <InputLabel for="Priority" value="Priority" />

                    <SelectInput
                        id="priority"
                        ref="priorityInput"
                        v-model="form.priority"
                        :values="normalizeTaskPriority"
                        type="text"
                        :class="[`mt-1 w-full`, !editingInfo ? 'bg-gray-100' : '']"
                        placeholder="Priority"
                        :disabled="!editingInfo"
                    />

                    <InputError :message="form.errors.priority" class="mt-2" />
                </div>

                <div class="mt-6">
                    <InputLabel for="due_at" value="Deadline" />

                    <TextInput
                        id="due_at"
                        ref="deadlineInput"
                        v-model="form.due_at"
                        type="date"
                        :class="[`mt-1 w-full`, !editingInfo ? 'bg-gray-100' : '']"
                        placeholder="Deadline"
                        :disabled="!editingInfo"
                    />

                    <InputError :message="form.errors.due_at" class="mt-2" />
                </div>

        </div>
    </div>
</template>
