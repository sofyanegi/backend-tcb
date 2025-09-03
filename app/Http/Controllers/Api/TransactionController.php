<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\Sparepart;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('details.sparepart', 'user')->get();
        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_transaksi' => 'required|unique:transactions',
            'name_pemohon' => 'required|string|max:100',
            'id_user' => 'required|exists:users,id',
            'details' => 'required|array|min:1',
            'details.*.id_sparepart' => 'required|exists:spareparts,id',
            'details.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'no_transaksi' => $request->no_transaksi,
                'name_pemohon' => $request->name_pemohon,
                'id_user' => $request->id_user,
            ]);

            foreach ($request->details as $item) {
                $sparepart = Sparepart::find($item['id_sparepart']);

                if ($sparepart->stok < $item['jumlah']) {
                    return response()->json([
                        'message' => "Stok sparepart {$sparepart->nama_sparepart} tidak cukup"
                    ], 400);
                }

                $sparepart->decrement('stok', $item['jumlah']);

                DetailTransaction::create([
                    'id_transaksi' => $transaction->id,
                    'id_sparepart' => $item['id_sparepart'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            DB::commit();
            return response()->json($transaction->load('details.sparepart', 'user'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $transaction = Transaction::with('details.sparepart', 'user')->findOrFail($id);
        return response()->json($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        DB::beginTransaction();
        try {
            foreach ($transaction->details as $detail) {
                $sparepart = $detail->sparepart;
                $sparepart->increment('stok', $detail->jumlah);
            }

            $transaction->delete();
            DB::commit();

            return response()->json(['message' => 'Transaction deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
