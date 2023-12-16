<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spell Check</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
   <h1>SPELL CHECK</h1>
   <br>
    <form action ="check.php" method="POST">
        <label for="user">Input Word</label>
        <input type="text" id="IW" name="inputWord">
        <br>
        <br>
        <input class="w3-btn w3-blue w3-round" type="submit" value="Submit">
    </form>
    <br>
    <?php
    echo "<p>Suggestions for" . $input . " :</p>";
    ?>
    <table style="width:30%" class="w3-table-all w3-centered">
        <?php
        for ($i = 0; $i < 10; $i++) {
            echo "<tr style='height:40px'><td></td></tr>";
        }
        ?>
    </table>
</body>
</html>