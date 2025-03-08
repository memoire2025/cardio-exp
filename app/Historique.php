<?php

    namespace App;

    class Historique extends Database {
        protected $table = 'historique';
        
        private $code_user;
        private $code_patient;
        // private $code_symptomes;
        // private $nom_diagno;
        // private $nom_precaution;
        private $analyse;

        private static $config;

        public function __construct($code_user, $code_patient, $analyse) {

            $this->code_user = $code_user;
            $this->code_patient = $code_patient;
            $this->analyse = $analyse;

            self::$config = (ConfigDB::getInstance())->getConfig();

            parent::__construct(self::$config);

        }

        public function getAllHistorique() {
            return self::all($this->table);
        }

        public function existHistorique (){

            $params = 'code_user = :code_user AND code_patient = :code_patient AND code_symptomes = :code_symptomes AND nom_diagno = :nom_diagno AND nom_precation = :nom_precaution';
            $data = [
                'code_user' => $this->code_user,
                'code_patient' => $this->code_patient,
                'analyse' => $this->analyse,
                // 'code_symptomes' => $this->code_symptomes,
                // 'nom_diagno' => $this->nom_diagno,
                // 'nom_precaution' => $this->nom_precaution
            ];
            return self::findByParams($this->table, $params, $data);
        }

        public function findOne($code) {
            return self::findByParams($this->table, 'code = :code', ['code' => $code]);
        }

        public function getPaginate($limit, $offset) {
            return self::paginate($this->table, $limit, $offset);
        }

        public function add() {

            $data = [
                'code_user' => $this->code_user,
                'code_patient' => $this->code_patient,
                'analyse' => $this->analyse,
                
                'code' => bin2hex(random_bytes(16)),
                'temps' => time()
            ];

            try {
                return self::insert($this->table, $data);
            } catch (\Exception $th) {
                die('Erreur lors de l\'insertion utilisateur'. $th->getMessage());
            }
        
        }
    }
