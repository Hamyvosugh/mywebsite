<?php
/*
Template Name: Maintenance Mode
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log("Session started in maintenance.php.");
}

// Display a simple message for the maintenance mode
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hamy Vosugh</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2e2d33;
            color: #fff;
            display: flex;
             
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .maintenance-container {
            text-align: center;
            background-color: transparent;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            line-height: 3px;
        }
        .maintenance-title {
            font-size: 32px;
        }
        .maintenance-message {
            font-size: 18px;
        }
        .logo {
           height: 183px;
           width: 183px;
        }
    </style>
</head>
<body>
    
    <div class="maintenance-container">
        <div>
            <img src="https://hamyvosugh.com/wp-content/uploads/2024/09/cropped-profile-bild-_1_-_1_-1.webp" class="logo">
        </div>
        <h1 class="maintenance-title">Hamy Vosugh</h1>
        <p class="maintenance-message">Creative Director for your Content Marketing</p>
    </div>
    
</body>
</html>