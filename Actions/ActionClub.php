<?php
class ActionClub extends Action {
    protected $name = 'Club';
    protected $acts_on = Person::STAT_GENERIC;
    protected $action_points = -20;
}
