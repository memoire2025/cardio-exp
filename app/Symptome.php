<?php

namespace App;

class Symptome extends Database {
    protected $table = 'symptome';
    private $nom;
    private $description;
    private static $config;

    public function __construct($nom, $description)
    {
        $this->nom = $nom;
        $this->description = $description;

        self::$config = (ConfigDB::getInstance())->getConfig();
        parent::__construct(self::$config);
    }

    public function addSymptome() {
        $data = [
            'code' => bin2hex(random_bytes(16)),
            'nom' => $this->nom,
            'description' => $this->description,
            'temps' => time()
        ];
        return self::insert($this->table, $data);
    }

    public function getAllSymptome() {
        return self::all($this->table);
    }

    public function getPaginateSymptome($limit, $offset) {
        try {
            return self::paginate($this->table, $limit, $offset);
        } catch (\Exception $th) {
            die('Erreur lors de la pagination'. $th->getMessage());
        }
    }

    public function existSymptome() {
        try {
            return self::findByParams($this->table, 'nom = :nom', ['nom' => $this->nom]);
        } catch (\Throwable $th) {
            die('Erreur lors de existSymptome'. $th->getMessage());
        }
    }

    public function getSymptomeByCode($code) {
        $params = 'code = :code';
        $data = ['code' => $code];
        try {
            return self::findByParams($this->table, $params, $data);
        } catch (\Throwable $th) {
            die('Erreur lors de getByCode'. $th->getMessage());
        }
    }



}