<?php

namespace App\Http\Controllers;

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

        return new JsonResource($messages);
    }
}
