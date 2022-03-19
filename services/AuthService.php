<?php

namespace app\services;

use app\models\Auth;

class AuthService
{
    public function findAuthUser(string $source, string $sourceId): ?Auth
    {
        return Auth::findOne(['source' => $source, 'source_id' => $sourceId]); // Ищем пользователя по id пользователя и id клиента = 'vkontakte';
    }

    public function saveAuthUser(int $userId, string $source, string $sourceId): bool
    {
        $auth = new Auth();

        $auth->user_id = $userId;
        $auth->source = $source;
        $auth->source_id = $sourceId;

        return $auth->save();
    }
}
