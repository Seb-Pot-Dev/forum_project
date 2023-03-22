<?php
// Le dossier "controller" contient les dossiers qui vont être appelés par l'utilisateur dans notre URL.
    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\UserManager;
    use Model\Managers\Manager;
    
    class SecurityController extends AbstractController implements ControllerInterface{

        public function index(){
          

           $userManager = new UserManager();

            return [
                "view" => VIEW_DIR."security/register.php",
                "data" => [
                    "users" => $userManager->findAll(["registrationDate", "DESC"])
                ]
            ];
        
        }
        public function register(){

            $userManager = new UserManager();

            if(isset($_POST["submit"])){
                if(isset($_POST["nickName"]) 
                && isset($_POST["password"]) 
                && isset($_POST["passwordConfirm"]) 
                && isset($_POST["email"])){
                    
                    $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $passwordConfirm = filter_input(INPUT_POST, "passwordConfirm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $userList = $userManager->findAll(["nickName", "DESC"]);

                foreach($userList as $user){
                    if($user->getNickname()==$nickName){
                        $nickName=NULL;
                    break;
                    }
                }
                    if($password == $passwordConfirm){
                        if($password && $email && $nickName){
                        //On hash le mot de passe
                        $password=password_hash($password, PASSWORD_DEFAULT);

                        //On ajoute l'utilisateur en BDD
                        $userManager->add(["nickName" => $nickName, "password" => $password, "email" => $email]);
                        
                        $this->redirectTo('security', 'index');
                        }
                        else{
                            return [
                                "view" => VIEW_DIR."security/register.php",
                                "data" => [
                                    "error" => "Nickname already exists!"
                                    ]
                                ];
                            
                        }
                    }
                    else{
                        return [
                            "view" => VIEW_DIR."security/register.php",
                            "data" => ["error" => "Passwords don't match"
                            ]
                        ];
                        
                    }
                }
            }        
        }
        public function login(){
            $userManager = new UserManager();

            if(isset($_POST["submit"])){
                if(isset($_POST["email"]) && isset($_POST["password"])){
                    
                    $email = $_POST["email"];
                    $password = $_POST["password"];

                    
        
                }}}
    }