<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    subjects: Array,
});

const form = useForm({
    title: '',
    description: '',
    subject_id: '',
    start_date: '',
    start_time: '',
    end_date: '',
    end_time: '',
    location: '',
    event_type: '',
});

const submit = () => {
    form.post(route('events.store'));
};
</script>

<template>
    <Head title="Create Event" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Create Event
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel for="title" value="Event Title" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                />
                                <InputError :message="form.errors.title" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="description" value="Description (Optional)" />
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    rows="3"
                                ></textarea>
                                <InputError :message="form.errors.description" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="subject_id" value="Subject (Optional)" />
                                    <select
                                        id="subject_id"
                                        v-model="form.subject_id"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    >
                                        <option value="">None</option>
                                        <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                            {{ subject.name }}
                                        </option>
                                    </select>
                                    <InputError :message="form.errors.subject_id" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="event_type" value="Event Type (Optional)" />
                                    <TextInput
                                        id="event_type"
                                        v-model="form.event_type"
                                        type="text"
                                        class="mt-1 block w-full"
                                        placeholder="e.g., Lecture, Exam, Meeting"
                                    />
                                    <InputError :message="form.errors.event_type" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="start_date" value="Start Date" />
                                    <TextInput
                                        id="start_date"
                                        v-model="form.start_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.start_date" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="start_time" value="Start Time (Optional)" />
                                    <TextInput
                                        id="start_time"
                                        v-model="form.start_time"
                                        type="time"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError :message="form.errors.start_time" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="end_date" value="End Date (Optional)" />
                                    <TextInput
                                        id="end_date"
                                        v-model="form.end_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError :message="form.errors.end_date" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="end_time" value="End Time (Optional)" />
                                    <TextInput
                                        id="end_time"
                                        v-model="form.end_time"
                                        type="time"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError :message="form.errors.end_time" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <InputLabel for="location" value="Location (Optional)" />
                                <TextInput
                                    id="location"
                                    v-model="form.location"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="e.g., Room 101, Online"
                                />
                                <InputError :message="form.errors.location" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">
                                    Create Event
                                </PrimaryButton>

                                <a
                                    :href="route('events.index')"
                                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                                >
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>