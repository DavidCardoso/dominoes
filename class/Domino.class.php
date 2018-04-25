<?php 
/**
* Domino Class
*/
class Domino
{
	private $tiles;
	private $stock;
	private $board;

	/**
	 * Domino class constructor
	 *
	 * @param      integer  $maxValue  The maximum value
	 */
	function __construct(int $maxValue = 6)
	{
		$this->generateTiles($maxValue);
		$this->draw($this->tiles, $this->stock, ($maxValue+1)*2);
		// $this->makeMove(0);
	}

	/**
	 * Generate the tiles.
	 *
	 * @param      integer  $maxValue  The maximum value
	 */
	private function generateTiles(int $maxValue): void
	{
		for ($i=$maxValue; $i >=0; $i--) { 
			for ($j=$i; $j >=0; $j--) { 
				$this->tiles[] = [$i,$j];
			}
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
	 * Draw tiles from an array to another
	 *
	 * @param      array    $source  The source
	 * @param      array    $target  The target
	 * @param      integer  $qty     The quantity
	 */
	function draw(array &$source, array &$target, int $qty): void
	{
		for ($i=0; $i < $qty; $i++) { 
			$target[] = array_pop($source);
		}
	}


}
?>
