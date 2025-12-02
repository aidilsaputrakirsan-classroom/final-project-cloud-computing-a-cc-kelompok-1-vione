<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // 1. QUERY DASAR
        $query = ActivityLog::with('user')->latest();

        // 2. LOGIKA FILTER (Search & Filter Action)
        // Jika ada pencarian kata kunci
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Jika ada filter tipe aksi (Create, Update, Delete)
        if ($request->has('actions')) {
            $query->whereIn('action', $request->actions);
        }

        // Jika ada filter tanggal (Hari ini, Bulan ini, dsb)
        if ($request->has('date_range')) {
            if ($request->date_range == 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($request->date_range == '7days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
            } elseif ($request->date_range == '30days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            }
        }

        // Ambil data (Paginate)
        $logs = $query->paginate(10)->withQueryString();

        // 3. STATISTIK UNTUK DASHBOARD
        // Kita hitung jumlah data untuk ditampilkan di kartu atas
        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', Carbon::today())->count(),
            'create' => ActivityLog::where('action', 'CREATE')->count(),
            'update' => ActivityLog::where('action', 'UPDATE')->count(),
            'delete' => ActivityLog::where('action', 'DELETE')->count(),
        ];

        return view('admin.activity_logs.index', compact('logs', 'stats'));
    }
}