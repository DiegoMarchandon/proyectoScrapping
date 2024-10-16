<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit06932e187b383c881b87c6156799fe62
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PhpOffice\\PhpPresentation\\' => 26,
            'PhpOffice\\Common\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PhpOffice\\PhpPresentation\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phppresentation/src/PhpPresentation',
        ),
        'PhpOffice\\Common\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/common/src/Common',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'PclZip' => __DIR__ . '/..' . '/pclzip/pclzip/pclzip.lib.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit06932e187b383c881b87c6156799fe62::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit06932e187b383c881b87c6156799fe62::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit06932e187b383c881b87c6156799fe62::$classMap;

        }, null, ClassLoader::class);
    }
}
