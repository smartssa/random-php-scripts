<?php
session_start();
// just print the progerss bar. Ajaxified.
print "<pre>" . $_SESSION['notices'] . "</pre>";
?>
