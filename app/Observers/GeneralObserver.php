<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GeneralObserver
{
    /**
     * Handle events (created, updated, deleted).
     */
    public function created(Model $model)
    {
        $this->logActivity($model, 'CREATE', 'Menambahkan data baru');
    }

    public function updated(Model $model)
    {
        // Cek jika field 'status' berubah (khusus untuk Appointment/Adoption)
        if ($model->isDirty('status')) {
            $desc = "Mengubah status menjadi " . $model->status;
        } else {
            $desc = "Memperbarui data";
        }
        
        $this->logActivity($model, 'UPDATE', $desc);
    }

    public function deleted(Model $model)
    {
        $this->logActivity($model, 'DELETE', 'Menghapus data');
    }

    /**
     * Fungsi privat untuk menyimpan ke database
     */
    private function logActivity(Model $model, $action, $description)
    {
        // Ambil nama model (misal: "Pet", "Appointment")
        $modelName = class_basename($model);
        
        // Coba ambil nama item jika ada (misal nama hewan)
        $itemName = $model->name ?? 'ID #' . $model->id;

        ActivityLog::create([
            'user_id'     => Auth::check() ? Auth::id() : null, // Cek login
            'action'      => $action,
            'description' => "User " . (Auth::user()->name ?? 'System') . " melakukan {$action} pada {$modelName} ({$itemName}). Detail: {$description}.",
        ]);
    }
}