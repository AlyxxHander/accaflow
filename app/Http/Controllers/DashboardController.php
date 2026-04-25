<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = \App\Models\Document::query();

        // If student, only show their own documents
        if ($user->role->name === 'student') {
            $query->where('user_id', $user->id);
        }

        $stats = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->whereIn('status', ['submitted', 'verified', 'approved'])->count(),
            'completed' => (clone $query)->where('status', 'signed')->count(),
        ];
        
        return view('dashboard', compact('stats'));
    }
}
