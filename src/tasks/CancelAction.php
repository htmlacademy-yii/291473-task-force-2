<?php

namespace TaskForce\tasks;

class CancelAction extends AbstractAction
{
    /**
     * @return string
     */
    public function get_action_code(): string
    {
        return 'ACTION_CANCELED';
    }
}
