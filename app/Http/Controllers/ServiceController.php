<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Service/Index', [
            'items' => Service::query()
                ->search($request->query('q'))
                ->render($request->query('size')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Service/Create', [
            'units' => Service::availableUnits(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        try {
            $input = $request->validated();
            Service::create($input);

            return redirect()->route('service.index')->banner('Successfully created a new service');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to create a new service');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): Response
    {
        return Inertia::render('Service/Show', [
            'service' => $service,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): Response
    {
        return Inertia::render('Service/Edit', [
            'service' => $service,
            'units' => Service::availableUnits(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        try {
            $input = $request->validated();
            $service->update($input);

            return back()->banner('Successfully updated the service');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to update the service');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        try {
            $service->delete();

            return back()->banner('Successfully deleted the service');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to delete the service');
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
                return back()->dangerBanner('No service selected!');
            }

            Service::query()->whereIn('id', $ids)->delete();

            return back()->banner('Successfully deleted the selected services');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to delete the selected services');
        }
    }
}
