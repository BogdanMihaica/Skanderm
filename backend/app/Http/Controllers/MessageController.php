<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageController extends Controller
{
    /**
     * Returns a list of all messages
     *
     * @return JsonResource
     */
    public function index()
    {
        $messages = Message::all();

        return JsonResource::collection($messages);
    }

    public function show(Message $message) {
        return new JsonResource($message);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'chat_id' => ['required', 'exists:chats,id'],
            'user_id' => ['required', 'exists:users,id'],
            'message' => ['required', 'string', 'max:2048'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120']
        ]);

        $imagesFullNames = [];

        foreach ($validated['images'] as $imageFile) {
            $filename = BaseModel::generatRandomFilename() . '.' . $imageFile->extension();
            $path = BaseModel::generateRandomPath();
            $imagesFullNames[] = $path . $filename;
            $imageFile->storeAs('files/' . $path, $filename, 'public');
        }

        $message = new Message();

        $message->fill($validated);
        $message->images = $imagesFullNames;

        $message->save;

        return $this->show($message);
    }
}
