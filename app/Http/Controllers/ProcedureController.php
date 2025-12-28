<?php

namespace App\Http\Controllers;

use App\Models\Hsn;
use App\Models\Procedure;
use App\Models\ProcedureDocument;
use App\Models\ProcedureMedicine;
use App\Models\Product;
use App\Models\Registration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProcedureController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('procedure'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('procedure-create'), only: ['create', 'store']),
        ];
    }

    protected $products;
    public function __construct()
    {
        $this->products = Product::whereIn('hsn_id', Hsn::whereIn('name', ['Ointment', 'Eye Drop', 'Tablet'])->pluck('id'))->pluck('name', 'id');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registration = Registration::find(0);
        return view('admin.procedure.index', compact('registration'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $registration = Registration::findOrFail(decrypt($id));
        $products = $this->products;
        return view('admin.procedure.create', compact('registration', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        try {
            $inputs = $request->except(array('product_ids', 'dosage1', 'dosage2', 'dosage3', 'days', 'file_attachment', 'procedure_id'));
            DB::transaction(function () use ($request, $inputs, $id) {
                $registration = Registration::findOrFail(decrypt($id));
                $inputs['registration_id'] = $registration->id;
                $inputs['created_by'] = $request->user()->id;
                $inputs['updated_by'] = $request->user()->id;
                $record = Procedure::updateOrCreate(
                    ['id' => $request->procedure_id],
                    $inputs
                );
                $data = [];
                foreach ($request->product_ids as $key => $item):
                    if ($item > 0):
                        $data[] = [
                            'procedure_id' => $record->id,
                            'product_id' => $item,
                            'dosage1' => $request->dosage1[$key],
                            'dosage2' => $request->dosage2[$key],
                            'dosage3' => $request->dosage3[$key],
                            'days' => $request->days[$key],
                            'created_at' => $record->created_at,
                            'updated_at' => $record->updated_at,
                        ];
                    endif;
                endforeach;
                if ($request->file('file_attachment')):
                    $files = [];
                    foreach ($request->file('file_attachment') as $key => $attachment):
                        $fname = time() . '_' . $attachment->getClientOriginalName();
                        $storeFile = $attachment->storeAs('/procedure', $fname, 'gcs');
                        $url = Storage::disk('gcs')->url($storeFile);
                        $files[] = [
                            'procedure_id' => $record->id,
                            'doc_url' => $url,
                            'created_at' => $record->created_at,
                            'updated_at' => $record->updated_at,
                        ];
                    endforeach;
                    ProcedureDocument::insert($files);
                endif;
                ProcedureMedicine::where('procedure_id', $record->id)->delete();
                ProcedureMedicine::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('procedure')->with("success", "Record updated successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $inputs = $request->validate([
            'mrn' => 'required|numeric',
        ]);
        $registration = Registration::where('mrn', $request->mrn)->firstOrFail();
        return view('admin.procedure.index', compact('registration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
