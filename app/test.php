<?php
require_once 'Database.php';
$db = Database::getInstance();
$connection = $db->getConnection();

abstract class User
{

    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $profilePhoto;
    protected $salutation;

    public function __construct($id, $firstName, $lastName, $email, $profilePhoto = null, $salutation = null)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->profilePhoto = $profilePhoto;
        $this->salutation = $salutation;
    }

    public function getFullName()
    {
        return ($this->salutation ? $this->salutation . ' ' : '') . $this->firstName . ' ' . $this->lastName;
    }
    public function getProfilePhoto()
    {
        return $this->profilePhoto ? $this->profilePhoto : 'path/to/default/system/avatar';
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->id;
    }
    public function save()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL) || (strpos($this->profilePhoto, '.jpg') === false)) {
            return false;
        }
        $db = Database::getInstance();
        $connection = $db->getConnection();

        // Check if the user already exists (by ID)
        $stmt = $connection->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Update the existing user
            $stmt = $connection->prepare("UPDATE users SET first_name = :firstName, last_name = :lastName, email = :email, profile_photo = :profilePhoto, salutation = :salutation WHERE id = :id");
        } else {
            // Insert a new user
            $stmt = $connection->prepare("INSERT INTO users (id, first_name, last_name, email, profile_photo, salutation) VALUES (:id, :firstName, :lastName, :email, :profilePhoto, :salutation)");
        }

        // Bind parameters and execute the statement
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':profilePhoto', $this->profilePhoto);
        $stmt->bindParam(':salutation', $this->salutation);

        return $stmt->execute();
    }
    abstract public function canSendMessageTo(User $receiver): bool;
}

class Student extends User
{
    public function canSendMessageTo(User $receiver): bool
    {
        return $receiver instanceof Teacher;
    }
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
class Teacher extends User
{

    public function canSendMessageTo(User $receiver): bool
    {
        return true;
    }
    public function getFullName()
    {
        return ($this->salutation ? $this->salutation . ' ' : '') . $this->firstName . ' ' . $this->lastName;
    }
}
class Parent1 extends User
{
    public function canSendMessageTo(User $receiver): bool
    {
        return $receiver instanceof Teacher;
    }
    public function getFullName()
    {
        return ($this->salutation ? $this->salutation . ' ' : '') . $this->firstName . ' ' . $this->lastName;
    }
}

class Message
{
    private $sender;
    private $receiver;
    private $text;
    private $creationTime;
    private $type;

    public function __construct($sender, $receiver, $text, $type)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->text = $text;
        $this->creationTime = time();
        $this->type = $type;
    }
    public function getSenderFullName()
    {
        return $this->sender->getFullName();
    }

    public function getReceiverFullName()
    {
        return $this->receiver->getFullName();
    }

    public function getText()
    {
        return $this->text;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getFormattedCreationTime()
    {
        $unxDate = strtotime($this->creationTime);

        return date('M d, Y',  $unxDate);
    }

    public function save()
    {
        if (!($this->sender instanceof Teacher && $this->type == 'System') && !($this->sender instanceof Parent1 || $this->sender instanceof Student)) {
            return false;
        }
        $db = Database::getInstance();
        $connection = $db->getConnection();

        // Insert a new message
        $stmt = $connection->prepare("INSERT INTO messages (sender_id, receiver_id, text, creation_time, type) VALUES (:senderId, :receiverId, :text, :creationTime, :type)");

        // Bind parameters and execute the statement
        $senderId = $this->sender->getId();
        $receiverId = $this->receiver->getId();
        $stmt->bindParam(':senderId', $senderId);
        $stmt->bindParam(':receiverId', $receiverId);
        $stmt->bindParam(':text', $this->text);
        $stmt->bindParam(':creationTime', $this->creationTime);
        $stmt->bindParam(':type', $this->type);

        return $stmt->execute();
    }
}
