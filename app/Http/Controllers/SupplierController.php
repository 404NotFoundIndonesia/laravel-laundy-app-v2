<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Supplier/Index', [
            'items' => Supplier::query()
                ->search($request->query('q'))
                ->render($request->query('size')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Supplier/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        try {
            $input = $request->validated();
            Supplier::create($input);

            return redirect()->route('supplier.index')->banner('Successfully created a new supplier');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to create a new customer');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier): Response
    {
        return Inertia::render('Supplier/Show', [
            'supplier' => $supplier,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier): Response
    {
        return Inertia::render('Supplier/Edit', [
            'supplier' => $supplier,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        try {
            $input = $request->validated();
            $supplier->update($input);

            return back()->banner('Successfully updated the supplier');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to update the supplier');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier): RedirectResponse
    {
        try {
            $supplier->delete();

            return back()->banner('Successfully deleted the supplier');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to delete the supplier');
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
                return back()->dangerBanner('No supplier selected!');
            }

            Supplier::query()->whereIn('id', $ids)->delete();

            return back()->banner('Successfully deleted the selected suppliers');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to delete the selected suppliers');
        }
    }
}
