<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import ActionMessage from "@/Components/ActionMessage.vue";

const form = useForm({
    name: null,
    contact_person: null,
    email: null,
    phone: null,
    address: null,
});

const submit = () => {
    form.post(route('supplier.store'), {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <AppLayout title="Supplier">
        <template #header>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 rtl:space-x-reverse">
                    <li>
                        <Link :href="route('supplier.index')">
                            <h2 class="font-semibold text-xl text-gray-400 hover:text-gray-600 leading-tight">
                                Supplier
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
                            Add New Supplier
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
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <div>
                                    <InputLabel for="name" value="Company" :required="true"/>
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
                                    <InputLabel for="email" value="Email"/>
                                    <TextInput
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        autocomplete="off"
                                    />
                                    <InputError :message="form.errors.email" class="mt-2"/>
                                </div>
                                <div>
                                    <InputLabel for="contact_person" value="Contact Person" :required="true"/>
                                    <TextInput
                                        id="contact_person"
                                        v-model="form.contact_person"
                                        type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="off"
                                    />
                                    <InputError :message="form.errors.contact_person" class="mt-2"/>
                                </div>
                                <div>
                                    <InputLabel for="phone" value="Phone" :required="true"/>
                                    <TextInput
                                        id="phone"
                                        v-model="form.phone"
                                        type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="off"
                                    />
                                    <InputError :message="form.errors.phone" class="mt-2"/>
                                </div>
                                <div class="sm:col-span-2">
                                    <InputLabel for="address" value="Address"/>
                                    <textarea id="address" v-model="form.address" rows="3"
                                              class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm"></textarea>
                                    <InputError :message="form.errors.address" class="mt-2"/>

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
