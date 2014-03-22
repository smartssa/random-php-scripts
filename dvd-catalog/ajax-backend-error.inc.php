<?php

$notice .= "Something Broke";
$return_value = <<<EOT
<?xml version="1.0" standalone="yes"?>
<movie>
	<id>{$id}</id>
	<nextid>{$nextid}</nextid>
	<previd>{$previd}</previd>
	<name>{$name}</name>
	<year>{$year}</year>
	<notice>{$notice}</notice>
</movie>
EOT;

?>
