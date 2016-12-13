<?php
    
/**
 * Person Class
 *
 * @author     Joshua Crocker
 * @category   Social
 * @version    1.0.0
 */
class Person {
    
    /**
     * @const Male Constant
     */
    const GENDER_MALE = 0;
    
    /**
     * @const Female Constant
     */
    const GENDER_FEMALE = 1;

    /**
     * @const Generic Stat Constant
     */
    const STAT_GENERIC = 0;
    
    /**
     * @const Maximum Statistic Value
     */
    const STAT_MAX = 100;
    
    /**
     * @var string UUID Person Identifier
     * @access private
     */
    private $id;
    
    /**
     * @var string The name of the person
     * @access private
     */
    private $name;
    
    /**
     * @var integer The gender of the person
     * @access private
     */
    private $gender;
    
    /**
     * @var array The Person's stats
     * @access private
     */
    private $stats = [];
    
    /**
     * @var array The Person's relationships
     * @access private
     */
    private $relationships = [];
    
    /**
     * Person Constructor
     *
     * Set up the Person instance.
     *
     * @access public  
     * @param string $name The name of the person
     * @param integer $gender The gender of the person
     * @param null|string $id The ID of the user
     */
    public function __construct($name, $gender, $id = null) {
        // Check the gender is valid
        if ($gender != self::GENDER_MALE && $gender != self::GENDER_FEMALE) {
            $gender = self::GENDER_MALE;
        }

        $this->id = $id == null ? UUID::v4() : $id;
        $this->name = $name;
        $this->gender = $gender;

        $this->stats[Person::STAT_GENERIC] = Person::STAT_MAX / 2;
    }

    /**
     * Act Method
     *
     * Perform an action, `$action`, on another Person, `$to`.
     *
     * @param Action $action The action to perform
     * @param Person $to The person to act upon
     * @return void
     */
    public function act($action, $to) {
        $action->act($this, $to);
    }
    
    /**
     * Save Method
     *
     * Saves the state of the person instance within the database
     * 
     * @access public
     * @param Database $db The Database Connection
     * @return void
     */
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

    /**
     * Load Method
     * 
     * @access public
     * @static
     * @param mixed $id The ID of the Person
     * @param mixed $data The data about the Person
     * @return Person
     */
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
    
    /**
     * Create Method
     *
     * Create a new Person instance.
     * 
     * @access public
     * @static
     * @param string $seed (default: null)
     * @return Person
     */
    public static function create($seed = null) {
        $generator = new NameGenerator($seed);
        $person = new Person($generator->getFullName(), $generator->getGender());
        return $person;
    }
    
    /**
     * toJSON Method
     * 
     * @access public
     * @return string
     */
    public function toJSON() {
        return json_encode([
            'name' => $this->name,
            'gender' => $this->gender,
            'stats' => $this->stats,
            'relationships' => $this->relationships,
        ]);
    }

    /**
     * Get ID Method
     * 
     * @access public
     * @return string
     */
    public function getID() {
        return $this->id;
    }

    /**
     * Get Name Method
     * 
     * @access public
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get Gender Method
     * 
     * @access public
     * @return integer
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * Get Stat Method
     *
     * Get the value of a person's stat
     * 
     * @access public
     * @param integer $stat The stat to retrieve
     * @return float
     */
    public function getStat($stat) {
        return $this->stats[$stat];
    }

    /**
     * Get Relationship Method
     *
     * Get the value of relationship between two people
     * 
     * @access public
     * @param string $id The ID of the other Person
     * @return float
     */
    public function getRelationship($id) {
        if (!isset($this->relationships[$id])) {
            $this->relationships[$id] = 50;
        }
        return $this->relationships[$id];
    }

    /**
     * Set Name Method
     * 
     * @access public
     * @param string $name The new name
     * @return void
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Set Gender Method
     * 
     * @access public
     * @param mixed $gender The new gender
     * @return void
     */
    public function setGender($gender) {
        // Check gender is valid
        if ($gender != self::GENDER_MALE && $gender != self::GENDER_FEMALE) {
            $gender = self::GENDER_MALE;
        }
        
        $this->gender = $gender;
    }
    
    /**
     * Set Stat Method
     * 
     * @access public
     * @param mixed $stat The stat to change
     * @param mixed $value The value to set
     * @return void
     */
    public function setStat($stat, $value) {
        $this->stats[$stat] = $value;
    }

    /**
     * Set Relationship Method
     * 
     * @access public
     * @param mixed $id The ID of the Person
     * @param mixed $value The value to set
     * @return void
     */
    public function setRelationship($id, $value) {
        $this->relationships[$id] = $value;
    }
}
