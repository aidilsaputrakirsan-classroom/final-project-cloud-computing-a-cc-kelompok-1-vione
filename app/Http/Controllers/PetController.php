<?php

namespace App\Http\Controllers;

use App\Models\Pet; // ✅ PERBAIKAN: Gunakan Singular 'Pet', bukan 'Pets'
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class PetController extends Controller
{
    /**
     * Menampilkan halaman daftar hewan peliharaan (My Pets).
     * Ini adalah halaman utama untuk 'Mypets'.
     */
    public function show()
    {
        // ✅ PERBAIKAN: Gunakan Pet::
        $pets = Pet::where('owner_id', auth()->id())->get();
        return view('ownerdashboard.mypets', compact('pets'));
    }

    /**
     * Menampilkan halaman profil individu (saat ini tidak terpakai oleh 'store').
     */
    public function index()
    {
        return view('ownerdashboard.petprofile');
    }

    /**
     * Menyimpan hewan peliharaan baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input dari formulir
        $validatedData = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'nullable|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|string|in:male,female,perempuan,laki-laki',
            'medical_info' => 'nullable|string|max:255',
            'pet_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', 
        ]);

        // 2. Siapkan data untuk disimpan ke database
        $dataToSave = [
            'owner_id' => auth()->id(),
            'pet_name' => $validatedData['pet_name'],
            'species' => $validatedData['species'],
            'breed' => $validatedData['breed'],
            'age' => $validatedData['age'],
            'gender' => $validatedData['gender'],
            'medical_info' => $validatedData['medical_info'],
            'photo' => null, 
        ];

        // 3. Proses upload foto jika ada
        if ($request->hasFile('pet_photo')) {
            $dataToSave['photo'] = $request->file('pet_photo')->store('pets', 'public');
        }

        // 4. Buat record di database
        // ✅ PERBAIKAN: Gunakan Pet::
        Pet::create($dataToSave);

        // 5. Redirect kembali ke halaman DAFTAR HEWAN
        return redirect()->route('pets.show')->with('success', 'Pet profile added successfully!');
    }

    /**
     * Menampilkan view untuk mengedit.
     */
    public function edit($id)
    {
        // ✅ PERBAIKAN: Gunakan Pet::
        $pet = Pet::findOrFail($id);
        return view('ownerdashboard.mypets', compact('pet'));
    }

    /**
     * Meng-update hewan peliharaan yang ada.
     */
    public function update(Request $request, $id)
    {
        // ✅ PERBAIKAN: Gunakan Pet::
        $pet = Pet::findOrFail($id);

        // 1. Validasi data
        $validatedData = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'nullable|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|string|in:male,female,perempuan,laki-laki',
            'medical_info' => 'nullable|string|max:255',
            'pet_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', 
        ]);
        
        // 2. Siapkan data update
        $dataToUpdate = [
            'pet_name' => $validatedData['pet_name'],
            'species' => $validatedData['species'],
            'breed' => $validatedData['breed'],
            'age' => $validatedData['age'],
            'gender' => $validatedData['gender'],
            'medical_info' => $validatedData['medical_info'],
        ];

        // 3. Proses upload foto baru jika ada
        if ($request->hasFile('pet_photo')) {
            if ($pet->photo && Storage::disk('public')->exists($pet->photo)) {
                Storage::disk('public')->delete($pet->photo);
            }
            $dataToUpdate['photo'] = $request->file('pet_photo')->store('pets', 'public');
        }

        // 4. Update record
        $pet->update($dataToUpdate);

        return redirect()->route('pets.show')->with('success', 'Pet profile updated successfully!');
    }

    /**
     * Menghapus hewan peliharaan.
     */
    public function destroy($id)
    {
        // ✅ PERBAIKAN: Gunakan Pet::
        $pet = Pet::findOrFail($id);

        if ($pet->photo && Storage::disk('public')->exists($pet->photo)) {
            Storage::disk('public')->delete($pet->photo);
        }

        $pet->delete();

        return redirect()->route('pets.show')->with('success', 'Pet deleted successfully!');
    }
}