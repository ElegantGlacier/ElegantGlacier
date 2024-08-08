<?php
namespace ElegantGlacier;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ElegantGlacier {
    private static $twig;

    public static function init($path) {
        $loader = new FilesystemLoader($path . '/templates');
        self::$twig = new Environment($loader, [
            'cache' => $path . '/cache',
        ]);
    }

    public static function render($template, $context = []) {
        echo self::$twig->render($template, $context);
    }

    // Utility functions to wrap WordPress functions
    public static function getTitle() {
        return get_the_title();
    }

    public static function getContent() {
        return get_the_content();
    }

    public static function getPosts($args = []) {
        $query = new \WP_Query($args);
        return $query->posts;
    }
}

// Ensure that this file's functions are globally accessible
class_alias('ElegantGlacier\\ElegantGlacier', 'ElegantGlacier');
