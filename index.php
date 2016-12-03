<?php
require 'System/Database.php';
require 'System/UUID.php';
require 'Social/Person.php';
require 'Social/Population.php';
require 'Actions/Action.php';
require 'Actions/ActionChat.php';
require 'Actions/ActionClub.php';
require 'Actions/ActionHeal.php';
require 'Actions/ActionHit.php';
require 'TickAgents/PopulationTickAgent.php';
require 'TickAgents/RandomActionAgent.php';

function output($string = '') {
    print $string . "\n";
}

$Database = new Database('database.ini');

output("Welcome to the Sim.");
output();

$agent = new RandomActionAgent();

// $person_jc = new Person('Joshua Crocker', Person::GENDER_MALE);
// $person_mp = new Person('Megan Pendry', Person::GENDER_FEMALE);
// $person_dc = new Person('Dawn Cross', Person::GENDER_FEMALE);
// $person_jm = new Person('Jake Mason', Person::GENDER_MALE);
// $person_el = new Person('Ella Love', Person::GENDER_FEMALE);
// $person_om = new Person('Oliver Mockridge', Person::GENDER_MALE);
// $person_oh = new Person('Olive Holliday', Person::GENDER_FEMALE);

$population = new Population();
$population->load($Database);

$population->assignPopulationTickAgent($agent);

// $population->addMember($person_jc);
// $population->addMember($person_mp);
// $population->addMember($person_dc);
// $population->addMember($person_jm);
// $population->addMember($person_el);
// $population->addMember($person_om);
// $population->addMember($person_oh);

// $chat = new ActionChat();
// $hit = new ActionHit();
//
// $person_jc->act($chat, $person_mp);
// $person_mp->act($hit, $person_jc);

// for($i = 0; $i < 10; $i++) {
//     output();
//     output('Tick ' . ($i+1));
$population->tick();
// }

$population->save($Database);
