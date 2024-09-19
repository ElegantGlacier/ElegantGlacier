<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit692d27fa54bac4e0252f4728ba25f4ac
{
    public static $files = array (
        '6f6de9ad01d31181e11a109f6f52534c' => __DIR__ . '/../..' . '/src/ElegantGlacier.php',
    );

    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'ElegantGlacier\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ElegantGlacier\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit692d27fa54bac4e0252f4728ba25f4ac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit692d27fa54bac4e0252f4728ba25f4ac::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit692d27fa54bac4e0252f4728ba25f4ac::$classMap;

        }, null, ClassLoader::class);
    }
}