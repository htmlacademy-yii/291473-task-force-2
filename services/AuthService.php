<?php

namespace app\services;

use app\models\Auth;

class AuthService
{
    public function findAuthUser(string $source, string $sourceId): ?Auth
    {
        return Auth::findOne(['source' => $source, 'source_id' => $sourceId]); // Ищем пользователя по id пользователя и id клиента = 'vkontakte';
    }
}
