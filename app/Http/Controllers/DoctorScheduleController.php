<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the doctor's schedules.
     */
    public function index()
    {
        $schedules = DoctorSchedule::where('doctor_id', Auth::user()->doctor->id)->latest()->paginate(10);
        return view('dokter.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        return view('dokter.schedules.create');
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DoctorSchedule::create([
            'doctor_id' => Auth::user()->doctor->id,
            'date' => $request->date,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('dokter.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit(DoctorSchedule $schedule)
    {
        // Pastikan dokter hanya bisa mengedit jadwalnya sendiri
        if ($schedule->doctor_id !== Auth::user()->doctor->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit jadwal ini.');
        }
        return view('dokter.schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(Request $request, DoctorSchedule $schedule)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Pastikan dokter hanya bisa mengupdate jadwalnya sendiri
        if ($schedule->doctor_id !== Auth::user()->doctor->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate jadwal ini.');
        }

        $schedule->update($request->all());

        return redirect()->route('dokter.schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy(DoctorSchedule $schedule)
    {
        // Pastikan dokter hanya bisa menghapus jadwalnya sendiri
        if ($schedule->doctor_id !== Auth::user()->doctor->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus jadwal ini.');
        }

        $schedule->delete();

        return redirect()->route('dokter.schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
