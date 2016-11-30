<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit49b1f14450695aaaf99163e1db7a3ab7
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Yaml\\' => 23,
        ),
        'M' => 
        array (
            'Mni\\FrontYAML\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'Mni\\FrontYAML\\' => 
        array (
            0 => __DIR__ . '/..' . '/mnapoli/front-yaml/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'j' => 
        array (
            'jc21' => 
            array (
                0 => __DIR__ . '/..' . '/jc21/filelist/src',
            ),
        ),
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
        'P' => 
        array (
            'Parsedown' => 
            array (
                0 => __DIR__ . '/..' . '/erusev/parsedown',
            ),
        ),
        'M' => 
        array (
            'Monolog' => 
            array (
                0 => __DIR__ . '/..' . '/monolog/monolog/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit49b1f14450695aaaf99163e1db7a3ab7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit49b1f14450695aaaf99163e1db7a3ab7::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit49b1f14450695aaaf99163e1db7a3ab7::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
