<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite246d1b494d7f8b66b3a0eb864ed17ce
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '0d59ee240a4cd96ddbb4ff164fccea4d' => __DIR__ . '/..' . '/symfony/polyfill-php73/bootstrap.php',
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        'cf97c57bfe0f23854afd2f3818abb7a0' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/create_uploaded_file.php',
        '9bf37a3d0dad93e29cb4e1b1bfab04e9' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/marshal_headers_from_sapi.php',
        'ce70dccb4bcc2efc6e94d2ee526e6972' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/marshal_method_from_sapi.php',
        'f86420df471f14d568bfcb71e271b523' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/marshal_protocol_version_from_sapi.php',
        'b87481e008a3700344428ae089e7f9e5' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/marshal_uri_from_sapi.php',
        '0b0974a5566a1077e4f2e111341112c1' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/normalize_server.php',
        '1ca3bc274755662169f9629d5412a1da' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/normalize_uploaded_files.php',
        '40360c0b9b437e69bcbb7f1349ce029e' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/parse_cookie_header.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zend\\Diactoros\\' => 15,
        ),
        'T' => 
        array (
            'Twig\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Php73\\' => 23,
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Contracts\\Service\\' => 26,
            'Symfony\\Component\\Console\\' => 26,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
            'Plasticbrain\\FlashMessages\\' => 27,
        ),
        'D' => 
        array (
            'Doctrine\\ORM\\' => 13,
            'Doctrine\\Instantiator\\' => 22,
            'Doctrine\\DBAL\\' => 14,
            'Doctrine\\Common\\Inflector\\' => 26,
            'Doctrine\\Common\\Collections\\' => 28,
            'Doctrine\\Common\\Cache\\' => 22,
            'Doctrine\\Common\\Annotations\\' => 28,
            'Doctrine\\Common\\' => 16,
        ),
        'B' => 
        array (
            'Blog\\' => 5,
        ),
        'A' => 
        array (
            'Aura\\Router\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zend\\Diactoros\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-diactoros/src',
        ),
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Symfony\\Polyfill\\Php73\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php73',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Contracts\\Service\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/service-contracts',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-factory/src',
            1 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Plasticbrain\\FlashMessages\\' => 
        array (
            0 => __DIR__ . '/..' . '/plasticbrain/php-flash-messages/src',
        ),
        'Doctrine\\ORM\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/orm/lib/Doctrine/ORM',
        ),
        'Doctrine\\Instantiator\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/instantiator/src/Doctrine/Instantiator',
        ),
        'Doctrine\\DBAL\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/dbal/lib/Doctrine/DBAL',
        ),
        'Doctrine\\Common\\Inflector\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/inflector/lib/Doctrine/Common/Inflector',
        ),
        'Doctrine\\Common\\Collections\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/collections/lib/Doctrine/Common/Collections',
        ),
        'Doctrine\\Common\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/cache/lib/Doctrine/Common/Cache',
        ),
        'Doctrine\\Common\\Annotations\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/annotations/lib/Doctrine/Common/Annotations',
        ),
        'Doctrine\\Common\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/common/lib/Doctrine/Common',
            1 => __DIR__ . '/..' . '/doctrine/event-manager/lib/Doctrine/Common',
            2 => __DIR__ . '/..' . '/doctrine/persistence/lib/Doctrine/Common',
            3 => __DIR__ . '/..' . '/doctrine/reflection/lib/Doctrine/Common',
        ),
        'Blog\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Aura\\Router\\' => 
        array (
            0 => __DIR__ . '/..' . '/aura/router/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Lexer\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/lexer/lib',
            ),
        ),
    );

    public static $classMap = array (
        'JsonException' => __DIR__ . '/..' . '/symfony/polyfill-php73/Resources/stubs/JsonException.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite246d1b494d7f8b66b3a0eb864ed17ce::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite246d1b494d7f8b66b3a0eb864ed17ce::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite246d1b494d7f8b66b3a0eb864ed17ce::$prefixesPsr0;
            $loader->classMap = ComposerStaticInite246d1b494d7f8b66b3a0eb864ed17ce::$classMap;

        }, null, ClassLoader::class);
    }
}
