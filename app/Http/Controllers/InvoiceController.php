<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        $current_url = $request->fullUrl();
        $print = $request['print'];
        $client_id = $request['client_id'];
        $type = $request['type'];
        $year = $request['year'] ? $request['year'] : date('Y');
        $month = $request['month'] ? $request['month'] : date('m');
        $invoices = Invoice::orderBy('created_at', 'desc')
            ->with('client')
            ->whereHas('client', function ($query) {
                return $query->where('user_id', '=', Auth::id());
            })->whereHas('client', function ($query) use ($client_id) {
                if($client_id)
                    return $query->where('id', '=', $client_id);
                else return $query;
            })->where(function ($query) use ($type) {
                if($type)
                    return $query->where('type', '=', $type);
                else return $query;
            })->where(function ($query) use ($year) {
                if($year)
                    return $query->whereYear('created_at', '=', $year);
                else return $query;
            })->where(function ($query) use ($month) {
                if($month)
                    return $query->whereMonth('created_at', '=', $month);
                else return $query;
            })->get();
        $clients = Client::orderBy('created_at', 'desc')->where('user_id', Auth::id())->get();
        return view(!$print ? 'invoices/invoices': 'invoices/invoice_print', compact('invoices', 'clients', 'client_id', 'type', 'year', 'month', 'current_url'));
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
