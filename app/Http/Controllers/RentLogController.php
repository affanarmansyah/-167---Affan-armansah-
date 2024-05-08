<?php

namespace App\Http\Controllers;

use App\Models\RentLogs;

class RentLogController extends Controller
{
    public function index()
    {
        $rentlog = RentLogs::with(['user', 'book'])->get();
        return view('rent-log', [
            'rentlog' => $rentlog,
        ]);
    }
}
