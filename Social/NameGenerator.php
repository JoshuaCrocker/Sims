<?php
class NameGenerator {
    const API_URL = 'https://randomuser.me/api/?nat=gb';

    private $seed;

    private $gender;
    private $firstName;
    private $lastName;

    public function __construct($seed = null) {
        $this->seed = is_null($seed) ? sha1(time()) : $seed;
        $this->regenerate();
    }

    public function getGender() {
        return $this->gender;
    }

    public function getFullName() {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getlastName() {
        return $this->lastName;
    }

    public function regenerate() {
        $json = file_get_contents(NameGenerator::API_URL.'?seed' . $this->seed);
        $json = json_decode($json);

        $this->gender = $json->results[0]->gender == 'male' ? Person::GENDER_MALE : Person::GENDER_FEMALE;
        $this->firstName = ucfirst($json->results[0]->name->first);
        $this->lastName = ucfirst($json->results[0]->name->last);
    }

    public function setSeed($seed) {
        $this->seed = $seed;
    }

    public function getSeed($seed) {
        return $this->seed;
    }
}
