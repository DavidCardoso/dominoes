<?php 
/**
* Domino Class
*/
class Domino
{
	private $tiles = [];
	private $stock = [];
	private $players = [];
	private $board = [];
	private $winner = '';

	/**
	 * Domino class constructor
	 *
	 * @param      array    $namePlayers  The name of the players
	 * @param      integer  $maxValue     The maximum value on the tiles
	 */
	function __construct(array $namePlayers = ['Alice', 'Bob'], int $maxValue = 6)
	{
		$this->generateTiles($maxValue);
		$this->draw($this->tiles, $this->stock, ($maxValue+1)*2);
		foreach ($namePlayers as $value) {
			$this->players[$value] = [];
			$this->draw($this->tiles, $this->players[$value], ($maxValue+1));
		}
	}

	/**
	 * Generates the tiles.
	 *
	 * @param      integer  $maxValue  The maximum value on the tiles
	 */
	private function generateTiles(int $maxValue): void
	{
		for ($i=$maxValue; $i >=0; $i--) { 
			for ($j=$i; $j >=0; $j--) { 
				$this->tiles[] = [$i,$j];
			}
		}
		shuffle($this->tiles);
	}

	/**
	 * Draws tiles from an array to another
	 *
	 * @param      array    $source  The source
	 * @param      array    $target  The target
	 * @param      integer  $qty     The quantity to be drawn
	 */
	function draw(array &$source, array &$target, int $qty = 1): void
	{
		if ($qty > count($source)) {
			$qty = count($source);
		}
		for ($i=0; $i < $qty; $i++) { 
			$target[] = array_pop($source);
		}
	}

	/**
	 * Gets the tiles.
	 *
	 * @return     array  The tiles.
	 */
	function getTiles(): array
	{
		return $this->tiles;
	}

	/**
	 * Gets the stock.
	 *
	 * @return     array  The stock.
	 */
	function getStock(): array
	{
		return $this->stock;
	}

	/**
	 * Gets the board.
	 *
	 * @return     array  The board.
	 */
	function getBoard():array
	{
		return $this->board;
	}

	/**
	 * Gets the winner.
	 *
	 * @return     string  The winner.
	 */
	function getWinner(): string
	{
		return $this->winner;
	}

	/**
	 * Check if there is a winner
	 *
	 * @param      string  $name   The name of the player
	 */
	function checkWinner(string $name): void
	{
		$this->winner = count($this->players[$name]) === 0 ? "Player $name has won!" : '';
	}

	/**
	 * Prints the tile
	 *
	 * @param      array   $tile   The tile
	 *
	 * @return     string  Formatted tile
	 */
	function printTile(array $tile): string
	{
		return '<'.implode($tile, ':').'>';
	}

	/**
	 * Starts the game.
	 *
	 * @return     string  The initial text
	 */
	function startGame(): string
	{
		$this->draw($this->stock, $this->board, 1);
		return 'Game starting with first tile: '.$this->printTile(current($this->getBoard()));
	}

	/**
	 * Adds a tile on the board.
	 *
	 * @param      string   $name     The name of the player
	 * @param      integer  $tileKey  The tile key
	 * @param      array    $tile     The tile
	 * @param      string   $side     The side
	 *
	 * @return     array   Status of the board after the playing
	 */
	function addTileOnTheBoard(string $name, int $tileKey, array $tile, string $side): array
	{
		switch ($side) {
			case 'left':
				unset($this->players[$name][$tileKey]);
				$left = current($this->board);
				array_unshift($this->board, $tile);
				$this->checkWinner($name);
				return [
					true, 
					sprintf('%s plays %s to connect to tile %s on the board.', 
						$name, 
						$this->printTile($tile), 
						$this->printTile($left)
					)
				];
				break;

			case 'right':
				unset($this->players[$name][$tileKey]);
				$right = end($this->board);
				$this->board[] = $tile;
				$this->checkWinner($name);
				return [
					true, 
					sprintf('%s plays %s to connect to tile %s on the board.', 
						$name, 
						$this->printTile($tile), 
						$this->printTile($right)
					)
				];
				break;
			
			default:
				return '';
				break;
		}
	}

	/**
	 * Plays
	 *
	 * @param      string  $name   The name
	 *
	 * @return     array Status of the board after the playing
	 */
	function play(string $name): array
	{
		if ($this->getWinner() != '') {
			return [true, 'The end.'];
		}

		$left = current($this->getBoard())[0];
		$right = end($this->getBoard())[1];

		// check if the player's tiles match with one of the tiles of the board
		foreach ($this->players[$name] as $key => $value) {
			// try LEFT side
			$foundLeft = array_search($left, $value);
			
			if ( $foundLeft === 1) { // add the current tile on the left side
				return $this->addTileOnTheBoard($name, $key, $value, 'left');;
			}
			if ($foundLeft === 0) { // invert the current tile and then add on the left side
				return $this->addTileOnTheBoard($name, $key, array_reverse($value), 'left');;
			}
			// try RIGHT side
			$foundRight = array_search($right, $value);
			
			if ( $foundRight === 0) { // add the current tile on the right
				return $this->addTileOnTheBoard($name, $key, $value, 'right');;
			}
			if ($foundRight === 1) { // invert the current tile and then add on the right side
				return $this->addTileOnTheBoard($name, $key, array_reverse($value), 'right');;
			}
		}

		// else draw from the stock
		return $this->drawFromStock($name);
	}

	function drawFromStock(string $name): array
	{
		$end = empty($this->stock) ? true : false;
		if ($end) {
			return [true, 'Without stock!'];
		}
		$this->draw($this->stock, $this->players[$name], 1);
		array_reverse($this->players[$name]);
		return [
			false, 
			sprintf('%s cannot play, drawing tile %s.', 
				$name, 
				$this->printTile(current($this->players[$name])))
		];
	}

}
?>
