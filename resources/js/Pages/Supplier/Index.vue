<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import {Link, router, useForm, usePage} from '@inertiajs/vue3';
import {dateHumanFormat, deleteConfirmation} from '@/util';
import {ref} from "vue";

const page = usePage();
const selected = ref([]);

const filterForm = useForm({
    q: page.props.request?.q,
    size: page.props.request?.size ?? 50,
});

const filter = () => {
    filterForm.get(route('supplier.index'), {
        preserveState: true,
        preserveScroll: true,
    });
};

const selectAll = () => {
    if (selected.value.length === page.props.items.data?.length) {
        selected.value = [];
    } else {
        selected.value = [];
        selected.value = page.props.items.data.map(item => item.id);
    }
};

const destroy = (id) => {
    deleteConfirmation(() => {
        const destroyRoute = typeof id === 'object' ?
            route('supplier.destroy-bulk') + '?' + (new URLSearchParams({ids: selected.value}).toString()) :
            route('supplier.destroy', id);
        router.delete(destroyRoute, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                if (typeof id === 'object') {
                    selected.value = [];
                }
            },
        });
    });
};
</script>

<template>
    <AppLayout title="Supplier">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Supplier
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div class="relative bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                        <div
                            class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                            <div class="w-full md:w-1/2">
                                <form class="flex items-center">
                                    <label for="simple-search" class="sr-only">Search</label>
                                    <div class="relative w-full">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                 fill="currentColor" viewbox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <input type="search" @keyup="filter" v-model="filterForm.q" autofocus
                                               class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500"
                                               placeholder="Search" required="">
                                    </div>
                                </form>
                            </div>
                            <div
                                class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                                <Link :href="route('supplier.create')">
                                    <PrimaryButton type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="icon icon-tabler icon-tabler-plus me-1" width="16" height="16"
                                             viewBox="0 0 24 24" stroke-width="2" stroke="#fff" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 5l0 14"/>
                                            <path d="M5 12l14 0"/>
                                        </svg>
                                        Add new supplier
                                    </PrimaryButton>
                                </Link>
                            </div>
                        </div>

                        <div class="px-4 py-3">
                            <h5>
                                <span class="text-gray-500 me-2">Total Suppliers:</span>
                                <span class="dark:text-white">{{ $page.props.items.total }}</span>
                            </h5>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-all"
                                                   :checked="selected.length === $page.props.items.data?.length"
                                                   @change="selectAll" type="checkbox"
                                                   class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-all" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3">Created At</th>
                                    <th scope="col" class="px-4 py-3">Company</th>
                                    <th scope="col" class="px-4 py-3">Contact Person</th>
                                    <th scope="col" class="px-4 py-3">Address</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-if="$page.props.items?.data?.length">
                                    <tr class="border-b dark:border-gray-600" v-for="supplier in $page.props.items.data"
                                        :key="supplier.id">
                                        <td class="w-4 px-4 py-3">
                                            <div class="flex items-center">
                                                <input :id="`checkbox-table-search-${supplier.id}`" v-model="selected"
                                                       :value="supplier.id" type="checkbox"
                                                       onclick="event.stopPropagation()"
                                                       class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label :for="`checkbox-table-search-${supplier.id}`" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 font-regular text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ dateHumanFormat(supplier.created_at) }}
                                        </td>
                                        <th scope="row" class="px-4 py-2 text-gray-900 dark:text-white">
                                            <div class="flex flex-col">
                                                <Link :href="route('supplier.show', supplier.id)"
                                                      class="text-emerald-600 font-semibold hover:underline transition ease-in-out duration-150">
                                                    {{ supplier.name }}
                                                </Link>
                                                <div class="font-light text-gray-500 text-xs" v-if="supplier.email">
                                                    {{ supplier.email }}
                                                </div>
                                            </div>
                                        </th>
                                        <th class="px-4 py-2 text-gray-900 dark:text-white">
                                            <div class="flex flex-col">
                                                <div>{{ supplier.contact_person }}</div>
                                                <div class="font-light text-gray-500 text-xs">
                                                    {{ supplier.phone }}
                                                </div>
                                            </div>
                                        </th>
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ supplier.address ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 flex items-center justify-end">
                                            <button :id="`supplier-id-${supplier.id}`"
                                                    data-dropdown-placement="bottom-end"
                                                    :data-dropdown-toggle="`supplier-id-${supplier.id}-dropdown`"
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
                                            <div :id="`supplier-id-${supplier.id}-dropdown`"
                                                 class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                    :aria-labelledby="`supplier-id-${supplier.id}`">
                                                    <li>
                                                        <Link :href="route('supplier.edit', supplier.id)"
                                                              class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Edit
                                                        </Link>
                                                    </li>
                                                </ul>
                                                <div class="py-1">
                                                    <a href="#" @click="() => destroy(supplier.id)"
                                                       class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                <tr v-else class="border-b dark:border-gray-700">
                                    <th scope="row" colspan="6"
                                        class="px-4 py-3 font-light text-gray-500 whitespace-nowrap dark:text-white text-center">
                                        No supplier available. You can
                                        <Link :href="route('supplier.create')"
                                              class="text-emerald-500 hover:underline transition ease-in-out duration-150">
                                            create new supplier
                                        </Link>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 space-y-3 md:space-y-0 overflow-x-auto">
                            <Pagination :links="$page.props.items.links" :from="$page.props.items.from"
                                        :to="$page.props.items.to" :total="$page.props.items.total"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav v-show="selected.length > 0" class="fixed bottom-0 w-full bg-white shadow-xl z-50 dark:bg-gray-800">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
                <div class="flex">
                    <DangerButton @click="destroy">
                        Delete Selected
                    </DangerButton>
                </div>
                <h5>{{ selected.length }} {{ selected.length > 1 ? 'suppliers' : 'supplier' }} selected.</h5>
            </div>
        </nav>
    </AppLayout>
</template>
