<?php 
   require_once 'connexionBDD.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Nagini Records</title>
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="16x16" href="favicon16.png">
    <link rel="apple-touch-icon" sizes="32x32" href="favicon32.png">
    <meta name="apple-mobile-web-app-title" content="Monitoring">
    <link rel="apple-touch-startup-image" href="/onepage.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <script src="https://cdn.socket.io/4.4.1/socket.io.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
</head>
<body>

<header>
    <div class="head_button">
        <button class="button-62">
            <span class="material-symbols-outlined">
                humidity_percentage
            </span>
                <?php
                    $sql_hygrometrie="SELECT * FROM nagini.hygrometrie ORDER BY id DESC LIMIT 1;"; 
        
                    $res_hygrometrie=$pdo->query($sql_hygrometrie);
                    $hygrometrie_resu = $res_hygrometrie->fetchAll();
                    foreach($hygrometrie_resu as $hygrometrie){
                        // while( true ) {
                            print('<h4>'.$hygrometrie['valeur'].'%</h4>');
                        // }
                    }
                ?>
        </button>
        <button class="button-62">
            <span class="material-symbols-outlined">
                device_thermostat
            </span>
                <?php
                    $sql_temperature="SELECT * FROM nagini.temperature ORDER BY id DESC LIMIT 1;"; 
        
                    $res_temperature=$pdo->query($sql_temperature);
                    $temperature_resu = $res_temperature->fetchAll();
                    foreach($temperature_resu as $temperature){
                        print('<h4>'.$temperature['valeur'].'°C</h4>');
                    }
                ?>
        </button>
    </div>

    <div class="head_log">
        <?php                
                                    if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                                        print'
                                            <a href="logout.php">
                                                <button class="button-62" role="button">Deconnexion</button>
                                            </a>';

                                    }else{
                                        print'<a href="connection.php" id="connection_a">
                                            <button class="button-62" role="button">Connexion</button>
                                        </a>';
                                        
                                    }
        ?>
    </div>

        
</header>
    
<div class="background">
    <?php
        try{
            $result = $pdo->query("SELECT id, CONCAT(MONTH(date), '-', DAY(date)) as date, poids_g FROM nagini.poids ORDER BY date ASC LIMIT 10;");
            if($result->rowCount() > 0){
                $poids_g = array();
                $date = array();
                while($row = $result->fetch()) {
                    $poids_g[] = $row["poids_g"];
                    $date[] = $row["date"];
                }
            unset($result);
            } else {
                echo "No records matching your query were found.";
            }
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
    ?>

<?php
        try{
            $result2 = $pdo->query("SELECT id, CONCAT(MONTH(date), '-', DAY(date)) as date, taille FROM nagini.taille ORDER BY date ASC LIMIT 10;");
            if($result2->rowCount() > 0){
                $taille = array();
                $date2 = array();
                while($row2 = $result2->fetch()) {
                    $taille[] = $row2["taille"];
                    $date2[] = $row2["date"];
                }
            unset($result2);
            } else {
                echo "No records matching your query were found.";
            }
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
    ?>
    

    <!-- ------------------------------------------------------- -->
    <h1>Nagini</h1>
   
    <div class="content">
        <div class="container">
            <div class="poids">
                <?php
                if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                    print('<canvas onclick="location.href=\'/data/data_poids.php\';" id="poidsChart"></canvas>');

                }else{
                    print'<canvas id="poidsChart"></canvas>';
                    
                }?>   
            </div>
            
            <?php
            if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                print('<div onclick="location.href=\'/data/data_mues.php\';" class="mues">');

            }else{
                print'<div class="mues">';
                
            }?>
                <h2>Dernières Mues</h2>
                <ul>
                <?php
                $sql_mues="SELECT * FROM nagini.mues ORDER BY date DESC LIMIT 10;"; 
    
                $res_mues=$pdo->query($sql_mues);
                $mues_resu = $res_mues->fetchAll();
                foreach($mues_resu as $mues){
                    print('<li>Le '.$mues["date"].'</li>');
                }
                ?>
                </ul>
            </div>

            <?php
            if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                print('<div onclick="location.href=\'/data/data_humidification.php\';" class="humidification">');

            }else{
                print'<div class="humidification">';
                
            }?>
            <h2>Dernieres humidifications</h2>
                <ul>
                <?php
                $sql_humidification="SELECT * FROM nagini.humidification ORDER BY dateheure DESC LIMIT 10;"; 
    
                $res_humidification=$pdo->query($sql_humidification);
                $humidification_resu = $res_humidification->fetchAll();
                foreach($humidification_resu as $humidification){
                    print('<li>Le '.$humidification["dateheure"].'</li>');
                }
                ?>
                </ul>
            </div>

            <div class="taille">
                <?php
                if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                    print('<canvas onclick="location.href=\'/data/data_taille.php\';" id="tailleChart"></canvas>');

                }else{
                    print'<canvas id="tailleChart"></canvas>';
                    
                }?>  
            </div>

            <?php
            if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                print('<div onclick="location.href=\'/data/data_sorties.php\';" class="sorties">');

            }else{
                print'<div class="sorties">';
                
            }?>
            <h2>Sorties</h2>
                <ul>
                <?php
                $sql_sorties="SELECT * FROM nagini.sorties ORDER BY dateheure DESC LIMIT 10;"; 
    
                $res_sorties=$pdo->query($sql_sorties);
                $sorties_resu = $res_sorties->fetchAll();
                foreach($sorties_resu as $sorties){
                    print('<li>Le '.$sorties["dateheure"].'</li>');
                }
                ?>
                </ul>
            </div>

            <?php
            if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                print('<div onclick="location.href=\'/data/data_defection.php\';" class="defections">');

            }else{
                print'<div class="defections">';
                
            }?>
            
            <h2>Dernieres déféctions</h2>
                <ul>
                <?php
                $sql_defections="SELECT * FROM nagini.defections ORDER BY date DESC LIMIT 10;"; 
    
                $res_defections=$pdo->query($sql_defections);
                $defections_resu = $res_defections->fetchAll();
                foreach($defections_resu as $defections){
                    print('<li>Le '.$defections["date"].'</li>');
                }
                ?>
                </li>
            </div>

            <?php
            if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                print('<div onclick="location.href=\'/data/data_eau.php\';" class="eau">');

            }else{
                print'<div class="eau">';
                
            }?>
            <h2>Derniers Changement Eau</h2>
                <ul>
                <?php
                $sql_eau="SELECT * FROM nagini.eau ORDER BY dateheure DESC LIMIT 10;"; 
    
                $res_eau=$pdo->query($sql_eau);
                $eau_resu = $res_eau->fetchAll();
                foreach($eau_resu as $eau){
                    print('<li>Le '.$eau["dateheure"].'</li>');
                }
                ?>
                </ul>
            </div>

            <?php
            if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                print('<div onclick="location.href=\'/data/data_nourrissage.php\';" class="nourrissage">');

            }else{
                print'<div class="nourrissage">';
                
            }?>
            <h2>Dernier nourrissage</h2>
                <ul>
                <?php
                $sql_nourrissage="SELECT * FROM nagini.nourrisage ORDER BY dateheure DESC LIMIT 10;"; 
    
                $res_nourrissage=$pdo->query($sql_nourrissage);
                $nourrissage_resu = $res_nourrissage->fetchAll();
                foreach($nourrissage_resu as $nourrissage){
                    print('<li>Le '.$nourrissage["dateheure"].' avec '.$nourrissage["type_aliment"].'</li>');
                }
                ?>
                </ul>
            </div>

            <?php
            if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                print('<div onclick="location.href=\'/data/data_nettoyage.php\';" class="nettoyage">');

            }else{
                print'<div class="nettoyage">';
                
            }?>
            <h2>Dernier nettoyage</h2>
                <ul>
                <?php
                $sql_nettoyage="SELECT * FROM nagini.nettoyage ORDER BY date DESC LIMIT 10;"; 
    
                $res_nettoyage=$pdo->query($sql_nettoyage);
                $nettoyage_resu = $res_nettoyage->fetchAll();
                foreach($nettoyage_resu as $nettoyage){
                    print('<li>Le '.$nettoyage["date"].'</li>');
                }
                ?>
                </ul>
            </div>

            <div class="hygrometrie">
                <h2>hygrometrie en temps réel</h2>
                <video id="video" width="100" height="100" autoplay></video>
            </div>

            <div class="void">
            </div>

            <div class="temperature">
                <h2>Temperature en temps réel</h2>
            </div>

            <?php
            if(isset($_SESSION["user"]) && !empty($_SESSION["user"])){
                print('<div onclick="location.href=\'/data/data_observations.php\';" class="notes">');

            }else{
                print'<div class="notes">';
                
            }?>
            <h2>Notes</h2>
                <ul>
                <?php
                $sql_observations="SELECT * FROM nagini.observation ORDER BY dateheure DESC LIMIT 10;"; 
    
                $res_observations=$pdo->query($sql_observations);
                $observations_resu = $res_observations->fetchAll();
                foreach($observations_resu as $observations){
                    print('<li>Le '.$observations["dateheure"].': '.$observations["observation"].'</li>');
                }
                ?>
                </ul>
            </div>

        </div>
    </div>
 </div>



 <!-- ------------------------------------ -->
    
<script>
            Chart.defaults.global.responsive = true;
        // Example datasets for X and Y-axes
        var date = <?php echo json_encode($date); ?>; //Stays on the X-axis 
        var poids = <?php echo json_encode($poids_g); ?>; //Stays on the Y-axis 
        // Setup Block
            const data = {
                    labels: date, //X-axis data 
                    datasets: [{
                    data: poids, //Y-axis data 
                    backgroundColor: '#36A2EB80',
                    borderColor: '#36A2EB80',
                    fill: false, //Fills the curve under the line with the babckground color. It's true by default 
                }]
            }

        // Config Block
            const config = {
                type: 'line', //Declare the chart type
                data : data,
                options: {
                    maintainAspectRatio : false,
                    legend: {
                        display: false,
                        //Remove the legend box by setting it to false. It's true by default.
                    },
                    title : {
                        display : true,
                        text : 'Poids'
                    },
                }
            }

        // Render Block
            const poidsChart = new Chart(
                document.getElementById('poidsChart'),
                config
            );


        Chart.defaults.global.responsive = true;
        // Example datasets for X and Y-axes
        var dateTaille = <?php echo json_encode($date2); ?>; //Stays on the X-axis 
        var taille = <?php echo json_encode($taille); ?>; //Stays on the Y-axis 
        // Setup Block
            const data2 = {
                    labels: dateTaille, //X-axis data 
                    datasets: [{
                    data: taille, //Y-axis data 
                    backgroundColor: '#36A2EB80',
                    borderColor: '#36A2EB80',
                    fill: false, //Fills the curve under the line with the babckground color. It's true by default 
                }]
            }

        // Config Block
            const config2 = {
                type: 'line', //Declare the chart type
                data : data2,
                options: {
                    maintainAspectRatio : false,
                    legend: {
                        display: false,
                        //Remove the legend box by setting it to false. It's true by default.
                    },
                    title : {
                        display : true,
                        text : 'Taille'
                    },
                }
            }

        // Render Block
            const tailleChart = new Chart(
                document.getElementById('tailleChart'),
                config2
            );

        //actualisation
             setInterval(function(){
             location.reload()
         }, 10 * 1000);

        //websocket
        <script>
         const socket = io();
         const peerConnection = new RTCPeerConnection();
         peerConnection.createOffer()
            .then(offer => {
               return peerConnection.setLocalDescription(offer);
            })
            .then(() => {
               const offer = peerConnection.localDescription;
               socket.emit('offer', offer);
            });
         socket.on('answer', answer => {
            peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
         });
         peerConnection.ontrack = event => {
            const video = document.getElementById('video');
            video.srcObject = event.streams[0];
         };
      </script>
</script>
            <?php unset($pdo); ?>

</body>
</html>