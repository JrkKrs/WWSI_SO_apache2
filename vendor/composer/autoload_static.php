<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit344273629e544be2b74eaeb64abe5eb2
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Contao\\ComponentsInstaller\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Contao\\ComponentsInstaller\\' => 
        array (
            0 => __DIR__ . '/..' . '/contao-components/installer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit344273629e544be2b74eaeb64abe5eb2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit344273629e544be2b74eaeb64abe5eb2::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
