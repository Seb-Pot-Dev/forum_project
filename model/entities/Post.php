<?php 

    namespace Model\Entities;

    use App\Entity;

final class Post extends Entity
{

    private $id;
    private $postDate;
    private $text;
    private $user;
    private $topic;

    public function __construct($data)
    {
        $this->hydrate($data);
    }


    public function getId()
    {
            return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
            $this->id = $id;

            return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getPostDate($postDate)
    {
            return $this->postDate;
    }
    /**
     * Get the value of text
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setText($text)
    {
            $this->text = $text;

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
     *
     * @return  self
     */ 
    public function setUser($user)
    {
            $this->user = $user;

            return $this;
    }

}
?>