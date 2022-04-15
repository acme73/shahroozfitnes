<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitb02e05d3a98a189d56959c2ad8a99d62
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitb02e05d3a98a189d56959c2ad8a99d62', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitb02e05d3a98a189d56959c2ad8a99d62', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitb02e05d3a98a189d56959c2ad8a99d62::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
