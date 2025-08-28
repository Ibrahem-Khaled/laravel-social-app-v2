<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreContactMessageRequest;
use App\Http\Requests\Contact\UpdateContactMessageRequest;
use App\Models\{ContactMessage, Attachment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContactMessageController extends Controller
{
    private array $statuses  = ['open', 'pending', 'closed', 'spam'];
    private array $priorities = ['low', 'normal', 'high', 'urgent'];

    public function index(Request $request)
    {
        $selectedStatus = $request->query('status', 'all');
        $search         = $request->query('search');

        $q = ContactMessage::query()->with(['user', 'assignee'])->latest();

        if ($selectedStatus !== 'all') {
            $q->where('status', $selectedStatus);
        }

        if ($search) {
            $q->where(function ($w) use ($search) {
                $w->where('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('guest_email', 'like', "%{$search}%")
                    ->orWhere('guest_phone', 'like', "%{$search}%");
            });
        }

        $messages = $q->paginate(12)->withQueryString();

        // إحصائيات لبطاقات أعلى الصفحة
        $total   = ContactMessage::count();
        $open    = ContactMessage::where('status', 'open')->count();
        $pending = ContactMessage::where('status', 'pending')->count();
        $closed  = ContactMessage::where('status', 'closed')->count();

        return view('dashboard.contacts.index', compact(
            'messages',
            'selectedStatus',
            'total',
            'open',
            'pending',
            'closed'
        ));
    }

    public function store(StoreContactMessageRequest $request)
    {
        $data = $request->validated();

        // لو المستخدم داخل، ممكن تجيب user_id من auth()->id()
        if (auth()->check() && empty($data['user_id'])) {
            $data['user_id'] = auth()->id();
        }

        $data['ip_address'] = $request->ip();
        $data['user_agent'] = substr((string)$request->userAgent(), 0, 1000);

        $message = ContactMessage::create($data);

        // حفظ المرفقات (متعددة)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('contact_attachments', 'public'); // public disk
                $message->attachments()->create([
                    'disk'          => 'public',
                    'path'          => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime'          => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                    'uploaded_by'   => auth()->id(),
                ]);
            }
        }

        return back()->with('success', 'تم إضافة الرسالة بنجاح.');
    }

    public function update(UpdateContactMessageRequest $request, ContactMessage $contact_message)
    {
        $data = $request->validated();
        $contact_message->update($data);

        // إضافة مرفقات جديدة (إن وُجدت)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('contact_attachments', 'public');
                $contact_message->attachments()->create([
                    'disk'          => 'public',
                    'path'          => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime'          => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                    'uploaded_by'   => auth()->id(),
                ]);
            }
        }

        return back()->with('success', 'تم تحديث الرسالة.');
    }

    public function destroy(ContactMessage $contact_message)
    {
        // حذف attachments الفعلية من الـdisk
        foreach ($contact_message->attachments as $att) {
            if ($att->disk && $att->path) {
                Storage::disk($att->disk)->delete($att->path);
            }
            $att->delete();
        }
        $contact_message->delete();

        return back()->with('success', 'تم حذف الرسالة مع مرفقاتها.');
    }

    // حذف مرفق منفرد (يُستدعى من مودال "عرض")
    public function destroyAttachment(Attachment $attachment)
    {
        if ($attachment->disk && $attachment->path) {
            Storage::disk($attachment->disk)->delete($attachment->path);
        }
        $attachment->delete();

        return back()->with('success', 'تم حذف المرفق.');
    }

    // تنزيل مرفق
    public function downloadAttachment(Attachment $attachment)
    {
        return Storage::disk($attachment->disk)->download($attachment->path, $attachment->original_name);
    }
}
