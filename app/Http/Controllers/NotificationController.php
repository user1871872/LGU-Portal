<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PkCertificate;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }

        
        $notification = $user->notifications()->where('id', $id)->first();

        if (!$notification) {
            return redirect()->back()->with('error', 'Notification not found.');
        }

        
        $notification->markAsRead();

        
        $fileUrl = $notification->data['file_url'] ?? null;
        if ($fileUrl) {
            return redirect()->to($fileUrl);
        }

        return redirect()->back()->with('error', 'Permit file not found.');
    }
}

