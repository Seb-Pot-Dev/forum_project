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
    
    public function registerOld()
    {

        $userManager = new UserManager();

        // si $_POST["submit"] est défini
        if (isset($_POST["submit"])) {
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

                /* On défini la var $userList comme étant égale
                        a la list de tout les nickName d'utilisateur */
                $userList = $userManager->findAll(["nickName", "DESC"]);

                // on boucle sur tout les nickName d'utilisateur et...
                foreach ($userList as $user) {
                    //... si le $_POST["nickName"] est equivalent a un des nickname (existe déjà)...
                    if ($user->getNickname() == $nickName) {
                        //... alors on dit $nickName = NULL pour bloquer les prochaines étapes
                        $nickName = NULL;
                        break;
                    }
                }
                // ---- si les MDP et MDPconfirm correspondent ---
                if ($password == $passwordConfirm) {

                    /* et SI les $password, $email et $nickName sont DEFINIS 
                    et que le nickName n'est pas NULL.*/
                    if ($password && $email && ($nickName != NULL)) {
                        //On hash le mot de passe
                        $password = password_hash($password, PASSWORD_DEFAULT);

                        //alors ON AJOUTE ENFIN L'UTILISATEUR EN BDD.
                        $userManager->add(["nickName" => $nickName, "password" => $password, "email" => $email]);

                        //ET on REDIRIGE vers le lien défini dans l'INDEX
                        $this->redirectTo('security', 'index');
                    }

                    /*AUTREMENT, le nickName est NULL, car existe déjà 
                    alors on return la view du register et le message d'erreur correspondant*/ 
                    else {
                        return [
                            "view" => VIEW_DIR . "security/register.php",
                            "data" => [
                                "error" => "Le pseudo existe déjà "
                            ]
                        ];
                    }
                }
                // ---- autrement, les MDP et MDPconfirm NE correspondent PAS  ----
                else {
                    return [
                        "view" => VIEW_DIR . "security/register.php",
                        "data" => [
                            "error" => "Les mots de passes ne correspondent pas."
                        ]
                    ];
                }
            }
        }
    }
    public function register()
    {
        $userManager = new UserManager();

        // si $_POST["submit"] est défini
        if (isset($_POST["submit"])) {
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
                Si il existe déjà, (!$userManager->findOneByEmail($email) renvoie FALSE
                S'il n'existe pas encore, renvoie TRUE
                */
                if((!$userManager->findOneByEmail($email))===true
                && (!$userManager->findOneByNickname($nickName)===true)
                ) {
                    // ---- si les MDP et MDPconfirm correspondent ---
                    if ($password == $passwordConfirm) {
                        //On hash le mot de passe
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        //alors ON AJOUTE ENFIN L'UTILISATEUR EN BDD.
                        $userManager->add(["nickName" => $nickName, "password" => $password, "email" => $email]);
                        //ET on REDIRIGE vers le lien défini dans l'INDEX
                        $this->redirectTo('security', 'index');
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
                elseif((!$userManager->findOneByEmail($email))===false
                && (!$userManager->findOneByNickname($nickName)===true)
                ){
                    return [
                        "view" => VIEW_DIR . "security/register.php",
                        "data" => [
                            "error" => "Le mail utilisé correspond a un compte existant "
                        ]
                    ];
                }
                    //Si l'$nickName existe déjà mais que le $email n'existe pas encore
                elseif((!$userManager->findOneByEmail($email))===true
                && (!$userManager->findOneByNickname($nickName)===false)
                ){
                    return [
                        "view" => VIEW_DIR . "security/register.php",
                        "data" => [
                            "error" => "Le pseudo existe déjà "
                        ]
                    ];
                }
                elseif((!$userManager->findOneByEmail($email))===false
                && (!$userManager->findOneByNickname($nickName)===false)
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
    }
    



    public function loginOld()
    {
        $userManager = new UserManager();
        //Si $_POST["submit"] est défini 
        if (isset($_POST["submit"])) {
            //Si chaques $_POST["..."] sont définis
            if (isset($_POST["email"]) && isset($_POST["password"])) {
                //On filtres les $_POST et les associes a des variables A FAIRE /!\
                $email = $_POST["email"];
                $password = $_POST["password"];
            }
            //On défini userList comme correspondant a la liste des tout les users, classés par email desc
            $userList = $userManager->findAll(["Email", "DESC"]);

            //Boucle foreach sur chaque élément de userList considérés comme $user
            foreach ($userList as $user) {
                //Si AUCUNS des mails d'utilisateur NE correspond a l'email du $_POST
                if ($user->getEmail() != $email) {
                    //On return un message d'erreur et renvoie a la vue du login, puis break la boucle.
                    return [
                        "view" => VIEW_DIR . "security/login.php",
                        "data" => [
                            "error" => "L'email fourni ne correspond a aucuns utilisateurs"
                        ]
                    ];
                    break;
                }
                //SINON, un mail correspond
                else{
                    //Si un mail correspond && que le mot de passe correspond
                    if (($user->getEmail() == $email) && (password_verify($password, $user->getPassword()) )) {
                        //On return un message de success et renvoie a la vue du login
                        return [
                            "view" => VIEW_DIR . "security/login.php",
                            "data" => [
                                "success" => "Connexion réussie"
                            ]
                        ];
                }
            }
        }
    }
    }
    public function login(){
        $userManager = new UserManager();
        //Si $_POST["submit"] est défini 
        if (isset($_POST["submit"])) {
            //Si chaques $_POST["..."] sont définis
            if (isset($_POST["email"]) && isset($_POST["password"])) {
                //On filtres les $_POST et les associes a des variables A FAIRE /!\
                $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS);            
                // var_dump($userManager->findOneByEmail($email)->getPassword());die;

                    //Si l'email n'existe pas en base de donnée
                    if((!$userManager->findOneByEmail($email))===true){
                        return [
                            "view" => VIEW_DIR . "security/login.php",
                            "data" => [
                                "error" => "L'email fourni ne correspond à aucuns utilisateurs" //msg d'erreur
                            ]
                        ];
                    }
                    //Sinon (si l'email existe)
                    else{
                        //Si le $password correspond au $password haché correspond au $email en bdd
                        if((password_verify($password, $userManager->findOneByEmail($email)->getPassword()))){
                        return [
                            "view" => VIEW_DIR . "security/login.php",
                            "data" => [
                                "success" => "L'authentification à réussi" //msg de succès
                            ]
                        ];
                        }
                        //Sinon (si le $password ne correspond pas au $email)
                        elseif((password_verify($password, $userManager->findOneByEmail($email)->getPassword()))===false){
                            return [
                                "view" => VIEW_DIR . "security/login.php",
                                "data" => [
                                "error" => "Le mot de passe ne correspond pas a l'email renseigné" //msg de succès
                                ]
                            ];
                        }
                    }
    }
}
}}
