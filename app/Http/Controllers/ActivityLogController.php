<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Menampilkan semua activity log.
     */
    public function index()
    {
        // Ambil data activity log terbaru
        $logs = ActivityLog::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(20);

        return view('admin.activity_logs.index', compact('logs'));
    }
}
