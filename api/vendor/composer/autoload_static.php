<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit61cd422c289f854bbddc4c623b8d4245
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit61cd422c289f854bbddc4c623b8d4245::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit61cd422c289f854bbddc4c623b8d4245::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
