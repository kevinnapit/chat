<?php

namespace App\Controllers;

use App\Models\MessageModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Response;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat/index');
    }

    public function fetchMessages()
    {
        $messageModel = new MessageModel();
        $messages = $messageModel->orderBy('timestamp', 'ASC')->findAll();
        return $this->response->setJSON($messages);
    }

    public function sendMessage()
    {
        $session = session();
        $messageModel = new MessageModel();

        $senderId = $session->get('user_id');
        $receiverId = $this->request->getPost('receiver_id');
        $message = $this->request->getPost('message');

        $messageModel->save([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message
        ]);

        return $this->response->setStatusCode(200);
    }
}
