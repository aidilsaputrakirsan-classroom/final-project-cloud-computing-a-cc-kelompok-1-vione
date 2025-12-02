<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use App\Models\ShelterPet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShelterController extends Controller
{
    // 🏠 Shelter Dashboard - show shelter’s pets
    public function index()
    {
        $shelterId = Auth::id();
        $pets = ShelterPet::with(['appointments.vet'])
            ->where('shelter_id', $shelterId)
            ->get();

        return view('admin.index', compact('pets'));
    }

    // 🐾 Add new pet form
    public function create()
    {
        $shelterId = Auth::id();
        $pets = ShelterPet::where('shelter_id', $shelterId)->get();

        return view('admin.index', compact('pets'));
    }

    // 💾 Store new pet
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'nullable|string',
            'breed' => 'nullable|string',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string',
            'medical_info' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:5120',
        ]);

        $data = $request->only(['name', 'species', 'breed', 'age', 'medical_info']);
        $data['shelter_id'] = Auth::id();

        // ✅ FIX: Konversi Gender (Indo -> English)
        if (strtolower($request->gender) == 'jantan') {
            $data['gender'] = 'Male';
        } elseif (strtolower($request->gender) == 'perempuan') {
            $data['gender'] = 'Female';
        } else {
            $data['gender'] = $request->gender; // Jaga-jaga jika inputnya sudah Male/Female
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('shelter_pets', 'public');
        }

        ShelterPet::create($data);
        return redirect()->route('shelter.dashboard')->with('success', 'Pet added for adoption!');
    }

    // 📝 Update Pet
    public function update(Request $request, $id)
    {
        $pet = ShelterPet::findOrFail($id);

        if ($pet->shelter_id != Auth::id()) {
            abort(403, 'Unauthorized action');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'nullable|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'medical_info' => 'nullable|string|max:255',
            'status' => 'required|in:available,pending,adopted',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:5120',
        ]);

        // Perbaikan: gunakan 'name' bukan 'pet_name'
        $data = $request->only(['name', 'species', 'breed', 'age', 'medical_info', 'status']);

        // ✅ FIX: Konversi Gender untuk Update juga
        if ($request->has('gender')) {
            if (strtolower($request->gender) == 'jantan') {
                $data['gender'] = 'Male';
            } elseif (strtolower($request->gender) == 'perempuan') {
                $data['gender'] = 'Female';
            } else {
                $data['gender'] = $request->gender;
            }
        }

        // 🖼️ If new image uploaded
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('shelter_pets', 'public');
        }

        $pet->update($data);

        return back()->with('success', 'Pet details updated successfully!');
    }


    // 🗑️ Delete pet
    public function destroy($id)
    {
        $pet = ShelterPet::findOrFail($id);
        if ($pet->shelter_id != Auth::id()) abort(403);
        $pet->delete();
        return back()->with('success', 'Pet deleted.');
    }

    // 📋 View Adoption Requests
    // 🐶 Shelter Adoption Requests List
    public function adoptionRequests()
    {
        $requests = AdoptionRequest::with(['pet', 'owner'])
            ->where('shelter_id', \Auth::id())
            ->latest()
            ->get();

        return view('admin.request', compact('requests'));
    }

    // 🟢 Approve/Reject Adoption Request
    public function updateAdoptionStatus($id, $status)
    {
        $request = AdoptionRequest::findOrFail($id);

        // ✅ ensure only that shelter can change it
        if ($request->shelter_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // ✅ update status (approved / rejected)
        $request->status = $status;
        $request->save();

        // ✅ update pet status if approved
        if ($status == 'approved') {
            ShelterPet::where('id', $request->pet_id)
                ->update(['status' => 'adopted']);
        }

        return back()->with('success', "Adoption request {$status} successfully!");
    }
}