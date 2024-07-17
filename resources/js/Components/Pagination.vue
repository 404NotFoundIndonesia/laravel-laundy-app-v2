<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: Array,
    from: Number,
    to: Number,
    total: Number,
});
</script>

<template>
    <div v-if="links.length > 3">
        <nav class="flex items-center flex-column flex-nowrap md:flex-row justify-between pt-4" aria-label="Table navigation">
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span class="font-semibold text-gray-900 dark:text-white">{{ from }}-{{ to }}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{ total }}</span></span>
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                <template v-for="(link, p) in links" :key="p">
                    <li v-if="link.url == null">
                        <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        :class="{ 'rounded-s-lg': p === 0, 'rounded-e-lg': links.length - 1 === p }"
                        v-html="link.label"></span>
                    </li>
                    <li v-else-if="!link.active">
                        <Link
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            :class="{ 'rounded-s-lg': p === 0, 'rounded-e-lg': links.length - 1 === p }"
                            :href="link.url">
                            <span v-html="link.label"></span>
                        </Link>
                    </li>
                    <li v-else>
                        <span aria-current="page" class="flex items-center justify-center px-3 h-8 text-emerald-600 border border-gray-300 bg-emerald-50 hover:bg-emerald-100 hover:text-emerald-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                        :class="{ 'rounded-s-lg': p === 0, 'rounded-e-lg': links.length - 1 === p }"
                        v-html="link.label"></span>
                    </li>
                </template>
            </ul>
        </nav>
    </div>
</template>
