<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3367cd001e5a0b1c39a8a814d85a130b
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'App\\Controller\\BookController' => __DIR__ . '/../..' . '/src/Controller/BookController.php',
        'App\\Enum\\Genre' => __DIR__ . '/../..' . '/src/Enum/Genre.php',
        'App\\Model\\Book' => __DIR__ . '/../..' . '/src/Model/Book.php',
        'App\\Model\\Dbh' => __DIR__ . '/../..' . '/src/Model/Dbh.php',
        'App\\View\\BookView' => __DIR__ . '/../..' . '/src/View/BookView.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3367cd001e5a0b1c39a8a814d85a130b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3367cd001e5a0b1c39a8a814d85a130b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3367cd001e5a0b1c39a8a814d85a130b::$classMap;

        }, null, ClassLoader::class);
    }
}