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

                /* On défini la var $userList comme étant égale
                        a la list de tout les nickName d'utilisateur */
                $userList = $userManager->findAll(["nickName", "DESC"]);

                // on boucle sur tout les nickName d'utilisateur et...
                foreach ($userList as $user) {
                    //... si le $_POST["nickName"] est equivalent a un des nickname...
                    if ($user->getNickname() == $nickName) {
                        //... alors $nickName = NULL
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

                    /*AUTREMENT, le nickName est NULL car existe déjà 
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

    public function login()
    {
        $userManager = new UserManager();

        if (isset($_POST["submit"])) {
            if (isset($_POST["email"]) && isset($_POST["password"])) {

                $email = $_POST["email"];
                $password = $_POST["password"];
            }
            $userList = $userManager->findAll(["Email", "DESC"]);

            foreach ($userList as $user) {
                if ($user->getEmail() != $email) {

                    return [
                        "view" => VIEW_DIR . "security/login.php",
                        "data" => [
                            "error" => "L'email fourni ne correspond a aucuns utilisateurs"
                        ]
                    ];
                    break;
                }
            }
        }
    }
}
