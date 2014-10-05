<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Environment;

/**
 * The Server class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class Server implements ServerInterface
{
	/**
	 * Property os.
	 *
	 * @var string
	 */
	protected $os;

	/**
	 * Property uname.
	 *
	 * @var  string
	 */
	protected $uname = PHP_OS;

	/**
	 * isWeb
	 *
	 * @return  boolean
	 */
	public function isWeb()
	{
		return PhpHelper::isWeb();
	}

	/**
	 * isCli
	 *
	 * @return  boolean
	 */
	public function isCli()
	{
		return PhpHelper::isCli();
	}

	/**
	 * getOS
	 *
	 * @see  https://gist.github.com/asika32764/90e49a82c124858c9e1a
	 *
	 * @return  string
	 */
	public function getOS()
	{
		if (!$this->os)
		{
			// Detect the native operating system type.
			$this->os = strtoupper(substr($this->uname, 0, 3));
		}

		return $this->os;
	}

	/**
	 * isWin
	 *
	 * @return  bool
	 */
	public function isWin()
	{
		return $this->getOS() == 'WIN';
	}

	/**
	 * isUnix
	 *
	 * @see  https://gist.github.com/asika32764/90e49a82c124858c9e1a
	 *
	 * @return  bool
	 */
	public function isUnix()
	{
		$unames = array(
			'CYG',
			'DAR',
			'FRE',
			'HP-',
			'IRI',
			'LIN',
			'NET',
			'OPE',
			'SUN',
			'UNI'
		);

		return in_array($this->getOS(), $unames);
	}

	/**
	 * isLinux
	 *
	 * @return  bool
	 */
	public function isLinux()
	{
		return $this->getOS() == 'LIN';
	}

	/**
	 * Method to set property os
	 *
	 * @param   string $os
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setOS($os)
	{
		$this->os = $os;

		return $this;
	}

	/**
	 * Method to get property Uname
	 *
	 * @return  string
	 */
	public function getUname()
	{
		return $this->uname;
	}

	/**
	 * Method to set property uname
	 *
	 * @param   string $uname
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setUname($uname)
	{
		$this->uname = $uname;

		return $this;
	}

	/**
	 * getWorkingDirectory
	 *
	 * @return  string
	 */
	public function getWorkingDirectory()
	{
		return getcwd();
	}

	/**
	 * getRoot
	 *
	 * @param bool $full
	 *
	 * @return  string
	 */
	public function getRoot($full = true)
	{
		return dirname($this->getEntry($full));
	}

	/**
	 * getDocumentRoot
	 *
	 * @return  string
	 */
	public function getServerPublicRoot()
	{
		return $this->getGlobals('_SERVER', 'DOCUMENT_ROOT');
	}

	/**
	 * getEntry
	 *
	 * @param   bool $full
	 *
	 * @return  string
	 */
	public function getEntry($full = true)
	{
		$key = $full ? 'SCRIPT_FILENAME' : 'SCRIPT_NAME';

		$file = $this->getGlobals('_SERVER', $key);

		if ($full && $this->isCli())
		{
			$file = trim($file, '.' . DIRECTORY_SEPARATOR);

			$file = $this->getWorkingDirectory() . DIRECTORY_SEPARATOR . $file;
		}

		return $file;
	}

	/**
	 * getRequestUri
	 *
	 * @param   bool $withParams
	 *
	 * @return  string
	 */
	public function getRequestUri($withParams = true)
	{
		if ($withParams)
		{
			return $this->getGlobals('_SERVER', 'REQUEST_URI');
		}

		return $this->getGlobals('_SERVER', 'PHP_SELF');
	}

	/**
	 * getGlobals
	 *
	 * @param string $type
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return  mixed
	 */
	protected function getGlobals($type, $key, $default = null)
	{
		if (!isset($GLOBALS['_SERVER']))
		{
			$GLOBALS['_SERVER'] = $_SERVER;
		}

		if (isset($GLOBALS[$type][$key]))
		{
			return $GLOBALS[$type][$key];
		}

		return $default;
	}
}
