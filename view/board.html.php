<?php
$env = $_GET['env'] ?? 'pro';
if ($env !== 'pro') {
	ini_set( 'display_errors', '1' );
}
ini_set( 'memory_limit', '256M' );

require_once '../class/Domino.class.php';

$players = ['Celina', 'David'];
$domino = new Domino($players);
$datetime = date("l, F j, Y, g:i A (e)");
?>
<div class="datetime"><?=$datetime;?></div>

<h2>Players</h2>
<div>
	<?php foreach ($players as $key => $value): ?>
	<p>
		<?php printf('%d) %s', $key+1, $value); ?>
	</p>
	<?php endforeach; ?>
</div>

<h3 class="icon start"><?=$domino->startGame();?></h3>
<div>
	<?php 
		do {
			foreach ($players as $value) {
				do {
					list($played, $type, $msg) = $domino->play($value);
					if ($type !== '') {
						printf('<p class="icon %s">%s</p>', $type, $msg);
					}
				} while (!$played && !$domino->getTie());
				if ($domino->getWinner() === '' && !$domino->getTie()) {
					printf('<p class="icon board">%s</p>', $domino->printBoard());
				}
			}
		} while ($domino->getWinner() === '' && !$domino->getTie());
	?>
</div>

<?php 
$winner = $domino->getWinner();
if ($winner !== ''): ?>
<p class="icon board"><?=$domino->printBoard();?></p>
<h3 class="icon winner"><?=$winner;?></h3>
<?php endif; ?>
