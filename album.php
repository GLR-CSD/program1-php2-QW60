<?php
declare(strict_types=1);

session_start();

// Haal de eventuele fouten en formulier waarden op uit de sessie
$errors = $_SESSION['errors'] ?? [];
$formValues = $_SESSION['formValues'] ?? [];

// Verwijder de sessievariabelen
unset($_SESSION['errors']);
unset($_SESSION['formValues']);

require_once 'db.php';
require_once 'classes/Album.php';

// Haal alle albums op uit de database
$albums = Album::getAll($db);

// Laad de view
include 'views/album_view.php';