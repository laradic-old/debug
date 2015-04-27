<?php

/**
 * This file is part of the Tracy (http://tracy.nette.org)
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 */

namespace Laradic\Debug\Tracy;

use Tracy;
use Tracy\IBarPanel;


/**
 * IBarPanel implementation helper.
 *
 * @author     David Grudl
 * @internal
 */
class BarPanel implements IBarPanel
{
	private $id;

	public $data;


	public function __construct($id)
	{
		$this->id = $id;
	}


	/**
	 * Renders HTML code for custom tab.
	 * @return string
	 */
	public function getTab()
	{
		ob_start();
		$data = $this->data;
		require __DIR__ . "/BarPanel.php";
		return ob_get_clean();
	}


	/**
	 * Renders HTML code for custom panel.
	 * @return string
	 */
	public function getPanel()
	{
		ob_start();
		if (is_file(__DIR__ . "/{$this->id}.panel.phtml")) {
			$data = $this->data;
			require __DIR__ . "/BarPanel.php";
		}
		return ob_get_clean();
	}

}
