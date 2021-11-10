<?php

namespace TaskForce\tasks;

class FinishAction extends AbstractAction 
{
    public function check_user_rights($customer_id, $executor_id, $user_id) 
    {
        return $this->$user_id === $this->$customer_id;
    }

    public function get_action_name() 
    {
        return 'Завершение задания';
    }

    public function get_action_code() 
    {
        return 'ACTION_FINISHED';
    }
}