<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokterId = Auth::id();
        $schedules = DoctorSchedule::where('doctor_id', $dokterId)->latest()->paginate(10); // Ambil jadwal dokter yang login
        return view('dokter.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokter.schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $dokterId = Auth::id();
        $request->merge(['doctor_id' => $dokterId]);

        DoctorSchedule::create($request->all());

        return redirect()->route('dokter.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DoctorSchedule $schedule)
    {
        // Pastikan dokter yang login memiliki akses ke jadwal ini
        if ($schedule->doctor_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit jadwal ini.');
        }
        return view('dokter.schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DoctorSchedule $schedule)
    {
        $request->validate([
            'date' => 'nullable|date', // Boleh kosong saat update
            'type' => 'nullable|string|max:255', // Boleh kosong saat update
            'description' => 'nullable|string',
        ]);

        // Pastikan dokter yang login memiliki akses ke jadwal ini
        if ($schedule->doctor_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate jadwal ini.');
        }

        $schedule->update($request->all());

        return redirect()->route('dokter.schedules.index')->with('success', 'Jadwal berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DoctorSchedule $schedule)
    {
        // Pastikan dokter yang login memiliki akses ke jadwal ini
        if ($schedule->doctor_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus jadwal ini.');
        }

        $schedule->delete();

        return redirect()->route('dokter.schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
