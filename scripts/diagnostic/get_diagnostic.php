<?php

use App\Diagnostic;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page -1) * $limit;

        $diagnostic_inst = new Diagnostic("", "", "");

        $total_diagnostic = count($diagnostic_inst->getAllDiagnostic());

        $diagnostic = $diagnostic_inst->getPaginateDiagnostic($limit, $offset);
        if (empty($diagnostic)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Aucun diagnostic trouvé'
            ]);
            exit;
        }
        $role_session = $_SESSION['cardio-exp']['role'];
        echo json_encode([
            'status' => 'success',
            'message' => 'Diagnostic trouvé avec success',
            'data' => $diagnostic,
            'total' => $total_diagnostic,
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