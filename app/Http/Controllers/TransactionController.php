<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Transaction/Index', [
            'items' => Transaction::with(['itemLines'])
                ->search($request->query('q'))
                ->render($request->query('size')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Transaction/Create', [
            'services' => Service::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        try {
            $input = $request->validated();

            return redirect()->route('transaction.index')->banner('Successfully created a new transaction');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to create a new transaction');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction): Response
    {
        return Inertia::render('Transaction/Show', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        try {
            $transaction->delete();

            return back()->banner('Successfully deleted the transaction');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to delete the transaction');
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
                return back()->dangerBanner('No transaction selected!');
            }

            Transaction::query()->whereIn('id', $ids)->delete();

            return back()->banner('Successfully deleted the selected transactions');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return back()->dangerBanner('Failed to delete the selected transactions');
        }
    }
}
