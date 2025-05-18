<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

class ChatController extends Controller
{
    public function index() {
        $chats = QueryBuilder::for(Chat::class)
            ->with('user')
            ->allowedSorts('created_at')
            ->allowedFilters('user.name', 'user.email')
            ->paginate();

        return JsonResource::collection($chats);
    }

    public function show(Chat $chat) {
        return new JsonResource($chat);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id']
        ]);

        $chat = new Chat($validated);
        $chat->save();

        return $this->show($chat);
    }
}
