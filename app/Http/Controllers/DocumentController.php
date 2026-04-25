<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentLog;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Document::query();
        
        if ($user->role->name === 'student') {
            $query->where('user_id', $user->id);
        } elseif ($user->role->name === 'dosen') {
            $query->where('target_lecturer_id', $user->id);
        }
        
        $query->with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('targetLecturer', function($qu) use ($search) {
                      $qu->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        $documents = $query->with(['user', 'targetLecturer'])->latest()->get();
        
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $lecturers = User::whereHas('role', function($q) {
            $q->whereIn('name', ['dosen', 'kaprodi']);
        })->get();

        return view('documents.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'target_lecturer_id' => 'required|exists:users,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        // Store in private 'local' disk
        $path = $request->file('file')->store('documents', 'local');

        $document = Document::create([
            'user_id' => Auth::id(),
            'target_lecturer_id' => $request->target_lecturer_id,
            'title' => $request->title,
            'type' => $request->type,
            'status' => 'submitted',
            'file_path' => $path,
            'current_step' => 2,
        ]);

        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => Auth::id(),
            'action' => 'submitted',
            'comment' => 'Dokumen berhasil diajukan oleh mahasiswa.',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        NotificationService::sendStatusUpdate($document, 'submitted');

        return redirect()->route('dashboard')->with('success', 'Dokumen berhasil diajukan!');
    }

    public function show(Document $document)
    {
        $user = Auth::user();
        // Security check
        if ($user->role->name === 'student' && $document->user_id !== $user->id) {
            abort(403);
        }
        if ($user->role->name === 'dosen' && $document->target_lecturer_id !== $user->id) {
            abort(403);
        }

        $document->load(['user', 'logs.user']);
        return view('documents.show', compact('document'));
    }

    public function download(Document $document)
    {
        $user = Auth::user();
        // Security check: Only owner, targeted lecturer, or staff can download
        if ($user->role->name === 'student' && $document->user_id !== $user->id) {
            abort(403);
        }
        if ($user->role->name === 'dosen' && $document->target_lecturer_id !== $user->id) {
            abort(403);
        }

        if (!Storage::disk('local')->exists($document->file_path)) {
            abort(404);
        }

        return Storage::disk('local')->download($document->file_path, $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION));
    }

    public function preview(Document $document)
    {
        $user = Auth::user();
        if ($user->role->name === 'student' && $document->user_id !== $user->id) {
            abort(403);
        }
        if ($user->role->name === 'dosen' && $document->target_lecturer_id !== $user->id) {
            abort(403);
        }

        $path = $document->signed_file_path ?: ($document->stamped_file_path ?: $document->file_path);

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->response($path);
    }

    public function downloadSigned(Document $document)
    {
        $user = Auth::user();
        // Security check
        if ($user->role->name === 'student' && $document->user_id !== $user->id) {
            abort(403);
        }
        if ($user->role->name === 'dosen' && $document->target_lecturer_id !== $user->id) {
            abort(403);
        }

        if (!$document->signed_file_path || !Storage::disk('local')->exists($document->signed_file_path)) {
            abort(404);
        }

        return Storage::disk('local')->download($document->signed_file_path, 'Signed_' . $document->title . '.' . pathinfo($document->signed_file_path, PATHINFO_EXTENSION));
    }

    public function downloadStamped(Document $document)
    {
        $user = Auth::user();
        if ($user->role->name === 'student' && $document->user_id !== $user->id) {
            abort(403);
        }
        if ($user->role->name === 'dosen' && $document->target_lecturer_id !== $user->id) {
            abort(403);
        }

        if (!$document->stamped_file_path || !Storage::disk('local')->exists($document->stamped_file_path)) {
            abort(404);
        }

        return Storage::disk('local')->download($document->stamped_file_path, 'Stamped_' . $document->title . '.' . pathinfo($document->stamped_file_path, PATHINFO_EXTENSION));
    }

    public function updateStatus(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|string|in:verified,approved,rejected,signed',
            'comment' => 'nullable|string',
            'signed_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'stamped_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $user = Auth::user();
        
        // Simple logic for status mapping
        $statusMap = [
            'verified' => ['role' => 'admin', 'next_step' => 3],
            'approved' => ['role' => 'kaprodi', 'next_step' => 4],
            'signed' => ['role' => 'dosen', 'next_step' => 5],
            'rejected' => ['role' => 'any', 'next_step' => $document->current_step],
        ];

        $updateData = [
            'status' => $request->status,
            'current_step' => $request->status === 'rejected' ? $document->current_step : ($statusMap[$request->status]['next_step'] ?? $document->current_step),
        ];

        if ($request->status === 'approved') {
            if ($request->hasFile('stamped_file')) {
                $path = $request->file('stamped_file')->store('documents/stamped', 'local');
                $updateData['stamped_file_path'] = $path;
            }
        }

        if ($request->status === 'signed') {
            $updateData['verification_hash'] = Str::random(32);
            if ($request->hasFile('signed_file')) {
                $path = $request->file('signed_file')->store('documents/signed', 'local');
                $updateData['signed_file_path'] = $path;
            }
        }

        $document->update($updateData);

        $statusLabels = [
            'verified' => 'diverifikasi',
            'approved' => 'diberi stempel digital prodi',
            'signed' => 'ditandatangani',
            'rejected' => 'ditolak',
        ];

        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => $user->id,
            'action' => $request->status,
            'comment' => $request->comment ?? 'Dokumen telah ' . ($statusLabels[$request->status] ?? $request->status) . ' oleh ' . $user->name,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        NotificationService::sendStatusUpdate($document, $request->status);

        return redirect()->back()->with('success', 'Status dokumen berhasil diperbarui.');
    }

    public function revert(Request $request, Document $document)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('super_admin')) {
            abort(403);
        }

        $prevStatus = 'submitted';
        $prevStep = 2;

        if ($document->status === 'verified') {
            $prevStatus = 'submitted';
            $prevStep = 2;
        } elseif ($document->status === 'approved') {
            $prevStatus = 'verified';
            $prevStep = 3;
        } elseif ($document->status === 'signed') {
            $prevStatus = 'approved';
            $prevStep = 4;
            $document->signed_file_path = null;
            $document->verification_hash = null;
        } elseif ($document->status === 'rejected') {
            // For rejected, default to submitted for now
            $prevStatus = 'submitted';
            $prevStep = 2;
        } else {
            return redirect()->back()->with('error', 'Dokumen sudah berada di tahap awal.');
        }

        $document->update([
            'status' => $prevStatus,
            'current_step' => $prevStep,
            'signed_file_path' => $document->signed_file_path,
            'verification_hash' => $document->verification_hash,
        ]);

        $statusLabels = [
            'submitted' => 'Diajukan',
            'verified' => 'Verifikasi Admin',
            'approved' => 'Stempel Digital Prodi',
            'signed' => 'Penandatanganan',
        ];

        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => $user->id,
            'action' => 'reverted',
            'comment' => $request->comment ?? 'Admin mengembalikan progress ke tahap ' . ($statusLabels[$prevStatus] ?? ucfirst($prevStatus)),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Progress dokumen berhasil dikembalikan ke tahap ' . ucfirst($prevStatus));
    }

    public function destroy(Document $document)
    {
        $user = Auth::user();
        $isSuperAdmin = $user->role->name === 'super_admin';
        $isAdmin = $user->role->name === 'admin';

        if ($isSuperAdmin || ($isAdmin && $document->status === 'rejected')) {
            // Delete files from storage
            if ($document->file_path && Storage::disk('local')->exists($document->file_path)) {
                Storage::disk('local')->delete($document->file_path);
            }
            if ($document->signed_file_path && Storage::disk('local')->exists($document->signed_file_path)) {
                Storage::disk('local')->delete($document->signed_file_path);
            }
            
            $document->delete();
            return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus dokumen ini.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:documents,id',
        ]);

        $user = Auth::user();
        $isSuperAdmin = $user->role->name === 'super_admin';
        $isAdmin = $user->role->name === 'admin';

        $documents = Document::whereIn('id', $request->ids)->get();
        $deletedCount = 0;

        foreach ($documents as $doc) {
            if ($isSuperAdmin || ($isAdmin && $doc->status === 'rejected')) {
                // Delete files
                if ($doc->file_path && Storage::disk('local')->exists($doc->file_path)) {
                    Storage::disk('local')->delete($doc->file_path);
                }
                if ($doc->signed_file_path && Storage::disk('local')->exists($doc->signed_file_path)) {
                    Storage::disk('local')->delete($doc->signed_file_path);
                }
                
                $doc->delete();
                $deletedCount++;
            }
        }

        return redirect()->back()->with('success', "$deletedCount dokumen berhasil dihapus.");
    }
}
