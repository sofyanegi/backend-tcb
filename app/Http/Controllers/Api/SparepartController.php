<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SparepartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spareparts = Sparepart::latest()->paginate(10);

        return ApiResponse::success(
            $spareparts
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_sparepart' => 'required|string',
            'minimal_stok' => 'required|integer',
            'stok' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors());
        }

        $sparepart = Sparepart::create([
            'nama_sparepart' => $request->input('nama_sparepart'),
            'minimal_stok' => $request->input('minimal_stok'),
            'stok' => $request->input('stok'),
        ]);

        return ApiResponse::success(
            $sparepart,
            'Sparepart created successfully'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Sparepart::find($id);

        if (!$product) {
            return ApiResponse::notFound('Sparepart not found', 404);
        }

        return ApiResponse::success(
            $product,
            'Sparepart fetched successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sparepart = Sparepart::find($id);

        if (!$sparepart) {
            return ApiResponse::notFound('Sparepart not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_sparepart' => 'required|string',
            'minimal_stok' => 'required|integer',
            'stok' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors());
        }

        $sparepart->update([
            'nama_sparepart' => $request->input('nama_sparepart'),
            'minimal_stok' => $request->input('minimal_stok'),
            'stok' => $request->input('stok')
        ]);

        return ApiResponse::success(
            $sparepart,
            'Sparepart updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sparepart = Sparepart::find($id);

        if (!$sparepart) {
            return ApiResponse::notFound('Sparepart not found', 404);
        }

        $sparepart->delete();

        return ApiResponse::success(
            null,
            'Sparepart deleted successfully'
        );
    }
}
