<?php
namespace app\components;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use app\models\Conversation;
use app\models\Message;
use app\models\User;
use DateTime;
use DateTimeZone;

class ChatServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "Новое подключение ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        
        $data = json_decode($msg, true);
        $time = new DateTime('now', new DateTimeZone('Europe/Moscow'));


        if (isset($data['action']) && $data['action'] === 'set_user') {
            if (!isset($data['user_id']) || !is_numeric($data['user_id'])) {
                return;
            }
    
            $from->userId = (int) $data['user_id'];
            echo "Пользователь подключился: ID " . $from->userId . "\n";
        }


        if (isset($data['action']) && $data['action'] === 'get_chats') {
            $userId = $data['user_id'];
        
            $chats = Conversation::find()
                ->where(['participant_one_id' => $userId])
                ->orWhere(['participant_two_id' => $userId])
                ->all();
        
            foreach ($chats as $chat) {
                $otherParticipantId = ($chat->participant_one_id === $userId) 
                    ? $chat->participant_two_id 
                    : $chat->participant_one_id;
        
                $participantInfo = User::findOne(['user_id' => $otherParticipantId]);
      
                $lastMessage = Message::find()
                    ->where(['conversation_id' => $chat->id])
                    ->orderBy(['created_at' => SORT_DESC])
                    ->limit(1)
                    ->one();
        
                    $unreadCount = Message::find()
                    ->where([
                        'conversation_id' => $chat->id,
                        'receiver_id' => $userId,
                        'is_read' => 0
                    ])->count();

                $chatData = [
                    'type' => 'existing_chat',
                    'conversation_id' => $chat->id,
                    'other_participant_id' => $otherParticipantId,
                    'other_participant_name' => $participantInfo->username,
                    'other_participant_photo' => $participantInfo->profile_photo,
                    'created_at' => $chat->created_at,
                    'last_message' => $lastMessage ? $lastMessage->content : null,
                    'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
                    'unread_count' => $unreadCount,
                    'user_id' => $userId
                    
                ];
        
                $from->send(json_encode($chatData));
            }
        }

        if (isset($data['action']) && $data['action'] === 'read_messages') {
            $userId = $data['user_id'];
            $targetUserId = $data['target_user_id'];


            $conversation = Conversation::find()
            ->where(['participant_one_id' => $userId, 'participant_two_id' => $targetUserId])
            ->orWhere(['participant_one_id' => $targetUserId, 'participant_two_id' => $userId])
            ->one();


            Message::updateAll(['is_read' => 1], [
                'conversation_id' => $conversation->id,
                'receiver_id' => $userId,
                'is_read' => 0
            ]);

        }


        if (isset($data['action']) && $data['action'] === 'get_messages') {
            $userId = $data['user_id'];
            $targetUserId = $data['target_user_id'];

            $conversation = Conversation::find()
                ->where(['participant_one_id' => $userId, 'participant_two_id' => $targetUserId])
                ->orWhere(['participant_one_id' => $targetUserId, 'participant_two_id' => $userId])
                ->one();

            if ($conversation) {
                $messages = Message::find()
                    ->where(['conversation_id' => $conversation->id])
                    ->orderBy(['created_at' => SORT_ASC])
                    ->all();

                $messagesData = array_map(function ($message) {
                    return [
                        'id' => $message->id,
                        'sender_id' => $message->sender_id,
                        'receiver_id' => $message->receiver_id,
                        'content' => $message->content,
                        'created_at' => $message->created_at,
                        'is_read' => $message->is_read
                    ];
                }, $messages);


                Message::updateAll(['is_read' => 1], [
                    'conversation_id' => $conversation->id,
                    'receiver_id' => $userId,
                    'is_read' => 0
                ]);
        

                $response = [
                    'type' => 'chat_messages',
                    'conversation_id' => $conversation->id,
                    'messages' => $messagesData,
                    'mark_as_read' => true
                    
                ];

                $from->send(json_encode($response));
            }
        }


        if (isset($data['action']) && $data['action'] === 'send_message') {
            $senderId = $data['sender_id'];
            $receiverId = $data['receiver_id'];
            $content = $data['content'];
        
            if ($senderId === $receiverId) {
                echo "Ошибка: сообщение самому себе запрещено.\n";
                return;
            }
        
            $conversation = Conversation::find()
                ->where(['participant_one_id' => $senderId, 'participant_two_id' => $receiverId])
                ->orWhere(['participant_one_id' => $receiverId, 'participant_two_id' => $senderId])
                ->one();
        

            if (!$conversation) {
                $conversation = new Conversation();
                $conversation->participant_one_id = $senderId;
                $conversation->participant_two_id = $receiverId;
                $conversation->created_at = $time->format('Y-m-d H:i:s');
        
                if ($conversation->save()) {
                    $conversationId = $conversation->id;
                }
            } else {
                $conversationId = $conversation->id;
            }
        
            $message = new Message();
            $message->conversation_id = $conversationId;
            $message->sender_id = $senderId;
            $message->receiver_id = $receiverId;
            $message->content = $content;
            $message->created_at = $time->format('Y-m-d H:i:s');
            $message->is_read = 0;
            
            if ($message->save()) {
                $messageData = [
                    'type' => 'new_message',
                    'conversation_id' => $conversationId,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'content' => $message->content,
                    'created_at' => $message->created_at,
                ];
        
                foreach ($this->clients as $client) {
                    $client->send(json_encode($messageData));
                }
            }
        
            $lastMessage = Message::find()
                ->where(['conversation_id' => $conversationId])
                ->orderBy(['created_at' => SORT_DESC])
                ->limit(1)
                ->one();
        
            $lastMessageText = $lastMessage ? $lastMessage->content : null;
            $lastMessageTime = $lastMessage ? $lastMessage->created_at : null;
        

            $senderInfo = User::findOne(['user_id' => $senderId]);
            $receiverInfo = User::findOne(['user_id' => $receiverId]);
        

            $newChatDataForSender = [
                'type' => 'new_chat',
                'conversation_id' => $conversationId,
                'other_participant_id' => $receiverId,
                'other_participant_name' => $receiverInfo->username,
                'other_participant_photo' => $receiverInfo->profile_photo,
                'created_at' => $conversation->created_at,
                'last_message' => $lastMessageText,
                'last_message_time' => $lastMessageTime,
            ];

            $newChatDataForReceiver = [
                'type' => 'new_chat',
                'conversation_id' => $conversationId,
                'other_participant_id' => $senderId,
                'other_participant_id_two' => $receiverId,
                'other_participant_name' => $senderInfo->username,
                'other_participant_photo' => $senderInfo->profile_photo,
                'created_at' => $conversation->created_at,
                'last_message' => $lastMessageText,
                'last_message_time' => $lastMessageTime,
            ];
        
            foreach ($this->clients as $client) { 

                if ($client === $from) {
                    $client->send(json_encode($newChatDataForSender));
                } else {
                    $client->send(json_encode($newChatDataForReceiver));
                }
            }
        }

        if (isset($data['action']) && $data['action'] === 'delete_chat_everyone') {
            $conversationId = $data['conversation_id'];
        

            Message::deleteAll(['conversation_id' => $conversationId]);
        
  
            Conversation::deleteAll(['id' => $conversationId]);
        
            echo "Чат ($conversationId) удален\n";
        

            foreach ($this->clients as $client) {
                $client->send(json_encode([
                    'action' => 'delete_chat',
                    'conversation_id' => $conversationId
                ]));
            }
        }

               
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Подключение закрыто ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Ошибка: {$e->getMessage()}\n";
        $conn->close();
    }
}
