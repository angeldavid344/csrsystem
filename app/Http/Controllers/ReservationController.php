<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('sala', 'user')->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $salas = Sala::all();
        return view('reservations.create', compact('salas'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'sala_id' => 'required|exists:salas,id',
        ]);

        $totalHours = Reservation::where('user_id', Auth::id())->whereMonth('date', now()->month)->sum('duration');
        $sala = Sala::find($request->sala_id);

        if ($totalHours + $sala->max_hours_per_day > 20) {
            throw ValidationException::withMessages(['message' => 'You have exceeded your reservation time limit for this month']);
        }

        $reservation = new Reservation();
        $reservation->date = $request->date;
        $reservation->start_time = $request->start_time;
        $reservation->end_time = $request->end_time;
        $reservation->sala_id = $request->sala_id;
        $reservation->user_id = Auth::id();
        $reservation->duration = $sala->max_hours_per_day;
        $reservation->save();

        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}