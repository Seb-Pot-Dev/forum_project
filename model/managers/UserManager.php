<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Controller\ForumController;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }


    }
    ?>