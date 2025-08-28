<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttachmentResource;
use App\Models\Attachment;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentApiController extends Controller
{
    // POST /api/contact/messages/{message}/attachments
    public function storeForMessage(Request $request, ContactMessage $message)
    {
        $request->validate([
            'attachments.*' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx,zip', 'max:5120'],
        ]);

        $created = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('contact_attachments', 'public');
                $created[] = $message->attachments()->create([
                    'disk'          => 'public',
                    'path'          => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime'          => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                    'uploaded_by'   => auth('sanctum')->id(),
                ]);
            }
        }

        return AttachmentResource::collection(collect($created))
            ->additional(['message' => 'تم رفع المرفقات.']);
    }

    // GET /api/attachments/{attachment}/download
    public function download(Attachment $attachment)
    {
        return Storage::disk($attachment->disk)
            ->download($attachment->path, $attachment->original_name);
    }

    // DELETE /api/attachments/{attachment}
    public function destroy(Attachment $attachment)
    {
        if ($attachment->disk && $attachment->path) {
            Storage::disk($attachment->disk)->delete($attachment->path);
        }
        $attachment->delete();

        return response()->json(['message' => 'تم حذف المرفق.']);
    }
}
