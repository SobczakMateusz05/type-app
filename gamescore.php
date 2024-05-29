<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Euro2024 Wyniki Meczów</title>
    <link rel="stylesheet" href="css/game.css">
</head>
<body>
    <header>
        <button onclick="typing()">Ekran typowania</button>
        <button onclick="typescore()">Wyniki typowania</button>
        <?php
            if($_SESSION["type"]=="admin")    
            echo '<button onclick="adminpanel()">Panel Admina</button>';
        ?>
        <button onclick="logout()">Wyloguj się</button>
    </header>
    <main>
        <h1>Wyniki meczów</h1>
        <table>
            <tr>
                <th>Mecz</th>
                <th>Data</th>
                <th>Wynik</th>
            </tr>
            <?php
                require_once("php/connect.php");

                $sql = "SELECT d.kraj as kraj1, t.kraj as kraj2, m.data, w.wynik FROM wyniki as w join mecze as m on w.id_meczu = m.id_meczu JOIN druzyny as d ON d.id=m.id_druzyna_1 JOIN druzyny as t on t.id=m.id_druzyna_2";
                $result = $conn -> query($sql);
                while($row=$result->fetch_assoc()){
                    echo "<tr><td>" . $row["kraj1"] . " - " . $row["kraj2"] . "</td><td>". $row["data"]. "</td><td>". $row["wynik"] . "</td></tr>";
                }
            ?>
        </table>
    </main>
</body>
</html>