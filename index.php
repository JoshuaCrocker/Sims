<?php
/**
  * Sims index.php
  *
  * Sims is a population model creating using PHP. This is the entry file
  * for the simulation.
  *
  *
  * @author   Joshua Crocker
  * @version  1.0.0
  */  
  
require 'loader.php';

// Create Database Connection
$Database = new Database('database.ini');


Output::getInstance()->log("Welcome to the Sim.");

// Create RandomActionAgent
$agent = new RandomActionAgent();

// Create new Population
// And load existing members from the database
$population = new Population();
$population->load($Database);

// Assign the Tick Agent to the Population
$population->assignPopulationTickAgent($agent);

// Execute the next tick
$population->tick();

// Save the Population state
$population->save($Database);

Output::getInstance()->getOutput();