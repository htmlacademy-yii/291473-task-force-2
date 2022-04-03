<?php

namespace TaskForce\tasks;

class FinishAction extends AbstractAction
{
    /**
     * @return string
     */
    public function get_action_code(): string
    {
        return 'ACTION_FINISHED';
    }
}
