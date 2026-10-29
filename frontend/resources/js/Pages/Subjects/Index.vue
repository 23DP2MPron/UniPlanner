<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    subjects: Array,
});
</script>

<template>
    <Head title="Subjects" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Subjects
                </h2>
                <Link :href="route('subjects.create')">
                    <PrimaryButton>Add Subject</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div v-if="subjects.length === 0" class="text-center py-8 text-gray-500">
                            No subjects yet. Create your first subject to get started!
                        </div>

                        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div
                                v-for="subject in subjects"
                                :key="subject.id"
                                class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <div
                                                v-if="subject.color"
                                                class="w-4 h-4 rounded"
                                                :style="{ backgroundColor: subject.color }"
                                            ></div>
                                            <h3 class="text-lg font-semibold">{{ subject.name }}</h3>
                                        </div>
                                        <p v-if="subject.description" class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                            {{ subject.description }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <Link
                                        :href="route('subjects.edit', subject.id)"
                                        class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                    >
                                        Edit
                                    </Link>
                                    <Link
                                        :href="route('subjects.destroy', subject.id)"
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