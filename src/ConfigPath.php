<?php
/**
 * CRM library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Crm;

use XdgBaseDir\Xdg;

class ConfigPath
{
    /**
     * The config dir
     * @var string
     */
    protected static $homeConfigDir;

    /**
     * Gets the config dir of the current user
     * @return string
     */
    public static function getHomeConfigDir()
    {
        if (static::$homeConfigDir) {
            return static::$homeConfigDir;
        }
        if (static::isWindows()) {
            // @codeCoverageIgnoreStart
            if (!getenv('APPDATA')) {
                throw new \RuntimeException('The APPDATA environment variable must be set for crm to run correctly');
            }
            $homeConfigDir = rtrim(strtr(getenv('APPDATA'), '\\', '/'), '/') . '/ComposerRegistryManager';
            //codeCoverageIgnoreEnd
        } else {
            $homeConfigDir = (new Xdg())->getHomeConfigDir() . '/composer-registry-manager';
        }
        return static::$homeConfigDir = $homeConfigDir;
    }

    /**
     * Checks whether the os is windows
     * @return bool
     */
    public static function isWindows()
    {
        return DIRECTORY_SEPARATOR == '\\';
    }

    /**
     * Get default config json file
     * @return string
     */
    public static function getDefaultConfigFile()
    {
        return __DIR__ . '/../crm.default.json';
    }

    /**
     * Get configuration file of the user
     * @return string
     */
    public static function getUserConfigFile()
    {
        return static::getHomeConfigDir() . '/crm.json';
    }
}
