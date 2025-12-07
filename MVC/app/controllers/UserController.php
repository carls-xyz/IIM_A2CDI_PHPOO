<?php

class UserController
{
    use Render;

    /**
     * Liste tous les utilisateurs (admin seulement)
     */
    public function index(): void
    {
        // Vérifier si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès non autorisé.";
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        $userModel = new UserModel();
        $users = $userModel->getAllUsers();
        
        $this->renderView('user/index', [
            'users' => $users
        ]);
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function register(): void
    {
        // Si déjà connecté, rediriger
        if (isset($_SESSION['user'])) {
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        $this->renderView('user/register');
    }

    /**
     * Traite l'inscription d'un nouvel utilisateur
     */
    public function registerSubmit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->getBaseUrl() . '/user/register');
            exit;
        }

        // Validation des données
        $errors = [];
        
        if (empty($_POST['prenom'])) {
            $errors[] = "Le prénom est requis.";
        }
        if (empty($_POST['nom'])) {
            $errors[] = "Le nom est requis.";
        }
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Un email valide est requis.";
        }
        if (empty($_POST['motdepasse']) || strlen($_POST['motdepasse']) < 6) {
            $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header('Location: ' . $this->getBaseUrl() . '/user/register');
            exit;
        }

        // Créer l'utilisateur
        $userModel = new UserModel();
        $data = [
            'prenom' => htmlspecialchars($_POST['prenom']),
            'nom' => htmlspecialchars($_POST['nom']),
            'email' => htmlspecialchars($_POST['email']),
            'motdepasse' => $_POST['motdepasse'],
            'role' => 'user' // Par défaut
        ];

        $success = $userModel->createUser($data);

        if ($success) {
            $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header('Location: ' . $this->getBaseUrl() . '/user/login');
        } else {
            $_SESSION['error'] = "Cet email est déjà utilisé.";
            $_SESSION['old_data'] = $_POST;
            header('Location: ' . $this->getBaseUrl() . '/user/register');
        }
        exit;
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function login(): void
    {
        // Si déjà connecté, rediriger
        if (isset($_SESSION['user'])) {
            header('Location: ' . $this->getBaseUrl() . '/');
            exit;
        }

        $this->renderView('user/login');
    }

    /**
     * Traite la connexion d'un utilisateur
     */
    public function loginSubmit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->getBaseUrl() . '/user/login');
            exit;
        }

        $email = $_POST['email'] ?? '';
        $motdepasse = $_POST['motdepasse'] ?? '';

        if (empty($email) || empty($motdepasse)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header('Location: ' . $this->getBaseUrl() . '/user/login');
            exit;
        }

        $userModel = new UserModel();
        $user = $userModel->loguser($email, $motdepasse);

        if ($user) {
            // Connexion réussie
            $_SESSION['user'] = [
                'id' => $user['id'],
                'prenom' => $user['prenom'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            $_SESSION['success'] = "Bienvenue " . $user['prenom'] . " !";
            header('Location: ' . $this->getBaseUrl() . '/');
        } else {
            // Échec de la connexion
            $_SESSION['error'] = "Email ou mot de passe incorrect.";
            header('Location: ' . $this->getBaseUrl() . '/user/login');
        }
        exit;
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout(): void
    {
        // Détruire la session
        session_unset();
        session_destroy();
        
        // Redémarrer une nouvelle session pour les messages flash
        session_start();
        $_SESSION['success'] = "Vous avez été déconnecté avec succès.";
        
        header('Location: ' . $this->getBaseUrl() . '/');
        exit;
    }

    /**
     * Calcule l'URL de base
     * @return string URL de base
     */
    private function getBaseUrl(): string
    {
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        return ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
    }
}