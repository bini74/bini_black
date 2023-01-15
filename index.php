<?php 
    $username = "root";
    $password = "Applepay75";
    $database = "nagini";

    try {
        $pdo = new PDO("mysql:host=localhost;database=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOExeption $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Nagini Records</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
</head>
<body>

    <?php
        try{
            $result = $pdo->query("SELECT * FROM nagini.poids");
            if($result->rowCount() > 0){
                while($row = $result->fetch()){
                    echo $row["poids_g"];
                }
            unset($result);
            } else {
                echo "No records matching your query were found.";
            }
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }

        unset($pdo);
    ?>
  <div class="background">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    
    
    <h1>Nagini Records</h1>

   
    <div class="content">
        <div class="container">
            <div class="poids"> <canvas id="plots"></canvas></div>
            <div class="mues"><p>Derniere mue : <br> 25/07/22</p></div>
            <div class="humidification"></div> 
            <div class="taille"><canvas id="taille"></canvas></div>
            <div class="sorties"><p>Derniere sortie et temps de sortie <br>heure de sortie / heure de couché</p></div>
            <div class="defections"><p>Dernière defection</p></div>
            <div class="eau"><p>Derniere fois qu'il a bu :</p></div>
            <div class="nourrissage"><p>Dernière fois qu'il a été nourri : <br> il y a 5h <br> 23/07/23</p></div>
            <div class="nettoyage"><p>Dernier nettoyage terrarium: <br> 23/07/23</p></div> 
            <div class="notes"><p>Notes</p></div>
        </div>
    </div>
 </div>
    
    
  <script src="/java.js"></script>
  <script src="/script.js"></script>
  <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script></div>

</body>
</html>
