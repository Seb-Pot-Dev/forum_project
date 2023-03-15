<?php

    namespace Model\Entities;

    use App\Entity;

final class User extends Entity
{

    private $nickName;
    private $email;
    private $password;
    private $registrationDate;
    private $user;

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    /**
     * Get the value of nickName
     */ 
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * Set the value of nickName
     */ 
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of registrationDate
     */ 
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set the value of registrationDate
     */ 
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
?>