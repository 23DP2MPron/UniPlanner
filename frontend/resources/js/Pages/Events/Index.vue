<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';

defineProps({
    events: Array,
    subjects: Array,
});

const viewMode = ref('list'); // 'list' or 'calendar'

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
};

const formatTime = (time) => {
    if (!time) return '';
    return new Date(`2000-01-01 ${time}`).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
};

const formatDateTime = (date, time) => {
    if (!date) return '';
    let result = formatDate(date);
    if (time) {
        result += ' at ' + formatTime(time);
    }
    return result;
};
</script>

<template>
    <Head title="Calendar" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Calendar
                </h2>
                <div class="flex gap-2">
                    <Link :href="route('events.create')">
                        <PrimaryButton>Add Event</PrimaryButton>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div v-if="events.length === 0" class="text-center py-8 text-gray-500">
                            No events yet. Create your first event to get started!
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="event in events"
                                :key="event.id"
                                class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="text-lg font-semibold">{{ event.title }}</h3>
                                            <span
                                                v-if="event.event_type"
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300"
                                            >
                                                {{ event.event_type }}
                                            </span>
                                        </div>
                                        
                                        <p v-if="event.description" class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                            {{ event.description }}
                                        </p>

                                        <div class="mt-3 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                            <div v-if="event.subject" class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                <div
                                                    v-if="event.subject.color"
                                                    class="w-3 h-3 rounded"
                                                    :style="{ backgroundColor: event.subject.color }"
                                                ></div>
                                                <span>{{ event.subject.name }}</span>
                                            </div>

                                            <div v-if="event.start_date" class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>
                                                    <strong>Start:</strong> {{ formatDateTime(event.start_date, event.start_time) }}
                                                </span>
                                            </div>

                                            <div v-if="event.end_date" class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>
                                                    <strong>End:</strong> {{ formatDateTime(event.end_date, event.end_time) }}
                                                </span>
                                            </div>

                                            <div v-if="event.location" class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span>{{ event.location }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <Link
                                        :href="route('events.edit', event.id)"
                                        class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                    >
                                        Edit
                                    </Link>
                                    <Link
                                        :href="route('events.destroy', event.id)"
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