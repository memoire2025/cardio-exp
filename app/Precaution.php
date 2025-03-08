<?php

namespace App;

class Precaution extends Database {
    protected $table = 'precaution';
    private $code_diagno;
    private $traitement;
    private static $config;

    public function __construct($code_diagno, $traitement)
    {
        $this->code_diagno = $code_diagno;
        $this->traitement = $traitement;

        self::$config = (ConfigDB::getInstance())->getConfig();
        parent::__construct(self::$config);
    }

    public function addPrecaution() {
        $data = [
            'code' => bin2hex(random_bytes(16)),
            'code_diagno' => $this->code_diagno,
            'traitement' => $this->traitement,
            'temps' => time(),
        ];
        try {
            return self::insert($this->table, $data);
        } catch (\Exception $th) {
            die('Erreur lors de l\'insertion'. $th->getMessage());
        }
    }

    public function getPaginatePrecaution($limit, $offset) {
        try {
            return self::paginate($this->table, $limit, $offset);
        } catch (\Exception $th) {
            die('Erreur lors de la pagination'. $th->getMessage());
        }
    }

    public function getAllPrecaution() {
        return self::all($this->table);
    }

    public function existPrecaution() {
        try {
            return self::findByParams($this->table, 'code_diagno = :code_diagno AND traitement = :traitement', ['code_diagno' => $this->code_diagno, 'traitement' => $this->traitement]);
        } catch (\Throwable $th) {
            die('Erreur lors de existSymptome'. $th->getMessage());
        }
    }

    public function getPrecautionByCode($code) {
        $params = 'code = :code';
        $data = ['code' => $code];
        try {
            return self::findByParams($this->table, $params, $data);
        } catch (\Throwable $th) {
            die('Erreur lors de getByCode'. $th->getMessage());
        }
    }

    public function getPaginateJoinTable($limit, $offset) {
        return self::getJoinTablePaginate(
            $this->table.' p',
            'diagnostic d',
            'p.code_diagno = d.code',
            'p.code, p.traitement, d.nom',
            'd.nom ASC',
            $limit,
            $offset,
        );
    }

}