<?php 
/**
* Domino Class
*/
class Domino
{
	private $tiles;
	private $stock;
	private $players;
	private $board;

	/**
	 * Domino class constructor
	 *
	 * @param      array    $namePlayers  The name of the players
	 * @param      integer  $maxValue     The maximum value on the tiles
	 */
	function __construct(array $namePlayers = ['Arye', 'David'], int $maxValue = 6)
	{
		$this->generateTiles($maxValue);
		$this->stock = [];
		$this->draw($this->tiles, $this->stock, ($maxValue+1)*2);
		foreach ($namePlayers as $value) {
			$this->players[$value] = [];
			$this->draw($this->tiles, $this->players[$value], ($maxValue+1));
		}
	}

	/**
	 * Generate the tiles.
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
	 * Gets the player.
	 *
	 * @param      string  $name   The name
	 *
	 * @return     array   The player.
	 */
	function getPlayer(string $name): array
	{
		return $this->players[$name];
	}

	/**
	 * Draw tiles from an array to another
	 *
	 * @param      array    $source  The source
	 * @param      array    $target  The target
	 * @param      integer  $qty     The quantity to be drawn
	 */
	function draw(array &$source, array &$target, int $qty = 1): void
	{
		for ($i=0; $i < $qty; $i++) { 
			$target[] = array_pop($source);
		}
	}


}
?>
