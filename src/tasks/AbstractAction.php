<?php

namespace TaskForce\tasks;

abstract class AbstractAction
{
    /**
     * @param int $customer_id
     * @param int $executor_id
     * @param int $user_id
     */
    public function __construct(int $customer_id, int $executor_id = null, int $user_id)
    {
        $this->customer_id = $customer_id;
        $this->executor_id = $executor_id;
        $this->user_id = $user_id;
    }

    abstract protected function get_action_code();
}
