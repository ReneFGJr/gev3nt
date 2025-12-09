<?php
if (isset($class)) {
	$Xlass = $class;
} else {
	$Xlass = 'info';
}
if (isset($message)) {
	echo '<div class="alert alert-'.$Xlass.'">';
	echo $message;
	echo '</div>';
}
