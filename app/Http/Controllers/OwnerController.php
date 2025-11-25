<?php

namespace App\Http\Controllers;
use App\Models\AdoptionRequest;
use App\Models\orders;
use App\Models\ShelterPet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    //
     public function index(){
        return view('ownerdashboard.index');
    }
public function viewShelterPets()
{
    // sab shelter pets laa lo (sirf available)
    $pets = ShelterPet::where('status', 'available')
        ->with('shelter')
        ->latest()
        ->get();

    return view('ownerdashboard.shelterpets', compact('pets'));
}


public function sendAdoptionRequest($id)
{
    $pet = ShelterPet::findOrFail($id);

    // check agar pehle se request na ki ho
    $existing = AdoptionRequest::where('owner_id', Auth::id())
        ->where('pet_id', $id)
        ->first();

    if ($existing) {
        return back()->with('error', 'You already requested to adopt this pet.');
    }

   AdoptionRequest::create([
    'owner_id' => Auth::id(),
    'pet_id' => $id,
    'shelter_id' => $pet->shelter_id,
    'status' => 'pending',
]);

    return back()->with('success', 'Adoption request sent successfully!');
}
public function myAdoptionRequests()
{
    $requests = AdoptionRequest::with(['pet', 'shelter'])
        ->where('owner_id', Auth::id())
        ->latest()
        ->get();

    return view('ownerdashboard.my-adoptions', compact('requests'));
}


}
