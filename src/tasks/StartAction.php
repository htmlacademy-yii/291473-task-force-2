<?php

namespace TaskForce\tasks;

class StartAction extends Action 
{
    public function check_user_rights() 
    {
        return $this->user_id === $this->$executor_id;
    }

    public function get_action_name() 
    {
        return 'Старт задания';
    }

    public function get_action_code() 
    {
        return 'ACTION_START';
    }
}