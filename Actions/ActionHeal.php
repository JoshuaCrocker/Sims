<?php
class ActionHeal extends Action {
    protected $name = 'Heal';
    protected $acts_on = Person::STAT_GENERIC;
    protected $action_points = 50;
}
