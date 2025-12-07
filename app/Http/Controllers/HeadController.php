<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Head;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HeadController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('head-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('head-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('head-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('head-delete'), only: ['destroy']),
        ];
    }

    protected $category;
    public function __construct()
    {
        $this->category = Extra::where('category', 'head')->pluck('name', 'id');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->category;
        $heads = Head::withTrashed()->orderBy('name')->get();
        return view('admin.head.index', compact('heads', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => 'required|unique:heads,name',
            'category_id' => 'required',
            'description' => 'nullable',
        ]);
        try {
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            Head::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('head.list')->with("success", "Head created successfully!");
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
        $categories = $this->category;
        $head = Head::findOrFail(decrypt($id));
        return view('admin.head.edit', compact('head', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'name' => 'required|unique:heads,name,' . decrypt($id),
            'category_id' => 'required',
            'description' => 'nullable',
        ]);
        try {
            $inputs['updated_by'] = $request->user()->id;
            Head::findOrFail(decrypt($id))->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('head.list')->with("success", "Head updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Head::findOrFail(decrypt($id))->delete();
        return redirect()->route('head.list')->with("success", "Head deleted successfully!");
    }
}
