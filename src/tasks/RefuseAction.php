<?php

namespace TaskForce\tasks;

class RefuseAction extends AbstractAction
{
    /**
     * @return string
     */
    public function get_action_code(): string
    {
        return 'ACTION_REFUSED';
    }
}
