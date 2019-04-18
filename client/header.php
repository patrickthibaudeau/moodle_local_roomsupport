<?php

function printStyles($css = []) {
    $styleSheet = '';
    if (count($css) > 0) {
        for ($i = 0; $i < count($sheets); $i++) {
            $styleSheet .= '<link rel="stylesheet" type="text/css" href="' . $sheets[$i] . '" crossorigin="anonymous"/>' . "\n";
        }
    }
    
    return $styleSheet;
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" crossorigin="anonymous"/>-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/client.css" crossorigin="anonymous"/>
    <?php echo printStyles(); ?>
</head>

