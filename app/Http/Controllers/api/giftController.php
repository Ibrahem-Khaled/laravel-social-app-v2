<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class giftController extends Controller
{
    public function index()
    {
        $gifts = Gift::where('is_active', true)->get();
        return response()->json($gifts);
    }

    public function sendGift(Request $request)
    {
        $user = auth()->guard('api')->user();
        $validator = Validator::make($request->all(), [
            'gift_id' => 'required|exists:gifts,id',
            'receiver_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $gift = Gift::findOrFail($request->gift_id);
        $receiver = User::findOrFail($request->receiver_id);

        if ($user->coins < $gift->price) {
            return response()->json(['message' => 'ليس لديك كافة النقاط'], 422);
        }

        // خصم النقاط
        $user->coins -= $gift->price;
        $user->save();

        // نفذ داخل معاملة لضمان الاتساق
        DB::transaction(function () use ($gift, $receiver, $user) {
            // ابحث عن السجل الوسيط وقم بقفله للتحديث
            $pivot = DB::table('user_gifts')
                ->where('gift_id', $gift->id)
                ->where('user_id', $receiver->id)
                ->where('sender_id', $user->id)
                ->lockForUpdate()
                ->first();

            if ($pivot) {
                // إذا وُجد، زِد الكمية
                DB::table('user_gifts')
                    ->where('gift_id', $gift->id)
                    ->where('user_id', $receiver->id)
                    ->where('sender_id', $user->id)
                    ->update([
                        'quantity' => $pivot->quantity + 1
                    ]);
            } else {
                // وإلّا أضف سجلّاً جديداً
                $gift->users()->attach($receiver->id, [
                    'quantity'  => 1,
                    'sender_id' => $user->id
                ]);  // :contentReference[oaicite:0]{index=0}
            }
        });

        return response()->json([
            'message' => 'تم ارسال الهدية بنجاح',
            'gift' => $gift,
            'receiver' => $receiver,
            'sender' => $user
        ]);
    }

    public function getGifts(Request $request)
    {
        $user = auth()->guard('api')->user();
        $gifts = DB::table('user_gifts')
            ->join('gifts', 'gifts.id', '=', 'user_gifts.gift_id')
            ->where('user_gifts.user_id', $user->id)
            ->groupBy('gifts.id', 'gifts.title', 'gifts.description', 'gifts.image', 'gifts.created_at', 'gifts.updated_at')
            ->select([
                'gifts.id',
                'gifts.title',
                'gifts.description',
                'gifts.price',
                'gifts.image',
                DB::raw('SUM(user_gifts.quantity) as total_quantity'),
            ])
            ->get();

        return response()->json($gifts);
    }
}
