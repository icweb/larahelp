<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function upload(Request $request, Ticket $ticket)
    {
        $disk_path = '/ticket-attachments/' . $ticket->id . '/';
        $file_name =  time() . '.' . $request->file('attachment')->getClientOriginalExtension();
        $file_size =  $request->file('attachment')->getSize();
        $file_extension = $request->file('attachment')->getMimeType();

        $request->file('attachment')->storeAs($disk_path, $file_name, 'public');

        $ticket->attachments()->create([
            'disk_path'         => $disk_path,
            'file_name'         => $file_name,
            'file_size'         => $file_size,
            'file_extension'    => $file_extension,
        ]);

        return redirect()->back();
    }

    public function download(Request $request, Attachment $attachment)
    {
        return Storage::disk('public')->download($attachment->full_disk_path);
    }
}
