<?php
session_start();
// just print the progerss bar. Ajaxified.
print "<div style=\"text-align: center; color: black; background: lightgreen; width: ".($_SESSION['percent'] ? $_SESSION['percent'] : 0 )."%;\"><p>".$_SESSION['percent']."</p></div>";
print date("r");
?>