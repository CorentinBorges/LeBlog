<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite68beab964a01bfcfa07f7084c18b22b
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twig\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
        ),
        'M' => 
        array (
            'Models\\' => 7,
        ),
        'F' => 
        array (
            'Framework\\' => 10,
        ),
        'E' => 
        array (
            'Entity\\' => 7,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib/Models',
        ),
        'Framework\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib/Framework',
        ),
        'Entity\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib/Entity',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite68beab964a01bfcfa07f7084c18b22b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite68beab964a01bfcfa07f7084c18b22b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}