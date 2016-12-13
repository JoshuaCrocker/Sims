<?php

/**
  * Population Class
  *
  * @author   Joshua Crocker
  * @category Action
  * @version  1.0.0
  */
class Population {
    
    /**
     * Population Members
     * 
     * (default value: [])
     * 
     * @var array
     * @access private
     */
    private $members = [];
    
    /**
     * Population Tick Agent
     * 
     * (default value: null)
     * 
     * @var PopulationTickAgent
     * @access private
     */
    private $population_tick_agent = null;

    /**
     * Add Member Method
     * 
     * @access public
     * @param Person $person The Person to add to the Population
     * @return void
     */
    public function addMember(Person $person) {
        // output('Adding ' . $person->getName() . ' to the population.');
        Output::getInstance()->addOutput('Adding ' . $person->getName() . ' to the population.');
        $this->members[] = $person;
    }

    /**
     * Assign Population Tick Agent Method
     * 
     * @access public
     * @param PopulationTickAgent $agent The TickAgent
     * @return void
     */
    public function assignPopulationTickAgent(PopulationTickAgent $agent) {
        $this->population_tick_agent = $agent;
    }

    /**
     * Tick Method
     *
     * Execute the next cycle of the simulation.
     * 
     * @access public
     * @return void
     */
    public function tick() {
        $this->population_tick_agent->tick($this->members);
    }


    /**
     * Save Method
     * 
     * @access public
     * @param Database $db The Database Connection
     * @return void
     */
    public function save(Database $db) {
        foreach ($this->members as $member) {
            $member->save($db);
        }
    }

    /**
     * Load Method
     * 
     * @access public
     * @param Database $db The Database Connection
     * @return void
     */
    public function load(Database $db) {
        $people = $db->query('SELECT * FROM people;');

        while ($person = $people->fetch()) {
            $this->addMember(Person::load($person['id'], $person['data']));
        }
    }

    /**
     * Get Members Method
     * 
     * @access public
     * @return void
     */
    public function getMembers() {
        return $this->members;
    }
}
