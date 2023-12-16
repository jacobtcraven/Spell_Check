<?php
$input = $_POST['inputWord'];

function mismatch($c1, $c2){
    if($c1 == $c2){
        return 0;
    }
    else if(($c1 == 'a' || $c1 == 'e' || $c1 == 'i' || $c1 == 'o' || $c1 == 'u') && 
    ($c2 == 'a' || $c2 == 'e' || $c2 == 'i' || $c2 == 'o' || $c2 == 'u')){
        return 1;
    }
    else if(($c1 == 'a' || $c1 == 'e' || $c1 == 'i' || $c1 == 'o' || $c1 == 'u') && 
    ($c2 != 'a' && $c2 != 'e' && $c2 != 'i' && $c2 != 'o' && $c2 != 'u')){
        return 3;
    }
    else if(($c1 != 'a' && $c1 != 'e' && $c1 != 'i' && $c1 != 'o' && $c1 != 'u') && 
    ($c2 == 'a' || $c2 == 'e' || $c2 == 'i' || $c2 == 'o' || $c2 == 'u')){
        return 3;
    }
    else if(($c1 != 'a' && $c1 != 'e' && $c1 != 'i' && $c1 != 'o' && $c1 != 'u') && 
    ($c2 != 'a' && $c2 != 'e' && $c2 != 'i' && $c2 != 'o' && $c2 != 'u')){
        return 1;
    }
    else{
        echo "error in mismatch<br>";
        return 500;
    }}

function scoreCalc($word1, $word2){



    for ($i = 0; $i < strlen($word1); $i++) {
        $word1[$i] = strtolower($word1[$i]);
    }
    for ($i = 0; $i < strlen($word2); $i++) {
        $word2[$i] = strtolower($word2[$i]);
    }

    $o = strlen($word1);
    $p = strlen($word2);

    for ($i = 0; $i < $o; $i++){
        if(ctype_alpha($word1[$i])) {
            $w1 = $w1 . $word1[$i];
        }
    }

    for ($i = 0; $i < $p; $i++){
        if(ctype_alpha($word2[$i])) {
            $w2 = $w2 . $word2[$i];
        }
    }

    $w1 = " " . $w1;
    $w2 = " " . $w2;

    $m = strlen($w1);
    $n = strlen($w2);

    $one = 0;
    $two = 0;
    $three = 0;

    $arr = array();


    for ($i = 0; $i < $m; ++$i){
        for($j = 0; $j < $n; ++$j){
            if ($i == 0){
                $arr[$i][$j] = $j * 2;
            }
            else if ($j == 0){
                $arr[$i][$j] = $i * 2;
            }
            else{
                $one = mismatch($w1[$i],$w2[$j]) + $arr[$i-1][$j-1];
                $two = 2 + $arr[$i-1][$j];
                $three = 2 + $arr[$i][$j-1];
                $arr[$i][$j] = min($one,$two,$three);
            }
        }
    }
    
    return $arr[$m - 1][$n - 1];

}
function suggest($dict, $compare){
    $suggestions = array();


    for($i = 0; $i < count($dict); $i++){
        $pen = scoreCalc($compare, $dict[$i]);
        $suggestions[$dict[$i]] = $pen;
    }


    return $suggestions;
}

$filePath = "./dictionary.txt";

if (file_exists($filePath)) {
    $fileContents = file_get_contents($filePath);
    $fileArr = explode("\n", $fileContents);


} else {
    echo "The file does not exist.";
}

$topScore = array();
$topString = array();

$suggest = suggest($fileArr,$input);

for ($i = 0; $i < 10; $i++) {
    for ($j = 0; $j < count($fileArr) - $i - 1; $j++) {
        if ($suggest[$fileArr[$j]] < $suggest[$fileArr[$j + 1]]) {
            $hold = $fileArr[$j];
            $fileArr[$j] = $fileArr[$j + 1];
            $fileArr[$j + 1] = $hold;
        }
    }
}

for ($i = 0; $i < 10; $i++) {
    $topString[$i] = $fileArr[count($fileArr) - $i - 1];
    $topScore[$i] = $suggest[$fileArr[count($fileArr) - $i - 1]];
}

?>

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
    echo "<p>Suggestions for " . $input . ":</p>";
    ?>
    <table style="width:30%" class="w3-table-all w3-centered">
        <?php
        for ($i = 0; $i < 10; $i++) {
            echo "<tr style='height:40px'><td>". $topString[$i] ."</td></tr>";
        }
        ?>
    </table>
</body>
</html>