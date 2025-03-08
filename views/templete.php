// Configurer DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

$customPaper = [0, 0, 210, 74 * 2.835]; // Format 74mm x 210mm (converti en points)
$dompdf->setPaper($customPaper, 'portrait');

$dompdf->render();

// Télécharger le fichier PDF
$dompdf->stream("facture_$idFacture.pdf", ["Attachment" => true]);

<a href="generate_pdf.php?id=1" target="_blank" class="btn btn-primary">Imprimer la facture</a>



composer require endroid/qr-code

<?php

require __DIR__ . '/vendor/autoload.php'; // Charge Composer et les dépendances

use Endroid\QrCode\Builder\Builder;
use PDO;

// Connexion à la base de données
$config = include 'config.php';
try {
    $db = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']}",
        $config['user'],
        $config['password']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer des données depuis la base
$id = 1; // Par exemple, un ID fourni
$stmt = $db->prepare("SELECT * FROM produits WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    die("Produit introuvable !");
}

// Construire le contenu du code QR
$qrData = "Nom : {$produit['nom']}\n";
$qrData .= "Prix : {$produit['prix']} €\n";
$qrData .= "Description : {$produit['description']}";

// Générer le code QR
$result = Builder::create()
    ->data($qrData)
    ->size(300) // Taille en pixels
    ->margin(10)
    ->build();

// Sauvegarder le QR code en tant qu'image
$qrPath = __DIR__ . "/qrcodes/produit_{$id}.png";
file_put_contents($qrPath, $result->getString());

// Afficher le QR code sur la page
header('Content-Type: ' . $result->getMimeType());
echo $result->getString();



<img src="qrcodes/produit_1.png" alt="QR Code Produit">


header('Content-Disposition: attachment; filename="produit_1_qrcode.png"');
header('Content-Type: ' . $result->getMimeType());
echo $result->getString();



class Database {
    protected $pdo;

    public function __construct($dsn, $username, $password) {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer un enregistrement par ID
    public function find($table, $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer tous les enregistrements
    public function all($table) {
        $stmt = $this->pdo->query("SELECT * FROM $table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour supprimer un enregistrement
    public function delete($table, $id) {
        $stmt = $this->pdo->prepare("DELETE FROM $table WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }

    // Méthode pour insérer un enregistrement
    public function insert($table, $data) {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $stmt = $this->pdo->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    // Méthode pour mettre à jour un enregistrement
    public function update($table, $data, $id) {
        $columns = '';
        foreach ($data as $key => $value) {
            $columns .= "$key = :$key, ";
        }
        $columns = rtrim($columns, ', ');
        $stmt = $this->pdo->prepare("UPDATE $table SET $columns WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }
}



class User extends Database {
    protected $table = 'users';

    // Méthode pour récupérer tous les utilisateurs
    public function getAllUsers() {
        return $this->all($this->table);
    }

    // Méthode pour trouver un utilisateur par ID
    public function getUserById($id) {
        return $this->find($this->table, $id);
    }

    // Méthode pour supprimer un utilisateur
    public function deleteUser($id) {
        return $this->delete($this->table, $id);
    }

    // Méthode pour ajouter un utilisateur
    public function addUser($data) {
        return $this->insert($this->table, $data);
    }

    // Méthode pour mettre à jour un utilisateur
    public function updateUser($data, $id) {
        return $this->update($this->table, $data, $id);
    }
}





public function getDiagnosticBySymptomes(array $symptomes) {
    try {
        // Trier et convertir en une chaîne pour comparaison
        sort($symptomes);
        $symptomes_str = implode(',', $symptomes);

        $stmt = self::$db->prepare(
            "SELECT 
                d.nom AS nom_diagno, 
                p.conseil AS precaution, 
                GROUP_CONCAT(DISTINCT s.code ORDER BY s.code SEPARATOR ',') AS symptomes_code 
            FROM diagnostic d
            INNER JOIN regles r ON d.code = r.code_diagno
            INNER JOIN bases b ON r.code = b.code_regle
            INNER JOIN symptome s ON b.code_symptome = s.code
            LEFT JOIN precaution p ON d.code = p.code_diagno
            GROUP BY d.code, d.nom, p.conseil"
        );

        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Vérifier si les symptômes correspondent exactement à un diagnostic
        foreach ($results as $row) {
            if ($row['symptomes_code'] === $symptomes_str) {
                return [
                    'diagnostic' => $row['nom_diagno'],
                    'precaution' => $row['precaution'] ?? 'Aucune précaution disponible'
                ];
            }
        }

        // Aucun diagnostic exact trouvé
        return ['message' => 'Aucun diagnostic trouvé pour ces symptômes.'];

    } catch (\PDOException $e) {
        die('Erreur SQL : ' . $e->getMessage());
    }
}




?>
// typed with animation AutoTyping

<script src="https://cdn.jsdelivr.net/npm/auto-typing@1.0.5/dist/AutoTyping.min.js"></script>

<h1 id="autoTyping"></h1>

<script>
  const autoTyping = new AutoTyping("#autoTyping", ["Hello", "Bienvenue", "RDC!"], {
    typeSpeed: 100,
    deleteSpeed: 50,
    waitBeforeDelete: 2000,
    waitBetweenWords: 1000,
    fadeOut: true
  });

  autoTyping.start();
</script>



//typed with more animation textillate
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lettering.js/0.6.1/jquery.lettering.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/textillate/0.4.0/jquery.textillate.min.js"></script>

<h1 class="animated-text">Hello World!</h1>

<script>
  $(document).ready(function () {
    $('.animated-text').textillate({
      in: { effect: 'fadeInLeft', shuffle: true },
      out: { effect: 'fadeOutRight', shuffle: true },
      loop: true
    });
  });
</script>








<?php
// Heure et date en js la transformatio de timestanp
var temps = (donnees[0].temps);
temps = temps * 1000;
const date = new Date(temps);

$('#date').text(date.toLocaleString("fr-FR", {dateStyle: "short"}));
$('#heure').text(date.toLocaleString("fr-FR", {timeStyle: "short"}));
$('#total').text(donnees[0].total);