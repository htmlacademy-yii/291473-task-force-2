<?php

namespace TaskForce\tasks;

class RefuseAction extends AbstractAction 
{
    public function check_user_rights() 
    {
        return $this->user_id === $this->customer_id;
    }

    public function get_action_name() 
    {
        return 'Отмена задания';
    }

    public function get_action_code() 
    {
        return 'ACTION_REFUSED';
    }
}