<?php

namespace App\Http\Controllers;

use App\Models\Pets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini di-import

class PetController extends Controller
{
    /**
     * Menampilkan halaman daftar hewan peliharaan (My Pets).
     * Ini adalah halaman utama untuk 'Mypets'.
     */
    public function show()
    {
        $pets = Pets::where('owner_id', auth()->id())->get();
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
     * (INI FUNGSI YANG DIPERBAIKI)
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
            'pet_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Nama input dari form
        ]);

        // 2. Siapkan data untuk disimpan ke database
        // Kita tidak bisa menggunakan $validatedData langsung karena nama kolom foto berbeda
        $dataToSave = [
            'owner_id' => auth()->id(),
            'pet_name' => $validatedData['pet_name'],
            'species' => $validatedData['species'],
            'breed' => $validatedData['breed'],
            'age' => $validatedData['age'],
            'gender' => $validatedData['gender'],
            'medical_info' => $validatedData['medical_info'],
            'photo' => null, // Default foto adalah null
        ];

        // 3. Proses upload foto jika ada
        if ($request->hasFile('pet_photo')) {
            // 'pet_photo' adalah nama dari <input>
            // 'photo' adalah nama kolom di database
            $dataToSave['photo'] = $request->file('pet_photo')->store('pets', 'public');
        }

        // 4. Buat record di database
        Pets::create($dataToSave);

        // 5. PERBAIKAN: Redirect kembali ke halaman DAFTAR HEWAN (pets.show),
        //    BUKAN ke pets.index (halaman profil kosong).
        return redirect()->route('pets.show')->with('success', 'Pet profile added successfully!');
    }

    /**
     * Menampilkan view untuk mengedit (saat ini tidak terpakai oleh form Anda).
     */
    public function edit($id)
    {
        $pet = Pets::findOrFail($id);
        // Seharusnya mengarah ke view edit, tapi kita ikuti logika Anda
        return view('ownerdashboard.mypets', compact('pet'));
    }

    /**
     * Meng-update hewan peliharaan yang ada.
     * (INI FUNGSI YANG DIPERBAIKI)
     */
    public function update(Request $request, $id)
    {
        $pet = Pets::findOrFail($id);

        // 1. Validasi data (gunakan 'pet_photo' agar konsisten dengan form)
        $validatedData = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'nullable|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|string|in:male,female,perempuan,laki-laki',
            'medical_info' => 'nullable|string|max:255',
            'pet_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Nama input dari form
        ]);
        
        // 2. Siapkan data untuk di-update (tanpa foto dulu)
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
            // Hapus foto lama jika ada
            if ($pet->photo && Storage::disk('public')->exists($pet->photo)) {
                Storage::disk('public')->delete($pet->photo);
            }
            // Simpan foto baru dan tambahkan ke data update
            // 'pet_photo' dari form -> 'photo' ke database
            $dataToUpdate['photo'] = $request->file('pet_photo')->store('pets', 'public');
        }

        // 4. Update record
        $pet->update($dataToUpdate);

        return redirect()->route('pets.show')->with('success', 'Pet profile updated successfully!');
    }

    /**
     * Menghapus hewan peliharaan.
     * (INI FUNGSI YANG DIPERBAIKI)
     */
    public function destroy($id)
    {
        $pet = Pets::findOrFail($id);

        // Hapus foto dari storage jika ada
        if ($pet->photo && Storage::disk('public')->exists($pet->photo)) {
            Storage::disk('public')->delete($pet->photo);
        }

        // Hapus record dari database
        $pet->delete();

        // PERBAIKAN: Redirect kembali ke halaman DAFTAR HEWAN ('pets.show')
        return redirect()->route('pets.show')->with('success', 'Pet deleted successfully!');
    }
}
