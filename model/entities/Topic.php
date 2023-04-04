<?php

    namespace Model\Entities;

    use App\Entity;
use DateTime;

    final class Topic extends Entity{

        private $id;
        private $topicName;
        private $topicDate;
        private $locked;
        private $user;
        private $category;
        private $lastPostDate;
        private $countPost;
        private $formattedTopicDate;

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


        /**
         * Get the value of lastPostDate
         */ 
        public function getLastPostDate()
        {
                return $this->lastPostDate;
        }

        /**
         * Set the value of lastPostDate
         *
         * @return  self
         */ 
        public function setLastPostDate($lastPostDate)
        {
                $this->lastPostDate = $lastPostDate;

                return $this;
        }

        /**
         * Get the value of countPost
         */ 
        public function getCountPost()
        {
                return $this->countPost;
        }

        /**
         * Set the value of countPost
         *
         * @return  self
         */ 
        public function setCountPost($countPost)
        {
                $this->countPost = $countPost;

                return $this;
        }

        /**
         * Get the value of formattedTopicDate
         */ 
        public function getFormattedTopicDate()
        {
                // setlocale(LC_TIME, 'fr_FR.UTF-8');
                // $date=$this->formattedTopicDate;
                // $date_objet = DateTime::createFromFormat('d/m/Y H:i', $date); // créé un objet DateTime
                
                // $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
                // $formatter->setPattern('EEEE d MMMM y HH:mm'); // définit le format de date souhaité
                // $date_formatee = $formatter->format($date_objet); // formate la date
                // return $date_formatee;
                return $this->formattedTopicDate;
        }

        /**
         * Set the value of formattedTopicDate
         *
         * @return  self
         */ 
        public function setFormattedTopicDate($formattedTopicDate)
        {
                $this->formattedTopicDate = $formattedTopicDate;

                return $this;
        }
    }
?>