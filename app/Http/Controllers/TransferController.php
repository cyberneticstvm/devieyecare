<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Transfer;
use App\Models\TransferDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransferController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('transfer-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('transfer-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('transfer-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('transfer-delete'), only: ['destroy']),
        ];
    }

    protected $products, $from_branches, $to_branches;
    public function __construct()
    {
        $this->products = Product::orderBy('name')->pluck('name', 'id');
        $this->from_branches = fromBranches();
        $this->to_branches = toBranches();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transfers = Transfer::withTrashed()->get();
        return view('admin.transfer.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = $this->products;
        $from_branches = $this->from_branches;
        $to_branches = $this->to_branches;
        return view('admin.transfer.create', compact('products', 'from_branches', 'to_branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'from_branch' => 'required',
            'to_branch' => 'required',
            'tdate' => 'required|date',
            'notes' => 'nullable',
        ]);
        try {
            DB::transaction(function () use ($request, $inputs) {
                $inputs['created_by'] = $request->user()->id;
                $inputs['updated_by'] = $request->user()->id;
                $transfer = Transfer::create($inputs);
                $data = [];
                foreach ($request->product_id as $key => $item):
                    $data[] = [
                        'transfer_id' => $transfer->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'batch' => $request->batch[$key],
                        'created_at' => $transfer->created_at,
                        'updated_at' => $transfer->updated_at,
                    ];
                endforeach;
                TransferDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('transfer.list')->with("success", "Transfer created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transfer = Transfer::findOrFail(decrypt($id));
        $products = $this->products;
        $from_branches = $this->from_branches;
        $to_branches = $this->to_branches;
        return view('admin.transfer.edit', compact('products', 'from_branches', 'to_branches', 'transfer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'from_branch' => 'required',
            'to_branch' => 'required',
            'tdate' => 'required|date',
            'notes' => 'nullable',
        ]);
        try {
            DB::transaction(function () use ($request, $inputs, $id) {
                $inputs['updated_by'] = $request->user()->id;
                $transfer = Transfer::findOrFail(decrypt($id));
                $transfer->update($inputs);
                $data = [];
                foreach ($request->product_id as $key => $item):
                    $data[] = [
                        'transfer_id' => $transfer->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'batch' => $request->batch[$key],
                        'created_at' => $transfer->created_at,
                        'updated_at' => $transfer->updated_at,
                    ];
                endforeach;
                TransferDetail::where('transfer_id', $transfer->id)->delete();
                TransferDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('transfer.list')->with("success", "Transfer updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Transfer::findOrFail(decrypt($id))->delete();
        return redirect()->route('transfer.list')->with("success", "Transfer deleted successfully!");
    }
}
