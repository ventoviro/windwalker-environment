<?php declare(strict_types=1);
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    LGPL-2.0-or-later
 */

namespace Windwalker\Environment;

/**
 * The Environment class.
 *
 * @since  2.0
 */
class Environment
{
    /**
     * Property server.
     *
     * @var  Platform
     */
    public $platform;

    /**
     * Class init.
     *
     * @param Platform $platform
     */
    public function __construct(Platform $platform = null)
    {
        $this->platform = $platform ?: new Platform();
    }

    /**
     * Method to get property Server
     *
     * @return  \Windwalker\Environment\Platform
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Method to set property server
     *
     * @param   \Windwalker\Environment\Platform $platform
     *
     * @return  static  Return self to support chaining.
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }
}
