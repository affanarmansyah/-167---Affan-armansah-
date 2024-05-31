<?php

namespace App\Http\Controllers;

use App\Models\RentLogs;

class RentLogController extends Controller
{
    public function index()
    {
        $rentlog = RentLogs::with(['user', 'book'])->where('approval_status', 'approved')->get();
        return view('rent-log', [
            'rentlog' => $rentlog,
        ]);
    }
}
