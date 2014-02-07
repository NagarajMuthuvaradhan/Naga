<?php
//$tmpfile = tempnam("/tmp", "dompdf_");
//file_put_contents($tmp_file, $smarty->fetch());

$url = "dompdf.php?input_file=" . rawurlencode('Age-verification-reject.html') . 
       "&paper=letter&output_file=" . rawurlencode("My Fancy PDF.pdf");

header("Location: http://" . $_SERVER["HTTP_HOST"] . "/$url");
?>
