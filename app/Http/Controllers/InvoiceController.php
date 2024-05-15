<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the invoices.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')->with('client')->whereHas('client', function ($query) {
            return $query->where('user_id', '=', Auth::id());
        })->get();
        return view('invoices/invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $clients = Client::orderBy('created_at', 'desc')->where('user_id', Auth::id())->get();
        return view('invoices.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInvoiceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreInvoiceRequest $request)
    {
        Invoice::create($request->getData());
        return redirect()->route('invoices.index')->with('success', 'تمت الاضافة بنجاح');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Invoice $invoice)
    {

        $clients = Client::orderBy('created_at', 'desc')->get();
        return view('invoices.edit', compact('invoice', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->getData());
        return redirect()->route('invoices.index')->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'تم الحذف بنجاح');
    }
}
