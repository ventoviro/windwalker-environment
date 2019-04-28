<?php declare(strict_types=1);
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    LGPL-2.0-or-later
 */

namespace Windwalker\Environment;

/**
 * The Platform class.
 *
 * @since  2.0
 */
class Platform
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
     * Property globals.
     *
     * @var  array
     */
    protected $server = [];

    /**
     * Platform constructor.
     *
     * @param array $server
     */
    public function __construct(array $server = [])
    {
        $this->server = $server ?: $_SERVER;
    }

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
        if (!$this->os) {
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
        return $this->getOS() === 'WIN';
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
        $unames = [
            'CYG',
            'DAR',
            'FRE',
            'HP-',
            'IRI',
            'LIN',
            'NET',
            'OPE',
            'SUN',
            'UNI',
        ];

        return in_array($this->getOS(), $unames);
    }

    /**
     * isLinux
     *
     * @return  bool
     */
    public function isLinux()
    {
        return $this->getOS() === 'LIN';
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
        return $this->getServerParam('DOCUMENT_ROOT');
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

        $wdir = $this->getWorkingDirectory();

        $file = $this->getServerParam($key);

        if (strpos($file, $wdir) === 0) {
            $file = substr($file, strlen($wdir));
        }

        $file = trim($file, '.' . DIRECTORY_SEPARATOR);

        if ($full && $this->isCli()) {
            $file = $wdir . DIRECTORY_SEPARATOR . $file;
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
        if ($withParams) {
            return $this->getServerParam('REQUEST_URI');
        }

        return $this->getServerParam('PHP_SELF');
    }

    /**
     * getHost
     *
     * @return  string
     */
    public function getHost()
    {
        return $this->getServerParam('HTTP_HOST');
    }

    /**
     * getPort
     *
     * @return  string
     */
    public function getPort()
    {
        return $this->getServerParam('SERVER_PORT');
    }

    /**
     * getScheme
     *
     * @return  string
     */
    public function getScheme()
    {
        return $this->getServerParam('REQUEST_SCHEME');
    }

    /**
     * getServerParam
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return  mixed
     */
    protected function getServerParam($key, $default = null)
    {
        if (isset($this->server[$key])) {
            return $this->server[$key];
        }

        return $default;
    }
}
