<?php
class ActionChat extends Action {
    protected $name = 'Chat';
    protected $acts_on = Person::STAT_GENERIC;
    protected $action_points = 2;
}
