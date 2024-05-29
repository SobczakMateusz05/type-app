<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Euro2024 Wyniki Typów</title>
    <link rel="stylesheet" href="css/game.css">
</head>
<body>
    <header>
        <button onclick="typing()">Ekran typowania</button>
        <button onclick="gamescore()">Wyniki meczów</button>
        <?php
            if($_SESSION["type"]=="admin")    
            echo '<button onclick="adminpanel()">Panel Admina</button>';
        ?>
        <button onclick="logout()">Wyloguj się</button>
    </header>
    <main>
        <h1>Wyniki typowania</h1>
        <table>
            <tr>
                <th>Osoba</th>
                <th>Trafione</th>
                <th>oddane głosy</th>
            </tr>
            <?php
                require_once("php/connect.php");

                $sql = "SELECT o.id_osoby, o.imie FROM osoby as o";
                $result = $conn -> query($sql);
                while($row=$result->fetch_assoc()){
                   echo "<tr> <td>" . $row["imie"] . "</td>";
                   $id = $row["id_osoby"];
                   $sql2 =  "SELECT Count(*) as liczba FRom wyniki as w join typy as t on t.id_meczu=w.id_meczu WHERE t.typ = w.wynik AND t.id_osoby=$id";
                   $result2 = $conn -> query($sql2);
                   $row2=$result2->fetch_assoc();
                   echo "<td>". $row2["liczba"]. "</td>";
                   $sql3 = "SELECT COUNT(*) as liczba FROM typy as t WHERE t.id_osoby=$id";
                   $result3= $conn->query($sql3);
                   $row3=$result3->fetch_assoc();
                   echo "<td>". $row3["liczba"] . "</td></tr>";
                }
            ?>
        </table>
    </main>
</body>
</html>