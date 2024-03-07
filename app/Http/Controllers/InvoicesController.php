<?php

namespace App\Http\Controllers;

use App\Models\invoice_details;
use App\Models\invoices;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $search = request('search');

        $invoice = invoices::where('invoice_number', 'like', '%' . $search . '%')
            ->orWhereHas('section', function ($q) use ($search) {
                return $q->where('section_name', 'like', '%' . $search . '%');
             })
             ->orwhere('invoice_user','like','%'.$search.'%')
             ->get();
        return view('invoices.index', [
            'invoice' => $invoice
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $sections = section::all();
        return view('invoices.createinvoice', [
            'sections' => $sections
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // ===========================
        $attach = [];
        if ($request->hasfile('invoice_attach')) {
            foreach ($request->invoice_attach as $invoice_attatchment) {
                $filename = time() . rand(1, 10) . '.' . $invoice_attatchment->extension();
                $invoice_attatchment->move(public_path('attach/'), $filename);
                $attach[] = $filename;
            }
        }

        // ====================================
        $invoice = invoices::create([
            'invoice_user' => $request->invoice_user,
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user_id' => Auth::user()->id,
            'attach' => $attach,

        ]);
        // $invoice_id = invoices::latest()->first()->id;

        $invoice->details()->create([
            'invoice_id' => $invoice->id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => Auth::user()->name
        ]);
        return redirect(route('invoices.index'))->with('success', "$request->invoice_number تم اضافة فاتورة جديدة");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $invoice = invoices::findorfail($id);
        return view(
            'invoices.show',
            [
                'invoice' => $invoice,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $sections = section::all();
        $invoice = invoices::findorfail($id);
        return view('invoices.edit', [
            'invoice' => $invoice, 'sections' => $sections
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
        $invoice = invoices::findorfail($id);

        // ===========================
        $attach = [];
        if ($request->hasfile('invoice_attach')) {
            foreach ($request->invoice_attach as $invoice_attatchment) {
                $filename = time() . rand(1, 10) . '.' . $invoice_attatchment->extension();
                $invoice_attatchment->move(public_path('attach/'), $filename);
                $attach[] = $filename;
            }
        }

        // ------------------------------- files --------------------------------------------------
        $fileprev = $invoice->attach;
        if (
            $fileprev && $fileprev !== $request->invoice_attach && $request->invoice_attach !== null
        ) {
            foreach ($fileprev as $fileprev) {
                File::delete(public_path('attach/' . $fileprev));
            }
        }
        // --------------------------------------------------------

        $invoice->update([
            'invoice_user' => $request->invoice_user,
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => $request->Status,
            'note' => $request->note,
            'user_id' => Auth::user()->id,
            'attach' => $attach,

        ]);
        $invoicedetails = invoice_details::where('invoice_id', $id)->first();
        $invoicedetails->update([
            'invoice_id' => $invoice->id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => $request->Status,
            'note' => $request->note,
            'user' => Auth::user()->name
        ]);
        // -----------------------------
        if ($request->Status === "مدفوعة") {
            $invoice->update([
                'Value_Status' => 1,

            ]);
            $invoicedetails->update([
                'Value_Status' => 1,

            ]);
        }
        // ==================1========
        if ($request->Status === "غير مدفوعة") {
            $invoice->update([
                'Value_Status' => 2,

            ]);
            $invoicedetails->update([
                'Value_Status' => 2,

            ]);
        }
        // =====================2=========
        if ($request->Status === "مدفوعة جزئيا") {
            $invoice->update([
                'Value_Status' => 3,

            ]);
            $invoicedetails->update([
                'Value_Status' => 3,

            ]);
        }
        // =================3-------------------
        return redirect(route('invoices.index'))->with('success', " تم تعديل الفاتورة رقم $request->invoice_number");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $invoice = invoices::findorfail($id);
        $invoice->destroy($id);
        return redirect(route('invoices.index'))->with('success', "تم حذف الفاتورة رقم $invoice->invoice_number بنجاح");
    }
}
