<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard', [
            'total_item' => Item::count(),
            'room' => Room::count(),
            'kondisi_baik' => Item::where('status', 'good')->count(),
            'kondisi_rusak' => Item::where('status', 'broke')->count(),
            'maintenance' => Item::where('status', 'maintenance')->count()
        ]);
    }

    public function dashboardUser()
    {
        return view('dashboard-user');
    }
}
