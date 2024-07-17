<script setup>
import { watchEffect } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

watchEffect(async () => {
    const icon = page.props.jetstream.flash?.bannerStyle || 'success';
    const message = page.props.jetstream.flash?.banner;

    if (message) {
        window.toast.fire({
            icon: icon === 'success' ? 'success' : 'error',
            title: message,
        });
    }
});
</script>

<template>
</template>
