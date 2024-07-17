<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link} from "@inertiajs/vue3";
import {dateHumanFormat} from "@/util.js";

</script>

<template>
    <AppLayout title="Customer">
        <template #header>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 rtl:space-x-reverse">
                    <li>
                        <Link :href="route('customer.index')">
                            <h2 class="font-semibold text-xl text-gray-400 hover:text-gray-600 leading-tight">
                                Customer
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
                            {{ $page.props.customer.name }}
                        </h2>
                    </li>
                </ol>
            </nav>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div class="py-6 mx-auto px-6 2xl:py-16 2xl:px-16">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="mb-2 text-xl font-semibold leading-none text-gray-900 md:text-2xl dark:text-white">
                                    {{ $page.props.customer.name }}</h3>
                                <small class="text-gray-500">Member since:
                                    {{ dateHumanFormat($page.props.customer.created_at) }}</small>
                            </div>
                            <div class="px-4 py-3 flex items-center justify-end">
                                <button :id="`customer-id-${$page.props.customer.id}`"
                                        data-dropdown-placement="bottom-end"
                                        :data-dropdown-toggle="`customer-id-${$page.props.customer.id}-dropdown`"
                                        class="ms-1.5 inline-flex items-center px-0.5 py-2 text-sm font-medium text-center text-gray-500 bg-gray-50 hover:bg-gray-100 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-dots-vertical" width="20"
                                         height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                                        <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                                        <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                                    </svg>
                                </button>
                                <div :id="`customer-id-${$page.props.customer.id}-dropdown`"
                                     class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                        :aria-labelledby="`customer-id-${$page.props.customer.id}`">
                                        <li>
                                            <Link :href="route('customer.edit', $page.props.customer.id)"
                                                  class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Edit
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-3 mb-5">

                        <dl class="flex items-center space-x-6">
                            <div class="me-5">
                                <dt class="mb-1 text-sm font-semibold leading-none text-gray-600 dark:text-white">
                                    Phone
                                </dt>
                                <dd class="mb-4 text-sm font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                                    {{ $page.props.customer.phone }}
                                </dd>
                            </div>
                            <div v-if="$page.props.customer.email">
                                <dt class="mb-1 text-sm font-semibold leading-none text-gray-600 dark:text-white">
                                    Email
                                </dt>
                                <dd class="mb-4 text-sm font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                                    {{ $page.props.customer.email }}
                                </dd>
                            </div>
                        </dl>
                        <dl>
                            <dt class="mb-1 text-sm font-semibold leading-none text-gray-600 dark:text-white">Address
                            </dt>
                            <dd class="mb-4 text-sm font-light text-gray-500 sm:mb-5 dark:text-gray-400">
                                {{ $page.props.customer.address ?? '-' }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
