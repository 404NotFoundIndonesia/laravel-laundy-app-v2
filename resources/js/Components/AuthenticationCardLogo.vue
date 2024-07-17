<script setup>
import { Link } from '@inertiajs/vue3';
import Logo from '@/Image/Logo.png';
</script>

<template>
    <Link :href="'/'">
        <img :src="Logo" alt="Logo" class="w-16">
    </Link>
</template>
