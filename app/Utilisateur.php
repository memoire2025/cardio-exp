<?php

namespace App;
class Utilisateur extends Database {

    protected static $table = 'utilisateur';
    private static $nom;
    private static $prenom;
    private static $email;
    private static $mdp;
    private static $role;
    private static $config;

    public function __construct($nom, $prenom, $email, $mdp, $role) {

        self::$nom = $nom;
        self::$prenom = $prenom;
        self::$email = $email;
        self::$mdp = $mdp;
        self::$role = $role;

        self::$config = (ConfigDB::getInstance())->getConfig();

        parent::__construct(self::$config);

    }

    public static function getAllUtilisateur() {
        return self::all(self::$table);
    }

    public static function existUtilisateur (){

        $params = 'email = :email';
        $data = [
            'email' => self::$email
        ];
        return self::findByParams(self::$table, $params, $data);
    }

    public static function existUtilisateurNoData (){

        $params = 'email = :email';
        $data = [
            'email' => self::$email
        ];
        return self::findByParamsNoData(self::$table, $params, $data);
    }

    public static function getUtilisateurById($id){
        return self::find(self::$table, $id);
    }

    public static function getPaginate($limit, $offset) {
        return self::paginate(self::$table, $limit, $offset);
    }

    public static function createPersonnel() {

        $data = [
            'nom' => self::$nom,
            'prenom' => self::$prenom,
            'email' => self::$email,
            'mdp' => password_hash(self::$mdp, PASSWORD_BCRYPT),
            'role' => self::$role,
            'code' => bin2hex(random_bytes(16)),
            'temps' => time()
        ];

        try {
            return self::insert(self::$table, $data);
        } catch (\Exception $th) {
            die('Erreur lors de l\'insertion utilisateur'. $th->getMessage());
        }
    
    }

    public function loginUtilisateur() {

        $user = self::existUtilisateur();

        if (!$user) {
            return [];
            exit;
        }
        
        if (password_verify(self::$mdp, $user['mdp'])) :
            return $user;
        endif;

        return [];
    }

    public static function deleteOne($code) {
        try {
            return self::delete(self::$table, $code);
        } catch (\Throwable $th) {
            die('Erreur lors de la suppression'. $th->getMessage());
        }
    }
}
