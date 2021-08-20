<?php

namespace App\Http\Livewire\Chat;

use App\Models\Message;
use App\Models\Room;
use Livewire\Component;

class Messages extends Component
{
    public $messages;
    public $roomId;

    public function mount(Room $room, $messages)
    {
        $this->messages = $messages;
        $this->roomId = $room->id;
    }

    public function getListeners()
    {
        return [
            'message.added' => 'prependMessage',
            "echo-private:chat.{$this->roomId},Chat\\MessageAdded" => 'prependMessageFromBroadcast'
        ];
    }

    public function prependMessage($id)
    {
        $this->messages->prepend(Message::find($id));
    }

    public function prependMessageFromBroadcast($payload)
    {
        $this->prependMessage($payload['message']['id']);
    }

    public function render()
    {
        return view('livewire.chat.messages');
    }
}
