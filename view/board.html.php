<?php
// ini_set( 'display_errors', '1' );
require_once '../class/Domino.class.php';

$domino = new Domino();
?>
<h2>Board</h2>
<div>
	<?php foreach ($domino->getTiles() as $key => $value): ?>
	<p>
		<?php printf('Tile %s: <%s:%s>', ($key+1), $value[0], $value[1]); ?>
	</p>
	<?php endforeach; ?>
</div>

