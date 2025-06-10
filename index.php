<?php
// Main entry point for the application
session_start();
require_once 'config/database.php';
require_once 'config/config.php';
require_once 'includes/functions.php';
require_once 'controllers/RouteController.php';

// Initialize the router
$router = new RouteController();
$router->route();
?>