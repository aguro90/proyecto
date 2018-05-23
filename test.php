<?php
/*
$salida = shell_exec('ls -lart');
echo "<pre>$salida</pre>";


echo "hola";
*/
echo "<div id='div1'>text</div>"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title></title>
    <script src="js/jquery1.3.2/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#div1').click(function () {
                alert('I clicked');
            });
        });
</script>
</head>
<body>

</body>
</html>

