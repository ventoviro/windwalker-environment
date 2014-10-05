<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Environment;

/**
 * The Environment class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class Environment
{
	/**
	 * Property server.
	 *
	 * @var  ServerInterface
	 */
	public $server;

	/**
	 * Class init.
	 *
	 * @param ServerInterface $server
	 */
	public function __construct(ServerInterface $server = null)
	{
		$this->server = $server ? : new Server;
	}

	/**
	 * Method to get property Server
	 *
	 * @return  \Windwalker\Environment\ServerInterface
	 */
	public function getServer()
	{
		return $this->server;
	}

	/**
	 * Method to set property server
	 *
	 * @param   \Windwalker\Environment\ServerInterface $server
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setServer($server)
	{
		$this->server = $server;

		return $this;
	}
}
