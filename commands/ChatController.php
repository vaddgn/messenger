<?php
namespace app\commands;

use Ratchet\App;
use yii\console\Controller;
use app\components\ChatServer;

class ChatController extends Controller
{
    public function actionRun()
    {
        $this->stdout("Запуск WebSocket сервера...\n");
        $this->stdout("Сервер доступен на ws://localhost:8080\n");
        $app = new App('localhost', 8080);
        $app->route('/chat', new ChatServer, ['*']);
        $app->run();
    }
}
