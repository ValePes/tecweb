<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit5fa9bbb7bc3fc114b2c2db6d3f4e04a4
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

        spl_autoload_register(array('ComposerAutoloaderInit5fa9bbb7bc3fc114b2c2db6d3f4e04a4', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit5fa9bbb7bc3fc114b2c2db6d3f4e04a4', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit5fa9bbb7bc3fc114b2c2db6d3f4e04a4::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
