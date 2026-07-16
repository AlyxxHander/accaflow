<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class PublicVerificationController extends Controller
{
    public function verify($hash)
    {
        $document = Document::where('verification_hash', $hash)->with(['user', 'logs.user'])->firstOrFail();
        
        // Find who signed it
        $signer = $document->logs()->where('action', 'signed')->with('user')->first()?->user;

        return view('public.verify', compact('document', 'signer'));
    }

    public function track($id)
    {
        $document = Document::with(['user', 'logs.user'])->findOrFail($id);
        return view('public.track', compact('document'));
    }
}
