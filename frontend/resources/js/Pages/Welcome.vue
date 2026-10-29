<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome to UniPlanner" />
    <div class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
        <div class="relative min-h-screen flex flex-col items-center justify-center px-6">
            <!-- Navigation -->
            <nav v-if="canLogin" class="absolute top-0 right-0 p-6 flex gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-lg px-6 py-2 bg-white/10 backdrop-blur-sm text-white font-medium hover:bg-white/20 transition-all duration-300 border border-white/20"
                >
                    Dashboard
                </Link>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-lg px-6 py-2 bg-white/10 backdrop-blur-sm text-white font-medium hover:bg-white/20 transition-all duration-300 border border-white/20"
                    >
                        Log in
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-lg px-6 py-2 bg-white text-indigo-600 font-medium hover:bg-white/90 transition-all duration-300 shadow-lg"
                    >
                        Get Started
                    </Link>
                </template>
            </nav>

            <!-- Hero Section -->
            <div class="max-w-5xl mx-auto text-center text-white">
                <!-- Logo/Icon -->
                <div class="mb-8 flex justify-center">
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-3xl border border-white/20 shadow-2xl">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <h1 class="text-6xl font-bold mb-6 drop-shadow-lg">
                    Welcome to UniPlanner
                </h1>
                <p class="text-2xl mb-12 text-white/90 max-w-2xl mx-auto">
                    Your all-in-one solution for managing university life. Organize tasks, track assignments, and schedule events effortlessly.
                </p>

                <!-- CTA Buttons -->
                <div v-if="!$page.props.auth.user" class="flex gap-4 justify-center mb-16">
                    <Link
                        :href="route('register')"
                        class="rounded-lg px-8 py-4 bg-white text-indigo-600 font-semibold text-lg hover:bg-white/90 transition-all duration-300 shadow-2xl hover:scale-105"
                    >
                        Start Planning Today
                    </Link>
                    <Link
                        :href="route('login')"
                        class="rounded-lg px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold text-lg hover:bg-white/20 transition-all duration-300 border-2 border-white/30"
                    >
                        Sign In
                    </Link>
                </div>
            </div>

            <!-- Features Section -->
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
                <!-- Feature 1: Tasks -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="bg-white/20 w-16 h-16 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Task Management</h3>
                    <p class="text-white/80">
                        Create and track tasks with priorities, due dates, and status updates. Never miss an assignment again.
                    </p>
                </div>

                <!-- Feature 2: Calendar -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="bg-white/20 w-16 h-16 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Event Calendar</h3>
                    <p class="text-white/80">
                        Schedule lectures, exams, and study sessions. Keep all your important dates in one place.
                    </p>
                </div>

                <!-- Feature 3: Subjects -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="bg-white/20 w-16 h-16 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Subject Organization</h3>
                    <p class="text-white/80">
                        Organize your courses with custom colors and descriptions. Keep everything categorized and accessible.
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <footer class="absolute bottom-0 w-full py-6 text-center text-white/60">
                <p>UniPlanner &copy; 2026 - Organize your academic life</p>
            </footer>
        </div>
    </div>
</template>
