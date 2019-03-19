<?php
namespace App\Model;
class Email implements \JsonSerializable
{  
    private $name;
    private $firstName;
    private $email;
    private $phone;
    private $message;
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $name
     * @return email
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstname;
    }
    /**
     * @param mixed $firstName
     * @return email
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }
   /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param mixed $email
     * @return email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
/**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * @param mixed $phone
     * @return email
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
/**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * @param mixed $message
     * @return email
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [           
            'name' => $this->name,
            'firstname' => $this->firstName,
            'email'=>$this->$email,
            'phone'=>$this->$phone,
            'message'=>$this->$message             
              ];
    }
}
