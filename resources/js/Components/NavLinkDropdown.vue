<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
const props = defineProps({
    active: Boolean,
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '48',
    },
    contentClasses: {
        type: Array,
        default: () => ['py-1', 'bg-white'],
    },
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex cursor-pointer items-center px-1 pt-1 border-b-2 border-rose-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-rose-700 transition duration-150 ease-in-out relative'
        : 'inline-flex cursor-pointer items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out relative';
});

let open = ref(false);

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
    return {
        '48': 'w-48',
    }[props.width.toString()];
});

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'ltr:origin-top-left rtl:origin-top-right start-0';
    }

    if (props.align === 'right') {
        return 'ltr:origin-top-right rtl:origin-top-left end-0';
    }

    return 'origin-top';
});
</script>

<template>
    <div :class="classes">
        <div class="relative">

            <div @click="open = !open" class="flex items-center">
                <slot name="trigger"/>

                <svg class="ms-2 -me-0.5 h-4 w-4" :class="{ rotate: open }" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </div>

            <!-- Full Screen Dropdown Overlay -->
            <div v-show="open" class="fixed inset-0 z-40" @click="open = false"/>

            <transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95">
                <div
                    v-show="open"
                    class="absolute z-50 mt-2 rounded-md shadow-lg"
                    :class="[widthClass, alignmentClasses]"
                    style="display: none;"
                    @click="open = false">
                    <div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
                        <slot name="content"/>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<style>
svg {
    transition: all 0.3s;
}

svg.rotate {
    transform: scaleY(-1);
}
</style>
