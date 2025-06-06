<?php

namespace App\Http\Controllers\Apps;

use App\Http\Contracts\Apps\SupplierRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Apps\Supplier\StoreRequest;
use App\Http\Requests\Apps\Supplier\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupplierController extends Controller
{
    protected $supplierRepo;

    /**
     * Create a new controller instance.
     *
     * @param SupplierRepositoryInterface $registerRepository
     * @return void
     */
    public function __construct(SupplierRepositoryInterface $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.content.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.content.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $validated = $request->validated();

        try {
            $supplier = $this->supplierRepo->store($validated);
            return response()->json([
                'message' => 'Supplier successfully created!',
                'user' => $supplier,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Supplier create failed!',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = $this->supplierRepo->find($id);

        return view('pages.content.supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $supplier = $this->supplierRepo->find($id);
            return view('pages.content.supplier.edit', compact('supplier'));
        } catch (\Exception $e) {
            return redirect()->route('supplier.index')->withErrors('Failed to find supplier!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $supplier = $this->supplierRepo->update($id, $validated);
            return response()->json([
                'message' => 'Supplier successfully updated!',
                'supplier' => $supplier,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Supplier update failed!',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->supplierRepo->delete($id);
            return response()->json([
                'message' => 'Supplier successfully deleted!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Supplier delete failed!',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function datatable(Request $request) {
        return $this->supplierRepo->datatable($request);
    }

    public function select(Request $request)
    {
        try {
            $search = $request->get('search', '');
            $suppliers = $this->supplierRepo->getLimitedWithSearch($search);

            $results = collect($suppliers)->map(function ($supplier) {
                return [
                    'id' => $supplier->id,
                    'text' => $supplier->name,
                ];
            });
            return response()->json([
                'results' => $results
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
