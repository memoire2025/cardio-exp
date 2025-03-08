<?php

    namespace App;

    class Patient extends Database {
        protected static $table = 'patient';
        private static $nom;
        private static $postnom;
        private static $prenom;
        private static $sexe;
        private static $age;
        private static $telephone;
        private static $adresse;
        private static $config;

        public function __construct($nom, $postnom, $prenom, $sexe, $age, $telephone, $adresse) {

            self::$nom = $nom;
            self::$postnom = $postnom;
            self::$prenom = $prenom;
            self::$sexe = $sexe;
            self::$age = $age;
            self::$telephone = $telephone;
            self::$adresse = $adresse;

            self::$config = (ConfigDB::getInstance())->getConfig();

            parent::__construct(self::$config);

        }

        public static function getAllPatient() {
            return self::all(self::$table);
        }

        public static function existPatient (){

            $params = 'nom = :nom AND prenom = :prenom AND sexe = :sexe AND age = :age';
            $data = [
                'nom' => self::$nom,
                'prenom' => self::$prenom,
                'sexe' => self::$sexe,
                'age' => self::$age
            ];
            return self::findByParams(self::$table, $params, $data);
        }

        public static function findOne($code) {
            return self::findByParams(self::$table, 'code = :code', ['code' => $code]);
        }

        public static function getPatientByCode($code){
            return self::findByParams(self::$table, 'code = :code', ['code' => $code]);
        }

        public static function getPaginate($limit, $offset) {
            return self::paginate(self::$table, $limit, $offset);
        }

        public static function createPatient() {

            $data = [
                'nom' => self::$nom,
                'postnom' => self::$postnom,
                'prenom' => self::$prenom,
                'sexe' => self::$sexe,
                'age' => self::$age,
                'telephone' => self::$telephone,
                'adresse' => self::$adresse,
                'code' => bin2hex(random_bytes(16)),
                'temps' => time()
            ];

            try {
                return self::insert(self::$table, $data);
            } catch (\Exception $th) {
                die('Erreur lors de l\'insertion utilisateur'. $th->getMessage());
            }
        
        }
    }