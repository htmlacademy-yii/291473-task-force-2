<?php

namespace TaskForce\tasks;

class StartAction extends AbstractAction
{
    /**
     * @return string
     */
    public function get_action_code(): string
    {
        return 'ACTION_START';
    }
}
