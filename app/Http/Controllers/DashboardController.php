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
        } elseif ($user->role->name === 'dosen') {
            $query->where('target_lecturer_id', $user->id);
        }

        $stats = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->whereIn('status', ['submitted', 'verified', 'approved'])->count(),
            'completed' => (clone $query)->where('status', 'signed')->count(),
        ];

        // Overdue Indicator
        $twoDaysAgo = \Carbon\Carbon::now()->subDays(2);
        $overdueQuery = (clone $query)->whereNotIn('status', ['signed', 'rejected'])
                                      ->where('updated_at', '<', $twoDaysAgo);
        
        $stats['overdue'] = $overdueQuery->count();
        $overdueDocuments = $overdueQuery->with(['user', 'targetLecturer'])->get();

        // Reminders
        $actionReminders = collect();
        $studentReminders = collect();

        if ($user->role->name === 'student') {
            // Document newly signed within 3 days
            $studentReminders = (clone $query)->where('status', 'signed')
                                              ->where('updated_at', '>=', \Carbon\Carbon::now()->subDays(3))
                                              ->with(['targetLecturer'])
                                              ->get();
        } else {
            // Staff Action Reminders based on Role
            $actionQuery = (clone $query);
            if ($user->role->name === 'admin' || $user->role->name === 'super_admin') {
                $actionQuery->where('status', 'submitted');
            } elseif ($user->role->name === 'kaprodi') {
                $actionQuery->where('status', 'verified');
            } elseif ($user->role->name === 'dosen') {
                $actionQuery->where('status', 'approved');
            }
            $actionReminders = $actionQuery->with(['user', 'targetLecturer'])->get();
        }
        
        return view('dashboard', compact('stats', 'overdueDocuments', 'actionReminders', 'studentReminders'));
    }
}
