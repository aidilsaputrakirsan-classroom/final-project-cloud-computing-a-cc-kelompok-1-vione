<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\PetMedicalHistory;
use App\Models\vetProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VetController extends Controller
{
    //
   public function index()
{
    $vetId = Auth::id();

    // Total appointments for this vet
    $totalAppointments = Appointments::where('vet_id', $vetId)->count();

    // Pending
    $pending = Appointments::where('vet_id', $vetId)
                ->where('status', 'Pending')
                ->count();

    // Approved
    $approved = Appointments::where('vet_id', $vetId)
                ->where('status', 'Approved')
                ->count();

    // Rejected
    $rejected = Appointments::where('vet_id', $vetId)
                ->where('status', 'Rejected')
                ->count();
        return view('vetpanel.index',compact('totalAppointments', 'pending', 'approved', 'rejected'));
    }
    public function vets()
{
    // saare vets nikal lo jinka role 'vet' hai
     $pets = \App\Models\Pets::where('owner_id', Auth::id())->get(); // 🐾 owner ke pets

    $vets = \App\Models\User::where('role', 'vet')->get();

    return view('ownerdashboard.availablevets', compact('pets','vets'));
}

 public function edit()
    {
        $vet = Auth::user();
        $profile = VetProfile::where('user_id', $vet->id)->first();

        return view('vetpanel.profile', compact('vet', 'profile'));
    }

    // 💾 Update vet profile
    public function update(Request $request)
    {
        $vet = Auth::user();

        $request->validate([
            'specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'clinic_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'available_days' => 'nullable|string|max:255',
    'available_time' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // profile update or create
        $profile = vetProfile::updateOrCreate(
            ['user_id' => $vet->id],
            [
                'specialization' => $request->specialization,
                'experience' => $request->experience,
                'clinic_name' => $request->clinic_name,
                'contact_number' => $request->contact_number,
                'available_days' => $request->available_days,
                 'available_time' => $request->available_time,

                'about' => $request->about,
            ]
        );

        // photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('vet_photos', 'public');
            $profile->update(['photo' => $path]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }


   public function addFeedback(Request $request, $id)
{
    $request->validate([
        'feedback' => 'required|string|max:2000',
    ]);

    // 🩵 Appointment with pet
    $appointment = Appointments::with('pet')->findOrFail($id);

    if (!$appointment->pet) {
        return back()->with('error', 'Pet information not found for this appointment.');
    }

    // 🩺 Save feedback
    PetMedicalHistory::create([
        'pet_id' => $appointment->pet->id,
        'vet_id' => Auth::id(),
        'notes' => $request->feedback,
    ]);

    // ✅ Update appointment status
    $appointment->update(['status' => 'Completed']);

    // ✅ Optional: send mail to owner
    // Mail::to($appointment->owner->email)->send(new FeedbackAddedMail($appointment));

    return back()->with('success', 'Feedback added and pet medical history updated!');
}


}
