<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import {ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {deleteConfirmation, digitFormatter, rupiahCurrency, validateNumber} from "@/util.js";
import DangerButton from "@/Components/DangerButton.vue";
import DialogModal from "@/Components/DialogModal.vue";

const form = useForm({
    customer_id: null,
    start_date: new Date().toISOString().split('T')[0],
    target_date: null,
    item_lines: [],
});

const newCustomerModal = ref(false);

const addItemLine = () => form.item_lines.push({
    service: null,
    service_id: null, // from service
    unit: null, // from service
    price: 0, // from service
    quantity: 1,
    discount: '0',
    additional_fee: '0',
    subtotal: '0',
});

const removeItemLine = (index) => deleteConfirmation(() => form.item_lines.splice(index, 1));

const customerOptions = ref([]);
const searchCustomer = (search, loading) => {
    if(search.length) {
        loading(true);
        fetch(route('customer.search') + '?q=' + search).then(res => res.json()).then(res => {
            customerOptions.value = res;
            loading(false);
        });
    }
};

const calculateSubtotal = (id) => {
    let price = form.item_lines[id].service?.sale_price ?? 0;
    if (price === 0)
        price = form.item_lines[id].service?.original_price ?? 0;

    const discount = Number(form.item_lines[id].discount?.replace(/[^0-9]/g, ''));
    const additional_fee = Number(form.item_lines[id].additional_fee?.replace(/[^0-9]/g, ''));
    const qty = form.item_lines[id].quantity;

    form.item_lines[id].subtotal = digitFormatter((price * qty) - discount + additional_fee);
};

const submit = () => {
    form.transform(data => ({
        ...data,
        customer_id: data.customer_id?.id
    })).post(route('transaction.store'), {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <AppLayout title="Transaction">
        <template #header>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 rtl:space-x-reverse">
                    <li>
                        <Link :href="route('transaction.index')">
                            <h2 class="font-semibold text-xl text-gray-400 hover:text-gray-600 leading-tight">
                                Transaction
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
                            Add New Transaction
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
                            <div class="grid gap-4 mb-4 md:grid-cols-3">
                                <div>
                                    <InputLabel for="customer_id" value="Customer" :required="true"/>
                                    <v-select
                                        id="customer_id"
                                        v-model="form.customer_id"
                                        class="mt-1 block w-full custom-v-select"
                                        @search="searchCustomer"
                                        placeholder="Type to search customer"
                                        label="name"
                                        :options="customerOptions">
                                        <template #no-options="{ search }">
                                            <div class="text-xs text-gray-500 py-2" v-if="search.length">
                                                Can't find the customer? Let's <span @click="() => newCustomerModal = true" class="cursor-pointer text-emerald-600 font-semibold hover:underline transition ease-in-out duration-150">add new customer</span>.
                                            </div>
                                            <div class="text-xs text-gray-500 py-2" v-else>
                                                Search the customer by name or phone.
                                            </div>
                                        </template>
                                        <template #option="{ name, phone, address }">
                                            <div class="text-emerald-600">
                                                {{ name }}
                                            </div>
                                            <div class="font-light text-gray-500 text-xs" v-if="phone">
                                                {{ phone }}
                                            </div>
                                            <div class="font-medium text-gray-600 text-xs" v-if="address">
                                                {{ address }}
                                            </div>
                                        </template>
                                    </v-select>
                                    <InputError :message="form.errors.customer_id" class="mt-2"/>
                                </div>
                                <div></div>
                                <div>
                                    <InputLabel for="start_date" value="Date" :required="true" />
                                    <TextInput
                                        id="start_date"
                                        v-model="form.start_date"
                                        type="date"
                                        :min="new Date().toISOString().split('T')[0]"
                                        class="mt-1 block w-full"
                                        autocomplete="off"
                                    />
                                    <InputError :message="form.errors.start_date" class="mt-2" />
                                </div>
                                <div>
                                    <div class="text-emerald-600">
                                        {{ form.customer_id?.name }}
                                    </div>
                                    <div class="font-light text-gray-500 text-xs" v-if="form.customer_id?.phone">
                                        {{ form.customer_id?.phone }}
                                    </div>
                                    <div class="font-medium text-gray-600 text-xs" v-if="form.customer_id?.address">
                                        {{ form.customer_id?.address }}
                                    </div>
                                </div>
                                <div></div>
                                <div>
                                    <InputLabel for="target_date" value="Estimated Completion Date" :required="true" />
                                    <TextInput
                                        id="target_date"
                                        v-model="form.target_date"
                                        type="date"
                                        :min="form.start_date"
                                        class="mt-1 block w-full"
                                        autocomplete="off"
                                    />
                                    <InputError :message="form.errors.target_date" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="ps-4 pe-2 py-3 w-4">No.</th>
                                    <th scope="col" class="px-2 py-3 w-80">Service</th>
                                    <th scope="col" class="px-2 py-3">Qty</th>
                                    <th scope="col" class="px-4 py-3 36">Price</th>
                                    <th scope="col" class="px-2 py-3 w-44">Discount</th>
                                    <th scope="col" class="px-2 py-3 w-44">Additional Fee</th>
                                    <th scope="col" class="px-2 py-3 w-44">Subtotal</th>
                                    <th scope="col" class="px-2 py-3 text-end">
                                        <SecondaryButton type="button" @click="addItemLine">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-plus" width="16" height="16"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="#000" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 5l0 14"/>
                                                <path d="M5 12l14 0"/>
                                            </svg>
                                        </SecondaryButton>
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-if="form.item_lines.length">
                                    <tr class="border-b dark:border-gray-600" v-for="(itemLine, id) in form.item_lines" :key="id">
                                        <td class="ps-4 py-2 w-4 font-regular text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ id+1 }}
                                        </td>
                                        <th scope="row" class="px-2 py-2 w-80 text-gray-900 dark:text-white">
                                            <v-select
                                                v-model="form.item_lines[id].service"
                                                class="mt-1 block w-full custom-v-select"
                                                label="name"
                                                v-on:option:selected="() => calculateSubtotal(id)"
                                                :options="$page.props.services">
                                                <template #option="{ name }">
                                                    <div class="text-emerald-600 text-sm">
                                                        {{ name }}
                                                    </div>
                                                </template>
                                                <template #selected-option="{ name }">
                                                    <div class="text-emerald-600 text-sm">
                                                        {{ name }}
                                                    </div>
                                                </template>
                                            </v-select>
                                        </th>
                                        <td class="py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="relative mt-1">
                                                <input
                                                    type="number"
                                                    v-model="form.item_lines[id].quantity"
                                                    @input="() => calculateSubtotal(id)"
                                                    min="1"
                                                    class="block w-full pe-8 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 dark:focus:border-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-600 rounded-md shadow-sm">
                                                <div class="absolute text-gray-400 inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                                                    {{ form.item_lines[id].service?.unit ?? 'kg' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 w-36 text-gray-900 whitespace-nowrap dark:text-white">
                                            <template v-if="form.item_lines[id].service === null">
                                                Rp 0/kg
                                            </template>
                                            <template v-else-if="form.item_lines[id].service.original_price === form.item_lines[id].service.sale_price || form.item_lines[id].service.sale_price === 0">
                                                {{ rupiahCurrency(form.item_lines[id].service.original_price) + '/' + form.item_lines[id].service.unit }}
                                            </template>
                                            <div v-else>
                                                <small class="text-gray-500 line-through">{{ rupiahCurrency(form.item_lines[id].service.original_price) + '/' + form.item_lines[id].service.unit }}</small>
                                                <div>{{ rupiahCurrency(form.item_lines[id].service.sale_price) + '/' + form.item_lines[id].service.unit }}</div>
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 w-44 text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="relative mt-1">
                                                <div class="absolute text-gray-400 inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                    Rp
                                                </div>
                                                <input
                                                    type="text"
                                                    @input="() => { validateNumber(form.item_lines[id],'discount'); calculateSubtotal(id) }"
                                                    v-model="form.item_lines[id].discount"
                                                    class="block w-full ps-10 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 dark:focus:border-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-600 rounded-md shadow-sm">
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 w-44 text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="relative mt-1">
                                                <div class="absolute text-gray-400 inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                    Rp
                                                </div>
                                                <input
                                                    type="text"
                                                    @input="() => { validateNumber( form.item_lines[id],'additional_fee'); calculateSubtotal(id) }"
                                                    v-model="form.item_lines[id].additional_fee"
                                                    class="block w-full ps-10 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 dark:focus:border-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-600 rounded-md shadow-sm">
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 w-44 text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="relative mt-1">
                                                <div class="absolute text-gray-400 inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                    Rp
                                                </div>
                                                <input
                                                    type="text"
                                                    disabled
                                                    v-model="form.item_lines[id].subtotal"
                                                    class="block w-full ps-10 disabled:bg-gray-100 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 dark:focus:border-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-600 rounded-md shadow-sm">
                                            </div>
                                        </td>
                                        <td class="py-2 ps-4 pe-4 text-end text-gray-900 whitespace-nowrap dark:text-white">
                                            <DangerButton type="button" @click="() => removeItemLine(id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                            </DangerButton>
                                        </td>
                                    </tr>
                                </template>
                                <tr v-else class="border-b dark:border-gray-700">
                                    <th scope="row" colspan="7"
                                        class="px-4 py-3 font-light text-gray-500 whitespace-nowrap dark:text-white text-center">
                                        No transaction available. You can
                                        <Link :href="route('transaction.create')"
                                              class="text-emerald-500 hover:underline transition ease-in-out duration-150">
                                            create new transaction
                                        </Link>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
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


        <!-- New Customer Modal -->
        <DialogModal :show="newCustomerModal" @close="() => newCustomerModal = false">
            <template #title>
                New Customer
            </template>

            <template #content>

            </template>

            <template #footer>
                <SecondaryButton @click="() => newCustomerModal = false">
                    Cancel
                </SecondaryButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>
