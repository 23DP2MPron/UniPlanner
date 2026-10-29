<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    tasks: Array,
    subjects: Array,
});

const getPriorityColor = (priority) => {
    const colors = {
        low: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        medium: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        high: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
    };
    return colors[priority] || colors.medium;
};

const getStatusColor = (status) => {
    const colors = {
        pending: 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
        in_progress: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        completed: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
    };
    return colors[status] || colors.pending;
};

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
};

const formatTime = (time) => {
    if (!time) return '';
    return new Date(`2000-01-01 ${time}`).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
};
</script>

<template>
    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Tasks
                </h2>
                <Link :href="route('tasks.create')">
                    <PrimaryButton>Add Task</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div v-if="tasks.length === 0" class="text-center py-8 text-gray-500">
                            No tasks yet. Create your first task to get started!
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="task in tasks"
                                :key="task.id"
                                class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="text-lg font-semibold">{{ task.title }}</h3>
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full"
                                                :class="getPriorityColor(task.priority)"
                                            >
                                                {{ task.priority }}
                                            </span>
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full"
                                                :class="getStatusColor(task.status)"
                                            >
                                                {{ task.status.replace('_', ' ') }}
                                            </span>
                                        </div>
                                        
                                        <p v-if="task.description" class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                            {{ task.description }}
                                        </p>

                                        <div class="mt-3 flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                            <div v-if="task.subject" class="flex items-center gap-1">
                                                <div
                                                    v-if="task.subject.color"
                                                    class="w-3 h-3 rounded"
                                                    :style="{ backgroundColor: task.subject.color }"
                                                ></div>
                                                <span>{{ task.subject.name }}</span>
                                            </div>
                                            
                                            <div v-if="task.due_date" class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ formatDate(task.due_date) }}</span>
                                                <span v-if="task.due_time">{{ formatTime(task.due_time) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <Link
                                        :href="route('tasks.edit', task.id)"
                                        class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                    >
                                        Edit
                                    </Link>
                                    <Link
                                        :href="route('tasks.destroy', task.id)"
                                        method="delete"
                                        as="button"
                                        class="text-sm text-red-600 hover:text-red-800 dark:text-red-400"
                                        preserve-scroll
                                    >
                                        Delete
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>