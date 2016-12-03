<?php
class ActionHit extends Action {
    protected $name = 'Hit';
    protected $acts_on = Person::STAT_GENERIC;
    protected $action_points = -2;
}
