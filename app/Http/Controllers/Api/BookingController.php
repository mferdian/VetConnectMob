<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Booking;
use App\Models\Vet;

class BookingController extends Controller
{
    // [POST] Buat booking
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vet_id' => 'required|exists:vets,id',
            'vet_date_id' => 'required|exists:vet_dates,id',
            'vet_time_id' => 'required|exists:vet_times,id',
            'keluhan' => 'nullable|string',
            'total_harga' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:transfer_bank,e-wallet,cash,lainnya',
        ]);

        $booking = Booking::create([
            'order_id' => 'ORD-' . Str::uuid(),
            'user_id' => $request->user()->id,
            'vet_id' => $validated['vet_id'],
            'vet_date_id' => $validated['vet_date_id'],
            'vet_time_id' => $validated['vet_time_id'],
            'keluhan' => $validated['keluhan'] ?? null,
            'total_harga' => $validated['total_harga'],
            'status' => 'confirmed',
            'status_bayar' => 'berhasil', 
            'metode_pembayaran' => $validated['metode_pembayaran'],
        ]);

        return response()->json([
            'message' => 'Booking berhasil dibuat',
            'data' => $booking
        ], 201);
    }

    // [GET] Daftar booking user
    public function index(Request $request)
    {
        $bookings = Booking::with(['vet', 'vetDate', 'vetTime'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($bookings);
    }

    // [GET] Detail booking
    public function show($id)
    {
        $booking = Booking::with(['vet', 'vetDate', 'vetTime'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json($booking);
    }

    // [PATCH] Batalkan booking
    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        if ($booking->status !== 'confirmed') {
            return response()->json(['message' => 'Booking tidak bisa dibatalkan'], 400);
        }

        $booking->update([
            'status' => 'cancelled',
            'status_bayar' => 'dibatalkan'
        ]);

        return response()->json(['message' => 'Booking berhasil dibatalkan']);
    }

    // [GET] Semua dokter
    public function showVet()
    {
        $vets = Vet::all();
        return response()->json([
            'success' => true,
            'data' => $vets
        ]);
    }
}
