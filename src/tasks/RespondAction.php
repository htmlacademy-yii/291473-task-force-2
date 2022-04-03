<?php

namespace TaskForce\tasks;

class RespondAction extends AbstractAction
{
    /**
     * @return string
     */
    public function get_action_code(): string
    {
        return 'ACTION_RESPOND';
    }
}
