<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentNotificationMail;
use App\Mail\AppointmentStatusUpdatedMail;
use App\Models\Appointments;
use App\Models\PetMedicalHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AppointController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'vet_id' => 'required|exists:users,id',
        'date'   => 'required|date',
        'time'   => 'required',
        'message'=> 'nullable|string',
        'pet_id' => 'nullable|integer',
        'shelter_pet_id' => 'nullable|integer',
    ]);

    $user = Auth::user();
    $vet = User::with('vetProfile')->findOrFail($request->vet_id);
    $profile = $vet->vetProfile;

    // ✅ Check vet availability
    $dayName = strtolower(date('l', strtotime($request->date)));
    $availableDays = $profile && $profile->available_days
        ? array_map('strtolower', explode(',', str_replace(' ', '', $profile->available_days)))
        : [];

    if (!in_array($dayName, $availableDays)) {
        return back()->with('error', "Dr. {$vet->name} is not available on " . ucfirst($dayName) . ".");
    }

    if ($profile && $profile->available_time) {
        $availableTime = strtolower(str_replace(['-', '–'], 'to', $profile->available_time));
        $timeParts = array_map('trim', explode('to', $availableTime));

        if (count($timeParts) < 2) {
            return back()->with('error', "Invalid time format in vet profile. Please use format like '10:00 AM to 6:00 PM'.");
        }

        [$start, $end] = $timeParts;
        $appointmentTime = date("H:i", strtotime($request->time));

        if ($appointmentTime < date("H:i", strtotime($start)) || $appointmentTime > date("H:i", strtotime($end))) {
            return back()->with('error', "Dr. {$vet->name} is available only between {$profile->available_time}.");
        }
    }

    // ✅ Prepare data
    $appointmentData = [
        'owner_id' => $user->id,
        'vet_id'   => $vet->id,
        'date'     => $request->date,
        'time'     => $request->time,
        'message'  => $request->message,
        'status'   => 'Pending',
    ];

    // ✅ Decide column based on role
    if ($user->role === 'shelter') {
        $appointmentData['shelter_pet_id'] = $request->shelter_pet_id;
        $pet = \App\Models\ShelterPet::find($request->shelter_pet_id);
    } else {
        $appointmentData['pet_id'] = $request->pet_id;
        $pet = \App\Models\Pets::find($request->pet_id);
    }

    // ✅ Save appointment
    $appointment = Appointments::create($appointmentData);

    // ✅ Attach health info (not stored in DB)
    $appointment->health_condition = $pet?->medical_info ?? $pet?->health_status ?? 'Not specified';

    // ✅ Send email to vet
    Mail::to($vet->email)->send(new AppointmentNotificationMail($appointment));

    return back()->with('success', 'Appointment booked successfully!');
}

public function shelterAppointments()
{
    $shelterId = Auth::id();
    $appointments = Appointments::with(['vet', 'pet', 'medicalHistory'])
                    ->where('owner_id', $shelterId)
                    ->orderBy('date', 'desc')
                    ->get();

    return view('admin.appointments', compact('appointments'));
}


    public function ownerAppointments()
{
    $ownerId = Auth::id();

    // Owner ki appointments with vet info
    $appointments = Appointments::where('owner_id', $ownerId)
                    ->with('vet') // assuming appointment->vet() relation defined hai
                    ->latest()
                    ->get();

    return view('ownerdashboard.myappoint', compact('appointments'));
}

    // Email send to owner


  public function cancel($id)
{
    $appointment = Appointments::with(['pet', 'shelterPet'])->findOrFail($id);
    $user = auth()->user();

    // 🧩 Allow owner or shelter to cancel if it's their pet or their own appointment
    if (
        ($user->role === 'owner' && $appointment->owner_id != $user->id) ||
        ($user->role === 'shelter' && optional($appointment->shelterPet)->shelter_id != $user->id)
    ) {
        abort(403, 'Unauthorized');
    }

    $appointment->status = 'Cancelled';
    $appointment->save();

    // ✉️ Notify vet by email (optional)
    if ($appointment->vet) {
        Mail::to($appointment->vet->email)
            ->send(new AppointmentStatusUpdatedMail($appointment));
    }

    return back()->with('success', 'Appointment cancelled successfully!');
}
public function vetAppointments()
{
    $vetId = Auth::id();

    // Vet ki sari appointments fetch karo (with owner + pet)
    $appointments = Appointments::with(['owner', 'pet'])
                    ->where('vet_id', $vetId)
                    ->orderBy('date', 'desc')
                    ->get();

    return view('vetpanel.appointments', compact('appointments'));
}

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Approved,Rejected,Cancelled'
    ]);

    $appointment = Appointments::findOrFail($id);
    $user = auth()->user();

    // ✅ Ensure only vet of this appointment can update
    if ($user->role !== 'vet' || $appointment->vet_id !== $user->id) {
        abort(403, 'Unauthorized action.');
    }

    // ✅ Update status
    $appointment->status = $request->status;
    $appointment->save();

    // ✅ Optionally send email to owner/shelter
    if ($appointment->owner) {
        \Mail::to($appointment->owner->email)
            ->send(new AppointmentStatusUpdatedMail($appointment));
    }

    return back()->with('success', 'Appointment status updated successfully!');
}
   
public function updateVetFeedback(Request $request, $id)
{
    $request->validate([
        'vet_feedback' => 'nullable|string|max:1000',
    ]);

    $appointment = Appointments::with(['pet', 'shelterPet'])->findOrFail($id);
    $user = auth()->user();

    if ($user->role !== 'vet' || $appointment->vet_id !== $user->id) {
        abort(403, 'Unauthorized');
    }

    // Save feedback in appointment
    $appointment->vet_feedback = $request->vet_feedback;
    $appointment->status = 'Completed';
    $appointment->save();

    // Save in pet/shelter_pet table
    if ($appointment->pet) {
        $appointment->pet->update(['medical_info' => $request->vet_feedback]);
    } elseif ($appointment->shelterPet) {
        $appointment->shelterPet->update(['medical_info' => $request->vet_feedback]);
    }

    // 🧠 Save in PetMedicalHistory table
    PetMedicalHistory::create([
        'pet_id' => $appointment->pet?->id,
        'shelter_pet_id' => $appointment->shelterPet?->id,
        'vet_id' => $user->id,
        'notes' => $request->vet_feedback,
    ]);

    return back()->with('success', 'Feedback saved and medical history updated!');
}


}
