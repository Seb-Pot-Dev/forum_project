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
    public function linkToListUsers(){
        $userManager = new UserManager();

        return [
            "view" => VIEW_DIR . "forum/listUsers.php",
            "data" => [
                "users" => $userManager->findAll(["nickName", "DESC"])
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
                if ((!$userManager->findOneByEmail($email))
                    && (!$userManager->findOneByNickname($nickName))
                ) {
                    // ---- si les MDP et MDPconfirm correspondent ---
                    if ($password == $passwordConfirm) {
                        //On hash le mot de passe
                        $password = password_hash($password, PASSWORD_DEFAULT);

                        //alors ON AJOUTE ENFIN L'UTILISATEUR EN BDD.
                        $userManager->add(["nickName" => $nickName, "password" => $password, "email" => $email]); //le rôle est défini par défaut en "normal" et ban en "0"

                        //On envoie en session le message d'erreur/succès
                        Session::addFlash('success', 'Vous êtes bien INSCRIT !');
                        //On redirige vers la vue adaptée
                        $this->redirectTo('security', 'login');
                    }
                    // ---- autrement, c'est que les MDP et MDPconfirm NE correspondent PAS  ---
                    else {
                        //On envoie en session le message d'erreur/succès
                        Session::addFlash('error', 'Les mots de passes ne correspondent pas');
                        //On redirige vers la vue adaptée
                        $this->redirectTo('security', 'index');
                    }
                }
                //Si l'$email existe déjà mais que le $nickName n'existe pas encore
                elseif (($userManager->findOneByEmail($email))
                    && (!$userManager->findOneByNickname($nickName))
                ) {
                    //On envoie en session le message d'erreur/succès
                    Session::addFlash('error', "Nom d'utilisateur inexistant");
                    //On redirige vers la vue adaptée
                    $this->redirectTo('security', 'index');
                }
                //Si l'$nickName existe déjà mais que le $email n'existe pas encore
                elseif ((!$userManager->findOneByEmail($email))
                    && ($userManager->findOneByNickname($nickName))
                ) {
                    //On envoie en session le message d'erreur/succès
                    Session::addFlash('error', 'Le mail utilisé ne correspond à aucun utilisateur');
                    //On redirige vers la vue adaptée
                    $this->redirectTo('security', 'index');
                } elseif (($userManager->findOneByEmail($email))
                    && ($userManager->findOneByNickname($nickName))
                ) {
                    //On envoie en session le message d'erreur/succès
                    Session::addFlash('error', 'Le pseudo ET le mail sont déjà utilisés par un utilisateur');
                    //On redirige vers la vue adaptée
                    $this->redirectTo('security', 'index');
                }
            }
        }
        //Sinon, retourne la view du register.php
        else {
            $this->redirectTo('security', 'index');
        }
    }

    public function modifyPassword($id)
    {
        //$id = user
        $userManager = new UserManager();


        if (isset($_POST["submit"])) {
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $newPassword = filter_input(INPUT_POST, "newPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $passwordConfirm = filter_input(INPUT_POST, "passwordConfirm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //Si les mdp confirm correspondent
            if ($newPassword && $password && ($newPassword == $passwordConfirm)) {
                //et Si le nouveau mdp n'est pas le mm que l'ancien
                if ($newPassword != $password) {
                    //On récupère le hash du password dans la bdd
                    $hash = $userManager->findOneById($id)->getPassword();
                    //Si le password entré correspond a celui dans la BDD
                    if (password_verify($password, $hash)) {
                        //Alors on hash le nouveau password
                        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        //Et on utilise la fn du manager pour modifier le mdp en BDD
                        $userManager->modifyPasswordByUser($id, $newPassword);
                        //message de succès
                        Session::addFlash('success', 'Mot de passe modifié avec succès');
                        //redirection
                        $this->redirectTo('security', 'linkToModifyPassword', $id);
                    }
                } else { //autrement le mdp est le même que l'ancien
                    Session::addFlash('error', "Le mot de passe modifié ne peut pas être le même que l'ancien");
                    $this->redirectTo('security', 'linkToModifyPassword', $id);
                }
            } else {
                //message d'erreur si le mdp ne correspond pas au mdp en bdd
                Session::addFlash('error', 'Mauvais mot de passe');
                //redirection
                $this->redirectTo('security', 'linkToModifyPassword', $id);
            }
        } else {
            //message d'erreur si les mdp confirm ne correspondent pas
            Session::addFlash('error', 'Les mot de passe ne correspondent pas');
            //redirection
            $this->redirectTo('security', 'linkToModifyPassword', $id);
        }
    }


    public function linkToModifyPassword($id)
    {
        $userManager = new UserManager;
        return [
            "view" => VIEW_DIR . "security/modifyPassword.php",
            "data" => [
                "user" => $userManager->findOneById($id)
            ]
        ];
    }

    public function login()
    {
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
                if (!$user) {
                    //On envoie en session le message d'erreur/succès
                    Session::addFlash('error', 'Le mail utilisé ne correspond a aucun utilisateurs');
                    //On redirige vers la vue adaptée
                    $this->redirectTo('security', 'login');
                }
                //Sinon (si l'email existe)
                else {
                    //Si l'utilisateur n'est pas banni
                    if ($user->getBan() == 0) {
                        //$hash=$password haché présent en bdd
                        $hash = $userManager->findOneByEmail($email)->getPassword();

                        //Si le $password correspond au $password haché correspondant au $email en bdd
                        if ((password_verify($password, $hash))) {

                            //placer l'utilisateur en session
                            Session::setUser($user);

                            //On envoie en session le message d'erreur/succès
                            Session::addFlash('success', 'Connexion réussie');

                            //redirige vers l'index
                            $this->redirectTo('category', 'index');
                        }
                        //Sinon (si le $password ne correspond pas au $email)
                        elseif ((password_verify($password, $hash)) === false) {
                            //On envoie en session le message d'erreur/succès
                            Session::addFlash('error', 'Le mot de passe est incorrect');
                            //On redirige vers la vue adaptée
                            $this->redirectTo('security', 'login');
                        }
                    } else {
                        //On envoie en session le message d'erreur/succès
                        Session::addFlash('error', 'Votre compte a été banni. Veuillez contacter un modérateur.');
                        //On redirige vers la vue adaptée
                        $this->redirectTo('security', 'login');
                    }
                }
            }
        }

        //Sinon renvoie la view login.php
        else {
            $this->redirectTo('security', 'linkToLogin');
        }
    }

    // -- Pour voir les infos du profile d'utilisateur en session
    public function viewProfile()
    {
        //Si un utilisateur est renseigné en session
        if ($_SESSION["user"]) {
            //retourne la vue correspondante et renseigne le champs "user" avec les infos du user en session
            return [
                "view" => VIEW_DIR . "security/viewProfile.php",
                "data" => [
                    "user" => $_SESSION["user"]
                ]
            ];
        } else {
            //On envoie en session le message d'erreur/succès
            Session::addFlash('error', 'Pour consulter votre profil, veuillez vous connecter');
            //On redirige vers la vue adaptée
            $this->redirectTo('security', 'linkToLogin');
        }
    }
    public function viewOtherUserProfile($id)
    {
        $userManager = new UserManager;
        $postManager = new PostManager;
        //retourne la vue correspondante et renseigne le champs "user" avec les infos du user en session
        return [
            "view" => VIEW_DIR . "security/viewOtherUserProfile.php",
            "data" => [
                "user" => $userManager->findOneById($id),
                "posts" => $postManager->find5lastPostsByUser($id)
            ]
        ];
    }


    // -- pour se déconnecter
    public function logout()
    {
        //Si un utilisateur est renseigné en session
        if ($_SESSION["user"]) {

            //détruit tout donnée associées a la variable $session
            session_destroy();

            //redirige vers l'index du user
            $this->redirectTo('security', 'linkToLogin');
            //Ajout d'un message de succès
            Session::addFlash('success', 'Déconnection réussie');
        } else {
            //Ajout d'un message d'erreur
            Session::addFlash('error', 'Echec de déconnection ');
            //redirige vers l'index du user
            $this->redirectTo('user', 'index');
        }
    }
    public function banUser($id)
    {
        // Si l'utilisateur en session est admin ou moderator
        if ($_SESSION['user']->getRole() == ('admin' || 'moderator')) {
            $userManager = new UserManager();
            //utilisation de la fonction pour ban en fonction de l'ID
            $userManager->banUserById($id);

            //On envoie en session le message d'erreur/succès
            Session::addFlash('error', 'Le compte selectionné a été banni.');
            //redirection vers la page de l'utilisteur banni
            $this->redirectTo('security', 'viewOtherUserProfile', $id);
        }
    }
    public function banUserFromList($id)
    {
        // Si l'utilisateur en session est admin ou moderator
        if ($_SESSION['user']->getRole() == ('admin' || 'moderator')) {
            $userManager = new UserManager();
            //utilisation de la fonction pour ban en fonction de l'ID
            $userManager->banUserById($id);

            //On envoie en session le message d'erreur/succès
            Session::addFlash('error', 'Le compte selectionné a été banni.');
            //redirection vers la list des users
            $this->redirectTo('security', 'linkToListUsers');
        }
    }
    public function unbanUser($id)
    {
        // Si l'utilisateur en session est admin ou moderator
        if ($_SESSION['user']->getRole() == ('admin' || 'moderator')) {
            $userManager = new UserManager();

            //utilisation de la fonction pour ban en fonction de l'ID
            $userManager->unbanUserById($id);
            //On envoie en session le message d'erreur/succès
            Session::addFlash('success', 'Le compte selectionné a été débanni.');
            //redirection vers la page de l'utilisteur débanni
            $this->redirectTo('security', 'viewOtherUserProfile', $id);
        }
    }
    public function unbanUserFromList($id)
    {
        // Si l'utilisateur en session est admin ou moderator
        if ($_SESSION['user']->getRole() == ('admin' || 'moderator')) {
            $userManager = new UserManager();
            //récupération du Nickname du user
            $userNickname = $userManager->findOneById($id)->getNickname();
            //utilisation de la fonction pour ban en fonction de l'ID
            $userManager->unbanUserById($id);
            //On envoie en session le message d'erreur/succès
            Session::addFlash('success', 'Le compte selectionné a été débanni.');
            //redirection vers la page de l'utilisteur débanni
            $this->redirectTo('security', 'linkToListUsers');
        }
    }
}
