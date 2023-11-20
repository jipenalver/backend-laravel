<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $messages = Message::select('users.name', 'messages.message', 'messages.created_at', 'messages.message_id', 'messages.user_id')
                                ->join('users', 'messages.user_id', '=', 'users.id');

        if ($request->keyword) {
            $messages->where(function ($query) use ($request) {
                $query->where('users.name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('messages.message', 'like', '%' . $request->keyword . '%');
            });
        }

        return $messages->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        $validated = $request->validated();

        $message = Message::create($validated);

        return $message;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Message::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MessageRequest $request, string $id)
    {
        $validated = $request->validated();

        $message = Message::findOrFail($id);

        $message->update($validated);

        return $message;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = Message::findOrFail($id);

        $message->delete();

        return $message;
    }
}
