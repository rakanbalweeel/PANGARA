<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $query = Transaction::with('user');
        // Sorting
        $sort = request('sort', 'desc');
        $query = $query->orderBy('created_at', $sort === 'asc' ? 'asc' : 'desc');
        // Limit
        $limit = intval(request('limit', 0));
        if ($limit > 0) {
            $query = $query->limit($limit);
        }
        $transactions = $query->get();
        return response()->json(['data' => $transactions]);
    }

    public function show($id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);
        return response()->json($transaction);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'payment_method' => 'required|string',
            'status' => 'required|string',
        ]);
        $transaction = Transaction::create($validated);
        return response()->json(['success' => true, 'data' => $transaction], 201);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $validated = $request->validate([
            'total' => 'sometimes|numeric',
            'payment_method' => 'sometimes|string',
            'status' => 'sometimes|string',
        ]);
        $transaction->update($validated);
        return response()->json(['success' => true, 'data' => $transaction]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response()->json(['success' => true]);
    }

    // API endpoint untuk purchase history (pembeli)
    public function getPurchaseHistory()
    {
        $userId = auth()->id();
        $limit = intval(request('limit', 5));
        
        $purchases = Transaction::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($transaction) {
                // Parse items JSON to extract product info
                $items = json_decode($transaction->items, true);
                $firstItem = $items[0] ?? null;
                
                return [
                    'id' => $transaction->id,
                    'product_id' => $firstItem['product_id'] ?? null,
                    'product_name' => $firstItem['name'] ?? 'Unknown Product',
                    'product_image' => $firstItem['image'] ?? 'https://via.placeholder.com/100',
                    'amount' => $transaction->total_amount,
                    'created_at' => $transaction->created_at,
                    'payment_status' => $transaction->payment_status,
                    'total_items' => count($items),
                ];
            });
        
        return response()->json(['data' => $purchases]);
    }
}
