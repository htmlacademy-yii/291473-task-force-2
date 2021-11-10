<?php

namespace TaskForce\tasks;

class RespondAction extends Action 
{
    public function check_user_rights() 
    {
        return $this->user_id === $this->$executor_id;
    }

    public function get_action_name() 
    {
        return 'Добавление отклика';
    }

    public function get_action_code() 
    {
        return 'ACTION_RESPOND';
    }
}