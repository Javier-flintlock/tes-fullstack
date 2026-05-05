<script setup lang="ts">
import NavBar from '@/components/NavBar.vue';

</script>

<template>
    <div class="flex h-screen overflow-hidden">
        <div class="sticky top-0 h-screen shrink-0">
            <NavBar />
        </div>
        <div class="flex-1 overflow-y-auto mt-10">
            <router-view />
        </div>
    </div>
</template>