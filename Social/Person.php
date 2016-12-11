<?php
class Person {
    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;

    const STAT_GENERIC = 0;

    const STAT_MAX = 100;

    private $id;
    private $name;
    private $gender;

    private $stats = [];

    private $relationships = [];

    // TODO relationships

    public function __construct($name, $gender, $id = null) {
        if ($gender != self::GENDER_MALE && $gender != self::GENDER_FEMALE) {
            $gender = self::GENDER_MALE;
        }

        $this->id = $id == null ? UUID::v4() : $id;
        $this->name = $name;
        $this->gender = $gender;

        $this->stats[Person::STAT_GENERIC] = Person::STAT_MAX / 2;
    }

    public function act($action, $to) {
        $action->act($this, $to);
    }

    public function save(Database $db) {
        // Check for UUID
        $uuid_check = $db->prepare('SELECT * FROM people WHERE id=:id');
        $uuid_check->bindParam('id', $this->id);
        $uuid_check->execute();

        if ($uuid_check->rowCount()) {
            // UPDATE
            $json = $this->toJSON();

            $update = $db->prepare('UPDATE people SET data=:json WHERE id=:id');
            $update->bindParam('id', $this->id);
            $update->bindParam('json', $json);
            $update->execute();
        } else {
            // INSERT
            $json = $this->toJSON();

            $insert = $db->prepare('INSERT INTO people VALUES(:id, :json);');
            $insert->bindParam('id', $this->id);
            $insert->bindParam('json', $json);
            $insert->execute();
        }
    }

    public static function load($id, $data) {
        $data = json_decode($data);

        $person = new Person($data->name, $data->gender, $id);

        foreach ($data->stats as $stat => $value) {
            $person->setStat($stat, $value);
        }

        foreach ($data->relationships as $id => $value) {
            $person->setRelationship($id, $value);
        }

        return $person;
    }

    public static function create($seed = null) {
        $generator = new NameGenerator($seed);
        $person = new Person($generator->getFullName(), $generator->getGender());
        return $person;
    }

    public function toJSON() {
        return json_encode([
            'name' => $this->name,
            'gender' => $this->gender,
            'stats' => $this->stats,
            'relationships' => $this->relationships,
        ]);
    }

    // Getters
    public function getID() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getStat($stat) {
        return $this->stats[$stat];
    }

    public function getRelationship($id) {
        if (!isset($this->relationships[$id])) $this->relationships[$id] = 50;
        return $this->relationships[$id];
    }


    // Setters
    public function setName($name) {
        $this->name = $name;
    }

    public function setGender($gender) {
        if ($gender != self::GENDER_MALE && $gender != self::GENDER_FEMALE) {
            $gender = self::GENDER_MALE;
        }

        $this->gender = $gender;
    }

    public function setStat($stat, $value) {
        $this->stats[$stat] = $value;
    }

    public function setRelationship($id, $value) {
        $this->relationships[$id] = $value;
    }
}
