<?php

namespace App\Services;

use App\Models\Document;
use App\Models\DocumentLog;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public static function sendStatusUpdate(Document $document, $status)
    {
        // Simulate sending WA/Email
        // In a real app, this would call WhatsApp API or Mail::send()
        
        $message = "Notifikasi " . ucfirst($status) . " telah dikirim ke " . $document->user->name . " melalui WhatsApp dan Email.";
        
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => Auth::id() ?? $document->user_id,
            'action' => 'notification',
            'comment' => $message,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        return true;
    }
}
