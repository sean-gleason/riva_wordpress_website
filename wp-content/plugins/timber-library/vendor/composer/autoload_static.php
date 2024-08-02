<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit26a085621f5e52257dc941d0ca17c6b0
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twig\\' => 5,
            'Timber\\' => 7,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Ctype\\' => 23,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Timber\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/twig/cache-extension/lib',
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
        'R' => 
        array (
            'Routes' => 
            array (
                0 => __DIR__ . '/..' . '/upstatement/routes',
            ),
        ),
    );

    public static $classMap = array (
        'AltoRouter' => __DIR__ . '/..' . '/altorouter/altorouter/AltoRouter.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit26a085621f5e52257dc941d0ca17c6b0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit26a085621f5e52257dc941d0ca17c6b0::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInit26a085621f5e52257dc941d0ca17c6b0::$fallbackDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit26a085621f5e52257dc941d0ca17c6b0::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit26a085621f5e52257dc941d0ca17c6b0::$classMap;

        }, null, ClassLoader::class);
    }
}
