<?php
$env = $_GET['env'] ?? 'pro';
if ($env !== 'pro') {
	ini_set( 'display_errors', '1' );
}
ini_set( 'memory_limit', '256M' );

require_once '../class/Domino.class.php';

$players = ['Celina', 'David'];
$domino = new Domino($players);
?>
<h2>Players</h2>
<div>
	<?php foreach ($players as $key => $value): ?>
	<p>
		<?php printf('%d) %s', $key+1, $value); ?>
	</p>
	<?php endforeach; ?>
</div>

<h3><?php echo $domino->startGame(); ?></h2>
<div>
	<?php 
		do {
			foreach ($players as $value) {
				do {
					list($played, $msg) = $domino->play($value);
					printf('<p>%s</p>', $msg);
				} while (!$played && !$domino->getTie());
				if ($domino->getWinner() === '') {
					printf('<p>%s</p>', $domino->printBoard());
				}
			}
		} while ($domino->getWinner() === '' && !$domino->getTie());
	?>
</div>

<h3><?php echo $domino->getWinner(); ?></h3>
