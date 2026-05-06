<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Inventory::orderBy('barang', 'asc')->with('user')->get();

        if(empty($data)) return response()->json(['message' => 'Data tidak ada'], 404);

        return response()->json(['message' => 'Semua data', 'data' => $data], 200);
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
        $request->validate([
            'inventaris_id' => 'nullable|string|unique:inventory,inventaris_id',
            'barang' => 'required|string|min:3',
            'type' => 'nullable|string',
            'serial_number'=> 'required|integer|unique:inventory,serial_number',
            'spesifikasi'=> 'nullable|string',
            'status'=> 'required|in:Baik,Rusak,Tidak Dipakai,Dilelang',
            'user_id'=> 'required|exists:users,id',
            'department'=> 'required|in:Technology,Finance,Marketing',
        ]);

        $data = Inventory::create([
            'inventaris_id' => $request->inventaris_id,
            'barang' => $request->barang,
            'type' => $request->type,
            'serial_number' => $request->serial_number,
            'spesifikasi' => $request->spesifikasi,
            'status' => $request->status,
            'user_id' => $request->user_id,
            'department' => $request->department,
        ]);

        return response()->json(['message'=> 'Data ditambahkan','data'=> $data], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Inventory::find($id);

        if(!$data) return response()->json(['message'=> 'Data tidak di temukan'], 404);

        $request->validate([
            'inventaris_id' => 'nullable|string',
            'barang' => 'nullable|string|min:3',
            'type' => 'nullable|string',
            'serial_number'=> 'nullable|integer',
            'spesifikasi'=> 'nullable|string',
            'status'=> 'nullable|in:Baik,Rusak,Tidak Dipakai,Dilelang',
            'user_id'=> 'nullable|exists:users,id',
            'department'=> 'nullable|in:Technology,Finance,Marketing',
        ]);

        $data->update([
            'inventaris_id' => $request->inventaris_id ?? $data->inventaris_id,
            'barang' => $request->barang ?? $data->barang,
            'type' => $request->type ?? $data->type,
            'serial_number' => $request->serial_number ?? $data->serial_number,
            'spesifikasi' => $request->spesifikasi ?? $data->spesifikasi,
            'status' => $request->status ?? $data->status,
            'user_id' => $request->user_id ?? $data->user_id,
            'department' => $request->department ?? $data->department,
        ]);

        return response()->json(['message'=> 'Data di update', 'data' => $data], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Inventory::find($id);

        if(!$data) return response()->json(['message'=> 'Data tidak di temukan'], 404);

        $data->delete();

        return response()->json(['message'=> 'Data dihapus'], 200);
    }
}
