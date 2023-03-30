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

class SecurityController extends AbstractController implements ControllerInterface
{

    public function index()
    {


        $userManager = new UserManager();

        return [
            "view" => VIEW_DIR . "security/register.php",
            "data" => [
                "users" => $userManager->findAll(["registrationDate", "DESC"])
            ]
        ];
    }
    public function linkToLogin()
    {


        $userManager = new UserManager();

        return [
            "view" => VIEW_DIR . "security/login.php",
            "data" => [
                "users" => $userManager->findAll(["registrationDate", "DESC"])
            ]
        ];
    }
    
    public function register()
    {
        // si $_POST["submit"] est défini
        if (isset($_POST["submit"])) {
            //On initialise un nouveau $userManager
            $userManager = new UserManager();
            // si chaques $_POST["..."] sont définis
            if (
                isset($_POST["nickName"])
                && isset($_POST["password"])
                && isset($_POST["passwordConfirm"])
                && isset($_POST["email"])
            ) {

                // on filtre les $_POST 
                $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $passwordConfirm = filter_input(INPUT_POST, "passwordConfirm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            
                /*
                Vérifie si le $email fourni ET le $nickName fourni existent déjà. 
                S'il n'existe pas encore, renvoie FALSE
                */

                //Si il existe pas encore, on va crééer un nouveau user
                if(($userManager->findOneByEmail($email)===false)
                && ($userManager->findOneByNickname($nickName)===false)
                ) {
                    // ---- si les MDP et MDPconfirm correspondent ---
                    if ($password == $passwordConfirm) {
                        //On hash le mot de passe
                        $password = password_hash($password, PASSWORD_DEFAULT);

                        //alors ON AJOUTE ENFIN L'UTILISATEUR EN BDD.
                        $userManager->add(["nickName" => $nickName, "password" => $password, "email" => $email]);//le rôle est défini par défaut en "normal" et ban en "0"
                        //ET on REDIRIGE vers le lien défini dans l'INDEX
                        return [
                            "view" => VIEW_DIR . "security/register.php",
                            "data" => [
                                "success" => "Inscription réussi"
                            ]
                        ];
                    }
                    // ---- autrement, c'est que les MDP et MDPconfirm NE correspondent PAS  ---
                    else {
                        return [
                            "view" => VIEW_DIR . "security/register.php",
                            "data" => [
                                "error" => "Les mots de passes ne correspondent pas."
                            ]
                        ];
                    }
                }
                    //Si l'$email existe déjà mais que le $nickName n'existe pas encore
                elseif(($userManager->findOneByEmail($email)===true)
                && ($userManager->findOneByNickname($nickName)===false)
                ){
                    return [
                        "view" => VIEW_DIR . "security/register.php",
                        "data" => [
                            "error" => "Le mail utilisé correspond a un compte existant "
                        ]
                    ];
                }
                    //Si l'$nickName existe déjà mais que le $email n'existe pas encore
                elseif(($userManager->findOneByEmail($email)===false)
                && ($userManager->findOneByNickname($nickName)===true)
                ){
                    return [
                        "view" => VIEW_DIR . "security/register.php",
                        "data" => [
                            "error" => "Le pseudo existe déjà "
                        ]
                    ];
                }
                elseif(($userManager->findOneByEmail($email)===true)
                && ($userManager->findOneByNickname($nickName)===true)
                ){
                    return [
                        "view" => VIEW_DIR . "security/register.php",
                        "data" => [
                            "error" => "Le pseudo ET l'email sont déjà utilisés par un utilisateur"
                        ]
                    ];
                }
            }
        }   
        //Sinon, retourne la view du register.php
        else{
            return [
                "view" => VIEW_DIR. "security/register.php",
            ];
        }   
    }

    public function login(){
        $userManager = new UserManager();
        //Si $_POST["submit"] est défini 
        if (isset($_POST["submit"])) {
            //Si chaques $_POST["..."] sont définis
            if (isset($_POST["email"]) && isset($_POST["password"])) {
                //On filtres les $_POST et les associes a des variables
                $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);            

                //définition du $user par son email
                $user = $userManager->findOneByEmail($email);

                    //Si l'email n'existe pas en base de donnée
                    if((!$user)===true){
                        return [
                            "view" => VIEW_DIR . "security/login.php",
                            "data" => [
                                "error" => "L'email fourni ne correspond à aucuns utilisateurs" //msg d'erreur
                            ]
                        ];
                    }
                    //Sinon (si l'email existe)
                    else{
                        //Si l'utilisateur n'est pas banni
                        if ($user->getBan()==0) {
                            //$hash=$password haché présent en bdd
                            $hash=$userManager->findOneByEmail($email)->getPassword();

                            //Si le $password correspond au $password haché correspondant au $email en bdd
                            if ((password_verify($password, $hash))) {
                                //placer l'utilisateur en session
                                Session::setUser($user);

                                //redirige vers l'index
                                $this->redirectTo('category', 'index');
                            }
                            //Sinon (si le $password ne correspond pas au $email)
                            elseif ((password_verify($password, $hash))===false) {
                                return [
                                    "view" => VIEW_DIR . "security/login.php",
                                    "data" => [
                                        "error" => "Le mot de passe ne correspond pas a l'email renseigné" //msg d'echec
                                    ]
                                ];
                            }
                        }
                        else{
                            return [
                                "view" => VIEW_DIR . "security/login.php",
                                "data" => [
                                    "banned" => "Votre compte a été banni. Veuillez contacter un administrateur pour toutes réclamations."
                                ]
                            ];
                        }
                        }
                    }
            
            
        }
    
        //Sinon renvoie la view login.php
        else{
            return [
            "view" => VIEW_DIR. "security/login.php"
            ];
        }
    }

    // -- Pour voir les infos du profile d'utilisateur en session
    public function viewProfile(){
        //Si un utilisateur est renseigné en session
        if($_SESSION["user"]){
            //retourne la vue correspondante et renseigne le champs "user" avec les infos du user en session
            return [
                "view" => VIEW_DIR. "security/viewProfile.php",
                "data" => [
                    "user" => $_SESSION["user"]
                ]
            ];
        }
    }
    public function viewOtherUserProfile($id){
        $userManager = new UserManager;
            //retourne la vue correspondante et renseigne le champs "user" avec les infos du user en session
            return [
                "view" => VIEW_DIR. "security/viewOtherUserProfile.php",
                "data" => [
                    "user" => $userManager->findOneById($id)
                ]
            ];
        
    }
    // -- pour se déconnecter
    public function logout(){
        //Si un utilisateur est renseigné en session
        if($_SESSION["user"]){
            //détruit tout donnée associées a la variable $session
            session_destroy();
            //redirige vers l'index du user
            $this->redirectTo('user', 'index');
        }
    }
    public function banUser($id){
        $userManager = new UserManager;
        //récupération du Nickname du user
        $userNickname = $userManager->findOneById($id)->getNickname();
        //utilisation de la fonction pour ban en fonction de l'ID
        $userManager->banUserById($id);

         ["data" => ["banSuccess" => "L'utilisateur".$userNickname."a été banni"]];
        $this->redirectTo('security', 'viewOtherUserProfile', $id);
    }
    public function unbanUser($id){
        $userManager = new UserManager;
        //récupération du Nickname du user
        $userNickname = $userManager->findOneById($id)->getNickname();
        //utilisation de la fonction pour ban en fonction de l'ID
        $userManager->unbanUserById($id);

        ["data" => ["banSuccess" => "L'utilisateur".$userNickname."a été débanni"]];
        $this->redirectTo('security', 'viewOtherUserProfile', $id);

    }
}
