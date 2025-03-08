<?php

namespace App;

class Diagnostic extends Database {
    protected $table = 'diagnostic';
    private $nom;
    private $description;
    private $degre_certitude;
    private static $config;

    public function __construct($nom, $description, $degre_certitude)
    {
        $this->nom = $nom;
        $this->description = $description;
        $this->degre_certitude = $degre_certitude;

        self::$config = (ConfigDB::getInstance())->getConfig();
        parent::__construct(self::$config);
    }

    public function addDiagnostic() {
        $data = [
            'code' => bin2hex(random_bytes(16)),
            'nom' => $this->nom,
            'description' => $this->description,
            'degre_certitude' => $this->degre_certitude,
            'temps' => time(),
        ];
        try {
            return self::insert($this->table, $data);
        } catch (\Exception $th) {
            die('Erreur lors de l\'insertion'. $th->getMessage());
        }
    }

    public function getPaginateDiagnostic($limit, $offset) {
        try {
            return self::paginate($this->table, $limit, $offset);
        } catch (\Exception $th) {
            die('Erreur lors de la pagination'. $th->getMessage());
        }
    }

    public function getAllDiagnostic() {
        return self::all($this->table);
    }

    public function existDiagno() {
        try {
            return self::findByParams($this->table, 'nom = :nom', ['nom' => $this->nom]);
        } catch (\Throwable $th) {
            die('Erreur lors de existSymptome'. $th->getMessage());
        }
    }

    public function getDiagnoByCode($code) {
        try {
            return self::findByParams($this->table, 'code = :code', ['code' => $code]);
        } catch (\Throwable $th) {
            die('Erreur lors de getByCode'. $th->getMessage());
        }
    }


}