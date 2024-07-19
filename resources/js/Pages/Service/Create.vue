<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link, useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import {validateNumber} from "@/util.js";

const page = usePage();

const form = useForm({
    name: null,
    unit: page.props.units[0],
    original_price: '0',
    sale_price: '0',
});

const submit = () => {
    form.transform(data => ({
        ...data,
        original_price: data.original_price.replace(/\./g, ''),
        sale_price: data.sale_price.replace(/\./g, ''),
    })).post(route('service.store'), {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <AppLayout title="Service">
        <template #header>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 rtl:space-x-reverse">
                    <li>
                        <Link :href="route('service.index')">
                            <h2 class="font-semibold text-xl text-gray-400 hover:text-gray-600 leading-tight">
                                Service
                            </h2>
                        </Link>
                    </li>
                    <li class="mx-2">
                        <div>
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </div>
                    </li>
                    <li aria-current="page">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Add New Service
                        </h2>
                    </li>
                </ol>
            </nav>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="py-6 mx-auto px-6 2xl:py-16 2xl:px-16">
                            <div class="grid gap-4 mb-4 sm:grid-cols-2 md:grid-cols-4">
                                <div class="md:col-span-3">
                                    <InputLabel for="name" value="Name" :required="true"/>
                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        autofocus
                                        autocomplete="off"
                                    />
                                    <InputError :message="form.errors.name" class="mt-2"/>
                                </div>
                                <div>
                                    <InputLabel for="unit" value="Unit" :required="true"/>
                                    <v-select
                                        id="currency"
                                        v-model="form.unit"
                                        class="mt-1 block w-full custom-v-select"
                                        :options="$page.props.units"></v-select>
                                    <InputError :message="form.errors.unit" class="mt-2"/>
                                </div>
                                <div class="md:col-span-2">
                                    <InputLabel for="original_price" value="Original Price" :required="true" />
                                    <div class="relative mt-1">
                                        <div class="absolute text-gray-400 inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                            Rp
                                        </div>
                                        <input
                                            type="text"
                                            id="original_price"
                                            @input="validateNumber( form,'original_price')"
                                            v-model="form.original_price"
                                            class="block w-full ps-14 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 dark:focus:border-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-600 rounded-md shadow-sm">
                                        <div class="absolute text-gray-400 inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                                            / {{ form.unit }}
                                        </div>
                                    </div>
                                    <InputError :message="form.errors.original_price" class="mt-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <InputLabel for="sale_price" value="Sale Price" />
                                    <div class="relative mt-1">
                                        <div class="absolute text-gray-400 inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                            Rp
                                        </div>
                                        <input
                                            type="text"
                                            id="sale_price"
                                            @input="validateNumber( form,'sale_price')"
                                            v-model="form.sale_price"
                                            class="block w-full ps-14 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 dark:focus:border-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-600 rounded-md shadow-sm">
                                        <div class="absolute text-gray-400 inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                                            / {{ form.unit }}
                                        </div>
                                    </div>
                                    <InputError :message="form.errors.sale_price" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                                Saved.
                            </ActionMessage>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
