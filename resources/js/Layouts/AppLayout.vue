<script setup>
import Sidebar from '../Layouts/Sidebar.vue'
</script>

<template>
    <div class="min-h-screen bg-slate-50">

        <Sidebar />

        <main class="lg:ml-64 min-h-screen">
            <div class="p-4 sm:p-6 lg:p-8">
                <slot />
            </div>
        </main>

    </div>
</template>