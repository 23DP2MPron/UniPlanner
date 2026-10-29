<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    upcomingTasks: Array,
    overdueTasks: Array,
    upcomingEvents: Array,
    stats: Object,
});

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
};

const formatTime = (time) => {
    if (!time) return '';
    return new Date(`2000-01-01 ${time}`).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
};

const getPriorityColor = (priority) => {
    const colors = {
        low: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        medium: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        high: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
    };
    return colors[priority] || colors.medium;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Subjects</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ stats.total_subjects }}
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tasks</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ stats.total_tasks }}
                        </div>
                        <div class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                            {{ stats.completed_tasks }} completed, {{ stats.pending_tasks }} pending
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Overdue Tasks</div>
                        <div class="mt-2 text-3xl font-bold text-red-600 dark:text-red-400">
                            {{ stats.overdue_count }}
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Events</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ stats.total_events }}
                        </div>
                    </div>
                </div>

                <!-- Overdue Tasks -->
                <div v-if="overdueTasks.length > 0" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Overdue Tasks
                            </h3>
                            <Link :href="route('tasks.index')" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                View All
                            </Link>
                        </div>
                        <div class="space-y-3">
                            <div
                                v-for="task in overdueTasks"
                                :key="task.id"
                                class="border-l-4 border-red-500 bg-red-50 dark:bg-red-900/20 p-3 rounded"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <Link
                                                :href="route('tasks.edit', task.id)"
                                                class="font-medium text-gray-900 dark:text-gray-100 hover:text-blue-600"
                                            >
                                                {{ task.title }}
                                            </Link>
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full"
                                                :class="getPriorityColor(task.priority)"
                                            >
                                                {{ task.priority }}
                                            </span>
                                        </div>
                                        <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            Due: {{ formatDate(task.due_date) }}
                                            <span v-if="task.due_time">at {{ formatTime(task.due_time) }}</span>
                                        </div>
                                        <div v-if="task.subject" class="mt-1 flex items-center gap-1 text-xs">
                                            <div
                                                v-if="task.subject.color"
                                                class="w-3 h-3 rounded"
                                                :style="{ backgroundColor: task.subject.color }"
                                            ></div>
                                            <span class="text-gray-600 dark:text-gray-400">{{ task.subject.name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Tasks and Events Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Upcoming Tasks -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Upcoming Tasks
                                </h3>
                                <Link :href="route('tasks.index')" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    View All
                                </Link>
                            </div>
                            <div v-if="upcomingTasks.length === 0" class="text-center py-8 text-gray-500">
                                No upcoming tasks
                            </div>
                            <div v-else class="space-y-3">
                                <div
                                    v-for="task in upcomingTasks"
                                    :key="task.id"
                                    class="border border-gray-200 dark:border-gray-700 rounded-lg p-3"
                                >
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <Link
                                                    :href="route('tasks.edit', task.id)"
                                                    class="font-medium text-gray-900 dark:text-gray-100 hover:text-blue-600"
                                                >
                                                    {{ task.title }}
                                                </Link>
                                                <span
                                                    class="px-2 py-1 text-xs font-medium rounded-full"
                                                    :class="getPriorityColor(task.priority)"
                                                >
                                                    {{ task.priority }}
                                                </span>
                                            </div>
                                            <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                Due: {{ formatDate(task.due_date) }}
                                                <span v-if="task.due_time">at {{ formatTime(task.due_time) }}</span>
                                            </div>
                                            <div v-if="task.subject" class="mt-1 flex items-center gap-1 text-xs">
                                                <div
                                                    v-if="task.subject.color"
                                                    class="w-3 h-3 rounded"
                                                    :style="{ backgroundColor: task.subject.color }"
                                                ></div>
                                                <span class="text-gray-600 dark:text-gray-400">{{ task.subject.name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Events -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Upcoming Events
                                </h3>
                                <Link :href="route('events.index')" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    View All
                                </Link>
                            </div>
                            <div v-if="upcomingEvents.length === 0" class="text-center py-8 text-gray-500">
                                No upcoming events
                            </div>
                            <div v-else class="space-y-3">
                                <div
                                    v-for="event in upcomingEvents"
                                    :key="event.id"
                                    class="border border-gray-200 dark:border-gray-700 rounded-lg p-3"
                                >
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <Link
                                                    :href="route('events.edit', event.id)"
                                                    class="font-medium text-gray-900 dark:text-gray-100 hover:text-blue-600"
                                                >
                                                    {{ event.title }}
                                                </Link>
                                                <span
                                                    v-if="event.event_type"
                                                    class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300"
                                                >
                                                    {{ event.event_type }}
                                                </span>
                                            </div>
                                            <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                {{ formatDate(event.start_date) }}
                                                <span v-if="event.start_time">at {{ formatTime(event.start_time) }}</span>
                                            </div>
                                            <div v-if="event.location" class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                                📍 {{ event.location }}
                                            </div>
                                            <div v-if="event.subject" class="mt-1 flex items-center gap-1 text-xs">
                                                <div
                                                    v-if="event.subject.color"
                                                    class="w-3 h-3 rounded"
                                                    :style="{ backgroundColor: event.subject.color }"
                                                ></div>
                                                <span class="text-gray-600 dark:text-gray-400">{{ event.subject.name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
