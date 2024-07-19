<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Customer/Index', [
            'items' => Customer::query()
                ->search($request->query('q'))
                ->render($request->query('size')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Customer/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        try {
            $input = $request->validated();
            Customer::create($input);

            return redirect()->route('customer.index')->banner('Successfully created a new customer');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to create a new customer');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): Response
    {
        return Inertia::render('Customer/Show', [
            'customer' => $customer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): Response
    {
        return Inertia::render('Customer/Edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        try {
            $input = $request->validated();
            $customer->update($input);

            return back()->banner('Successfully updated the customer');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to update the customer');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        try {
            $customer->delete();

            return back()->banner('Successfully deleted the customer');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to delete the customer');
        }
    }

    /**
     * Remove bulk resource from storage.
     */
    public function destroyBulk(Request $request): RedirectResponse
    {
        try {
            $ids = explode(',', $request->input('ids'));
            if (count($ids) === 0) {
                return back()->dangerBanner('No customer selected!');
            }

            Customer::query()->whereIn('id', $ids)->delete();

            return back()->banner('Successfully deleted the selected customers');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to delete the selected customers');
        }
    }
}
