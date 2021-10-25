<?php
$dlxTools = new Dlx_Tools_SpecialChar();
header("Location: ./resultado/".$dlxTools->remove_accents($_POST['termo']));
?>