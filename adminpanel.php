<?php
    session_start();
    require_once("php/connect.php");
    if($_SESSION["type"]!="admin"){
        header("location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <header>
        <button onclick="typing()">Ekran typowania</button>
        <button onclick="gamescore()">Wyniki meczów</button>
        <button onclick="typescore()">Wyniki typowania</button>
        <button onclick="logout()">Wyloguj się</button>
    </header>
    <main>
    <h1>Admin Panel</h1>
    <h2>Witaj <?php echo ucfirst($_SESSION["user"]) ?></h2>

    <h3>Dodaj wynik</h3>
    <?php
        if(isset($_GET["score"])&&$_GET["score"]==1){
            echo '<h3 style="color:green;">Dodano wynik</h3>';
            echo '<script>
                if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete("score");
                window.history.replaceState(null, null, url);
                    }
                </script>';
        }
        else if(isset($_GET["score"])&&$_GET["score"]==2){
            echo '<h3 style="color:red;">Błąd dodania wyniku</h3>';
            echo '<script>
                if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete("score");
                window.history.replaceState(null, null, url);
                    }
                </script>';
        }
    ?>
    <form method="POST" action="php/score.php">
        <a>Mecz: </a>
        <select name="game" >
            <option value="0"> Wybierz...</option>
            <?php
                $sql = "SELECT m.id_meczu, d.kraj as kraj1, t.kraj as kraj2, m.data FROM mecze as m left join wyniki as w on w.id_meczu=m.id_meczu join druzyny as d on m.id_druzyna_1=d.id join druzyny as t on t.id=id_druzyna_2 where w.wynik is null ORDER BY data;";

                $result = $conn -> query($sql);

                while($row=$result->fetch_assoc()){
                    echo '<option value="'. $row["id_meczu"]. '">'. $row["kraj1"] . " - ". $row["kraj2"] . " (". $row["data"]. ") </option>";
                }
            ?>
        </select>
        <a>Wynik (1, 0, 2):</a>
        <input type="number" name="score" min="0" max="2" step="1" placeholder="Wynik" required />
        <input type="submit" value="Dodaj">
    </form>
    <h3>Dodaj mecz</h3>
    <?php
        if(isset($_GET["game"])&&$_GET["game"]==1){
            echo '<h3 style="color:green;">Dodano mecz</h3>';
            echo '<script>
                if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete("game");
                window.history.replaceState(null, null, url);
                    }
                </script>';
        }
        else if(isset($_GET["game"])&&$_GET["game"]==2){
            echo '<h3 style="color:red;">Błąd dodania meczu</h3>';
            echo '<script>
                if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete("game");
                window.history.replaceState(null, null, url);
                    }
                </script>';
        }
    ?>
    <form method="POST" action="php/game.php">
        <a>Drużyna 1:</a> 
        <select name="team1">
            <option value="0"> Wybierz...</option>
            <?php
                $sql="SELECT * FROM druzyny ORDER BY kraj";
                $result= $conn -> query($sql);
                while($row=$result->fetch_assoc()){
                    echo '<option value="'. $row["id"] .'">' . $row["kraj"] . '</option>';
                }
            ?>
        </select>
        <a>Druzyna 2:</a>
        <select name="team2">
            <option value="0"> Wybierz...</option>
            <?php
                $sql="SELECT * FROM druzyny ORDER BY kraj";
                $result= $conn -> query($sql);
                while($row=$result->fetch_assoc()){
                    echo '<option value="'. $row["id"] .'">' . $row["kraj"] . '</option>';
                }
            ?>
        </select>
        <a>Data: </a>
        <input type="date" name="date" required>
        <input type="submit" value="Dodaj">
    </form>
    <h3>Dodaj użytkownika</h3>
    <?php
        if(isset($_GET["user"])&&$_GET["user"]==1){
            echo '<h3 style="color:green;">Dodano uzytkownika</h3>';
            echo '<script>
                if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete("game");
                window.history.replaceState(null, null, url);
                    }
                </script>';
        }
    ?>
    <form method="POST" action="php/user.php">
        <a>Imie:</a>
        <input type="text" name="name" placeholder="Imie" required>
        <a>Haslo:</a>
        <input type="password" name="pass" placeholder="Haslo" required>
        <a>Typ konta:</a>
        <div>
            <input type="radio" name="type" value="user" id="user" required>
            <label for="user">Użytkownik</label>
        </div>
        <div>
            <input type="radio" name="type" value="admin" id="admin" required>
            <label for="admin">Administrator</label>
        </div>
        <input type="submit" value="Dodaj">
    </form>
    </main>
<script src="js/admin.js"></script>    
</body>
</html>