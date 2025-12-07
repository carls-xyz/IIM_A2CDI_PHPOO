<?php
class UserModel extends Bdd
{
    
public function createUser(array $data): bool
{
    // Vérifier si l'email existe déjà
    $stmt = $this->co->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->execute(['email' => $data['email']]);
    
    if ($stmt->fetch()) {
        return false; // Email déjà utilisé
    }
    
    // Hacher le mot de passe
    $hashedPassword = password_hash($data['motdepasse'], PASSWORD_DEFAULT);
    
    $stmt = $this->co->prepare(
        'INSERT INTO users (nom, prenom, email, motdepasse, role) 
         VALUES (:nom, :prenom, :email, :motdepasse, :role)'
    );
    
    return $stmt->execute([
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'email' => $data['email'],
        'motdepasse' => $hashedPassword,
        'role' => $data['role'] ?? 'user' // Rôle par défaut
    ]);
}

public function loguser(string $email, string $motdepasse): array|false
{
    $stmt = $this->co->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    
    $user = $stmt->fetch();
    
    if ($user && password_verify($motdepasse, $user['motdepasse'])) {
        return $user;
    }
    
    return false;
}

public function getAllUsers(): array
{
    $users = $this->co->prepare('SELECT * FROM users');
    $users->execute();

    $result = $users->fetchAll();

    return $result;
}   
}