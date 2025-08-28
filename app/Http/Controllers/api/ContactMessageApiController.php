<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contact\StoreRequest;
use App\Http\Requests\Api\Contact\UpdateRequest;
use App\Http\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactMessageApiController extends Controller
{
    // GET /api/contact/messages (admin/support)
    public function index(Request $request)
    {
        $status = $request->query('status'); // open|pending|closed|spam
        $search = $request->query('search');

        $q = ContactMessage::query()->with(['user', 'assignee'])->latest();

        if ($status && $status !== 'all') {
            $q->where('status', $status);
        }

        if ($search) {
            $q->where(function ($w) use ($search) {
                $w->where('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('guest_email', 'like', "%{$search}%")
                    ->orWhere('guest_phone', 'like', "%{$search}%");
            });
        }

        $messages = $q->paginate(15); // JSON pagination
        return ContactMessageResource::collection($messages);
    }

    // GET /api/contact/messages/{message}
    public function show(ContactMessage $message)
    {
        $message->load(['user', 'assignee', 'attachments']);
        return new ContactMessageResource($message);
    }

    // POST /api/contact/messages  (guest or auth)
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        // لو المستخدم مسجّل: أربط الرسالة تلقائيًا
        if (auth('sanctum')->check() && empty($data['user_id'])) {
            $data['user_id'] = auth('sanctum')->id();
        }

        // قيم افتراضية عند عدم الإرسال
        $data['status']   = $data['status']   ?? 'open';
        $data['priority'] = $data['priority'] ?? 'normal';
        $data['category'] = $data['category'] ?? 'general';
        $data['source']   = $data['source']   ?? 'mobile';

        $data['ip_address'] = $request->ip();
        $data['user_agent'] = substr((string)$request->userAgent(), 0, 1000);

        $message = ContactMessage::create($data);

        // مرفقات (multi-part form-data)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('contact_attachments', 'public');
                $message->attachments()->create([
                    'disk'          => 'public',
                    'path'          => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime'          => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                    'uploaded_by'   => auth('sanctum')->id(),
                ]);
            }
        }

        return (new ContactMessageResource($message->fresh(['attachments', 'user', 'assignee'])))
            ->additional(['message' => 'تم إنشاء الرسالة بنجاح.']);
    }

    // PATCH /api/contact/messages/{message}  (admin/support)
    public function update(UpdateRequest $request, ContactMessage $message)
    {
        $data = $request->validated();

        if (array_key_exists('assignee_id', $data)) {
            $message->assigned_to_id = $data['assignee_id']; // الحقل اسمه assigned_to_id في الجدول
            unset($data['assignee_id']);
        }

        $message->update($data);

        return (new ContactMessageResource($message->fresh(['attachments', 'user', 'assignee'])))
            ->additional(['message' => 'تم التحديث بنجاح.']);
    }

    // DELETE /api/contact/messages/{message}
    public function destroy(ContactMessage $message)
    {
        // حذف ملفات المرفقات من الـdisk كذلك
        $message->load('attachments');
        foreach ($message->attachments as $att) {
            if ($att->disk && $att->path) {
                Storage::disk($att->disk)->delete($att->path);
            }
            $att->delete();
        }
        $message->delete();

        return response()->json(['message' => 'تم الحذف بنجاح.']);
    }
}
