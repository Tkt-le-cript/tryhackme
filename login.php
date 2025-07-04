<?php
$db = new SQLite3('users.db');

// Crée la table si elle n'existe pas
$db->exec("CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  email TEXT NOT NULL,
  password TEXT NOT NULL
)");

// Ajoute un utilisateur test si non présent
$result = $db->querySingle("SELECT COUNT(*) as count FROM users WHERE email = 'admin@site.com'");
if ($result == 0) {
  $db->exec("INSERT INTO users (email, password) VALUES ('admin@site.com', 'admin123')");
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

echo "<p>Requête SQL exécutée :</p><pre>";

$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
echo $query . "</pre>";

$result = $db->query($query);

if ($row = $result->fetchArray()) {
  echo "<p style='color: green;'>Connexion réussie ! Bonjour " . htmlspecialchars($row['email']) . "</p>";
} else {
  echo "<p style='color: red;'>Échec de la connexion.</p>";
}
?>
