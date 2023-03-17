<?php

    namespace Model\Entities;

    use App\Entity;

    final class Topic extends Entity{

        private $id;
        private $topicName;
        private $topicDate;
        private $locked;
        private $user;
        private $category;

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         */ 
        public function setId($id)
        {
                $this->id = $id;

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

        public function getTopicDate(){
            $formattedDate = $this->topicDate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setTopicDate($date){
            $this->topicDate = new \DateTime($date);
            return $this;
        }

        /**
         * Get the value of Locked
         */ 
        public function getLocked()
        {
                return $this->locked;
        }

        /**
         * Set the value of Locked
         */ 
        public function setLocked($locked)
        {
                $this->locked = $locked;

                return $this;
        }
        /**
         * Get the value of TopicName
         */ 
        public function getTopicName()
        {
                return $this->topicName;
        }

        /**
         * Set the value of TopicName
         */ 
        public function setTopicName($topicName)
        {
                $this->topicName = $topicName;

                return $this;
        }
        /**
         * Get the value of category
         */ 
        public function getCategory()
        {
                return $this->category;
        }

        /**
         * Set the value of category
         */ 
        public function setCategory($category)
        {
                $this->category = $category;

                return $this;
        }

    }
?>