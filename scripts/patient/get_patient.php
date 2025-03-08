<?php

use App\Patient;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page -1) * $limit;

        $user_inst = new Patient("", "", "", "", "", "", "");

        $total_user = count($user_inst->getAllPatient());

        $user = $user_inst->getPaginate($limit, $offset);
        if (empty($user)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Aucun user trouvé'
            ]);
            exit;
        }
        $role_session = $_SESSION['cardio-exp']['role'];
        echo json_encode([
            'status' => 'success',
            'message' => 'user trouvé avec success',
            'data' => $user,
            'total' => $total_user,
            'session' => $role_session
        ]);

    }else{
        echo json_encode([
            'status' => 'error',
            'message' => 'Methode non autoriser pour recuperer les données'
        ]);
        exit;
    }
} catch (\Throwable $th) {
    die('Erreur serveur à la recuperation de données'. $th->getMessage());
}