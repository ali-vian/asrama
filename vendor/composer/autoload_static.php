<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit505345ae35d477c67c6505ea16e998de
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit505345ae35d477c67c6505ea16e998de::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit505345ae35d477c67c6505ea16e998de::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit505345ae35d477c67c6505ea16e998de::$classMap;

        }, null, ClassLoader::class);
    }
}
