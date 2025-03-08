<?php

    try {

        if (isset($_SESSION['cardio-exp'])) {
            unset($_SESSION['cardio-exp']['code']);
            unset($_SESSION['cardio-exp']['role']);
            session_destroy();

            header('Location: /');
        }
   
    } catch (\Throwable $th) {
        echo json_encode([
            'error' => true,
            'status' => 'error',
            'message' => 'Erreur serveur : ' . $e->getMessage()
        ]);
    }
    exit;
    
?>