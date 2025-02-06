const socket = new WebSocket('ws://localhost:8080/chat');

const urlParams = new URLSearchParams(window.location.search);
const targetUserId = urlParams.get('id');
let conversationId = null;
const currentUserId = document.querySelector('#userId').textContent.substring(1);
const sendMessage = (conversationId, senderId, receiverId, content) => {
    const data = {
        action: 'send_message',
        conversation_id: conversationId,
        sender_id: senderId,
        receiver_id: receiverId,
        content: content,
    };
    socket.send(JSON.stringify(data));
};

const messInputForm = document.querySelector('#messInputForm');
if (messInputForm) {
    messInputForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const inputField = document.querySelector('#messageInput');
        const message = inputField.value.trim();


        if (message) {
            sendMessage(conversationId, currentUserId, targetUserId, message);
            inputField.value = '';
        }
    });
}

socket.onopen = () => {
    const currentUserId = document.querySelector('#userId').textContent.substring(1);

    socket.send(JSON.stringify({ action: 'get_chats', user_id: currentUserId }));

    if (targetUserId) {
        socket.send(JSON.stringify({
            action: 'get_messages',
            user_id: currentUserId,
            target_user_id: targetUserId,
        }));
    }
};

socket.onmessage = (event) => {
    const data = JSON.parse(event.data);

    if (data.type === 'existing_chat') {
        console.log(data);
        const chatList = document.querySelector('#chatList');
        if (chatList) {
            const existingChat = chatList.querySelector(`[data-participant-id="${data.other_participant_id}"]`);
            if (!existingChat) {
                createNewChat(data, chatList);
            }
            else {
                let chatid = document.querySelector('.userFieldInfoId');
                if (chatid) {
                    chatid = chatid.textContent.substring(1)
                        updateUnreadCount(existingChat, data.unread_count);
                  }
            }
        }
        
    }


    if (data.action === "delete_chat") {
        let chatElement = document.querySelector(`[data-chat-id="${data.conversation_id}"]`);
        if (chatElement) {
            chatElement.remove(); 
            document.location.href = 'http://localhost/messenger/web/profile/'
        }
    }
    
    if (data.type === 'new_chat') {
        const chatList = document.querySelector('#chatList');
        const existingChat = chatList.querySelector(`[data-participant-id="${data.other_participant_id}"]`);
    
        if (!existingChat) {
            if (!data.other_participant_id_two) {
                createNewChat(data, chatList);
            }
            else if (currentUserId === data.other_participant_id_two) {
                createNewChat(data, chatList);
            }

            const chatItem = document.querySelector(`[data-chat-id="${data.conversation_id}"]`);
            let user = document.querySelector('#userId');
            if (user) {
                user = user.textContent.substring(1)
              }
            if (data.other_participant_id_two == user) { 
                updateUnreadCount(chatItem, 1);
            }
        }
    }

    if (data.type === 'chat_messages') {
        const chatMesseng = document.querySelector('#chatMesseng');
        chatMesseng.innerHTML = '';

        data.messages.forEach((message) => {
            const messageElement = document.createElement('div');
            const messageSpan = document.createElement('span');
            const dataSpan = document.createElement('span');



            let dateMess = new Date(message.created_at);
            let hours = dateMess.getHours();
            let minutes = dateMess.getMinutes().toString().padStart(2, '0');
            
            dataSpan.textContent = `${hours}:${minutes}`;

            messageSpan.textContent = message.content;

            if (message.sender_id === document.querySelector('#userId').textContent.substring(1)) {
                messageElement.classList.add('send');
            } else {
                    messageElement.classList.add('received');
                }

            dataSpan.classList = 'senddateMessenge';
            messageElement.append(messageSpan, dataSpan);
            chatMesseng.appendChild(messageElement);
            chatMesseng.scrollTop = chatMesseng.scrollHeight;
        });

        if (data.mark_as_read) {
            const chatItem = document.querySelector(`[data-chat-id="${data.conversation_id}"]`);
            if (chatItem) {
                updateUnreadCount(chatItem, 0);
            }
        }

    }

    if (data.type === 'new_message') {
        const chatMesseng = document.querySelector('#chatMesseng');
        const chatItem = document.querySelector(`[data-chat-id="${data.conversation_id}"]`);
        const messageElement = document.createElement('div');
        const messageSpan = document.createElement('span');
        const dataSpan = document.createElement('span');

        let dateMess = new Date(data.created_at);
        let hours = dateMess.getHours();
        let minutes = dateMess.getMinutes().toString().padStart(2, '0');
        
        dataSpan.textContent = `${hours}:${minutes}`;
        messageSpan.textContent = data.content;

        if (data.sender_id === document.querySelector('#userId').textContent.substring(1)) {
            messageElement.classList.add('send');
            dataSpan.classList = 'senddateMessenge';
        } else {
            if(data.receiver_id === currentUserId) {
                messageElement.classList.add('received');
                dataSpan.classList = 'receiveddateMessenge';
            }
            else {
                messageElement.style.display = 'none';
            }
        }

        if (chatItem) {
            const param = new URLSearchParams(window.location.search).get(
                "id"
              );
            let chatid = document.querySelector('.userFieldInfoId');
            let user = document.querySelector('#userId');
              if (user) {
                user = user.textContent.substring(1)
              }

              if (chatid) {
                chatid = chatid.textContent.substring(1)
              }
            const currentUnread = parseInt(chatItem.getAttribute('data-unread-count')) || 0;
            console.log(data);
            if (!chatid) {
                updateUnreadCount(chatItem, currentUnread + 1);
        }
        else {
            if (data.sender_id == chatid) {
                socket.send(JSON.stringify({
                    action: 'read_messages',
                    user_id: currentUserId,
                    target_user_id: chatid,
                }));
            }

        }
        }

        messageElement.append(messageSpan, dataSpan);
        chatMesseng.appendChild(messageElement);
        chatMesseng.scrollTop = chatMesseng.scrollHeight;
        if (data.receiver_id === currentUserId) {
            const messageNewChat = document.querySelector(`#${data.sender_id}`);
            if (messageNewChat) {
                messageNewChat.textContent = data.content;
            }
        }
        else {
            const messageNewChat = document.querySelector(`#${data.receiver_id}`);
            if (messageNewChat) {
                messageNewChat.textContent = data.content;
            }
        }
    }
};


function createNewChat(data, chatList) {
    const newChat = document.createElement('div');
    newChat.classList = 'chatItem';

    const newChata = document.createElement('a');
    newChata.href = `/messenger/web/profile?id=${data.other_participant_id}`;

    const imgNewChat = document.createElement('img');
    imgNewChat.classList = 'chatItemImg';
    imgNewChat.src = "/messenger/web/" + data.other_participant_photo;

    const infoCont = document.createElement('div');
    infoCont.classList = 'chatItemInfoCont';

    const nameNewChat = document.createElement('p');
    nameNewChat.textContent = data.other_participant_name;

    const messageNewChat = document.createElement('p');
    messageNewChat.textContent = data.last_message;
    messageNewChat.id = data.other_participant_id;

    const unreadSpan = document.createElement('span');
    unreadSpan.classList.add('unread-count');
    unreadSpan.textContent = data.unread_count;
    if (data.unread_count === 0) unreadSpan.style.display = 'none';


    infoCont.append(nameNewChat, messageNewChat);
    newChata.append(imgNewChat, infoCont);
    newChat.setAttribute('data-chat-id', data.conversation_id);

    const deleteChatButton = document.createElement('button');
    deleteChatButton.innerHTML = '<i class="bi bi-trash3"></i>';
    deleteChatButton.type = 'button';
    deleteChatButton.classList = 'delete-chat-button';

    deleteChatButton.addEventListener('click', () => {
        if (confirm('Чат будет удален для всех')) {
            socket.send(JSON.stringify({
                action: 'delete_chat_everyone',
                conversation_id: data.conversation_id
            }));
        }
    });
    newChat.append(newChata, deleteChatButton, unreadSpan);
    newChat.setAttribute('data-participant-id', data.other_participant_id);
    chatList.prepend(newChat);
}

function updateUnreadCount(chatElement, count) {
    let unreadSpan = chatElement.querySelector('.unread-count');
    if (!unreadSpan) {
        unreadSpan = document.createElement('span');
        unreadSpan.classList.add('unread-count');
        chatElement.appendChild(unreadSpan);
    }
    if (count > 0) {
        unreadSpan.textContent = `${count}`;
        unreadSpan.style.display = 'inline-block';
    } else {
        unreadSpan.style.display = 'none';
    }

    chatElement.setAttribute('data-unread-count', count);

}