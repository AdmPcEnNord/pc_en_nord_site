<?php
// Définition de la timezone
date_default_timezone_set('Europe/Paris');

// Sécurisation basique des entrées
function clean($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

// Récupération des champs du formulaire
$nom       = clean($_POST['nom'] ?? '');
$prenom    = clean($_POST['prenom'] ?? '');
$email     = clean($_POST['email'] ?? '');
$telephone = clean($_POST['telephone'] ?? '');
$date      = clean($_POST['date'] ?? '');
$heure     = clean($_POST['heure'] ?? '');
$message   = clean($_POST['message'] ?? '');
$urgent    = isset($_POST['urgent']) ? true : false;

// Validation minimale
if ($nom === '' || $prenom === '' || $email === '' || $message === '') {
    die("Veuillez remplir les champs obligatoires.");
}

// Structure du JSON
$data = [
    "nom"       => $nom,
    "prenom"    => $prenom,
    "email"     => $email,
    "telephone" => $telephone,
    "date"      => $date,
    "heure"     => $heure,
    "message"   => $message,
    "urgent"    => $urgent,
    "timestamp" => date("Y-m-d H:i:s")
];

// Encodage JSON
$json = json_encode($data, JSON_PRETTY_PRINT);

// Chemin du dossier messages/
$dir = __DIR__ . "/messages";

// Création du dossier si nécessaire
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// Nom du fichier basé sur time()
$filename = $dir . "/" . time() . ".json";

// Écriture du fichier
file_put_contents($filename, $json);

// Popup de confirmation + retour à la page contact
echo "
<script>
    alert('Merci pour votre message ! Nous vous contacterons dans les plus brefs délais.');
    window.location.href = 'contact.html';
</script>
";
?>
