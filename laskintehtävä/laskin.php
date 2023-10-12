<?php
$result = "";
if(
    !empty($_GET['number1']) &&
    !empty($_GET['number2']) &&
    !empty($_GET['operation'])
){
    // $number1 = filter_input(INPUT_GET, "number1", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $number1 = $_GET["number1"];
    $number2 = $_GET["number2"];
    $operation = $_GET["operation"];

    switch ($operation) {
        case 'sum':
            $result = sum($number1, $number2);
        break;
        
        case 'sub':
         $result = sub($number1, $number2);
        break;

        case 'multi':
        $result = multi($number1, $number2);
        break;

        case 'div':
        $result = div($number1, $number2);
        break;

        case 'pow':
        $result = power($number1, $number2);
        break;

        case 'root':
        $result = root($number1, $number2);
        break;

        default:
        $result;
        break;
    }
}

// if($operation == "sum"){
//     $result = $number1 + $number2;
//     echo $result;
// }

// if($operation == "sub"){
//     $result = $number1 - $number2;
//     echo $result;
// }

// if($operation == "root"){
//     $result = $number1 ** (1/$number2);
//     echo $result;
// }

// if($operation == "multi"){
//     $result = $number1 * $number2;
//     echo $result;
// }

// if($operation == "pow"){
//     $result = $number1 ** $number2;
//     echo $result;
// }

// if($operation == "div"){
//     $result = $number1 / $number2;
//     echo $result;
// }


//Funktio
function sum($number1, $number2) {
    $result = $number1 + $number2;
    return $result;
}

function sub($number1, $number2) {
    $result = $number1 - $number2;
    return $result;
}

function root($number1, $number2) {
return pow($number1, (1/$number2));
}

function multi($number1, $number2) {
    return $number1 * $number2;
}

function power($number1, $number2) {
    return pow($number1, $number2);
}

function div($number1, $number2) {
    return $number1 / $number2;
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="laskin.php" method="get">
    <label for="numb1">Numero 1</label>
    <input type="number" name="number1">
    <label for="numb2">Numero 2</label>
    <input type="number" name="number2">
    <br>
    <label for="calc">Toimenpide</label>
    <select type="text" name="operation" id="operation">
        <option value="sum">Yhteenlasku</option>
        <option value="sub">Vähennys</option>
        <option value="root">Neliöjuuri</option>
        <option value="multi">Kertolasku</option>
        <option value="pow">Potenssiin</option>
        <option value="div">Jakaminen</option>
    </select>
    <input type="submit" value="Laske">
</form>
    <?php echo $result; ?>
</body>
</html>

