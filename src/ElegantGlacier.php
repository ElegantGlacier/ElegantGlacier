<?php
namespace ElegantGlacier;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class ElegantGlacier {
    private static $twig;

    public static function init($path) {
        $loader = new FilesystemLoader($path . '/templates');
        self::$twig = new Environment($loader, [
//            'cache' => $path . '/cache',
        ]);

        self::$twig->addFunction(new TwigFunction('asset', function ($path) {
            // Adjust base URL if needed
            return '/wp-content/themes/' . $path;
        }));
    }

    public static function render($template, $context = []) {
        return self::$twig->render($template, $context);
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

    public static function PostType($name, $args = []) {
            $defaultArgs = [
                'labels' => [
                    'name' => ucfirst($name),
                    'singular_name' => ucfirst($name),
                ],
                'public' => true,
                'has_archive' => true,
                'rewrite' => ['slug' => $name],
                'supports' => ['title', 'editor', 'thumbnail'],
            ];
    
            $args = array_merge($defaultArgs, $args);
    
            add_action('init', function() use ($name, $args) {
                register_post_type($name, $args);
            });
    }
    
}

// Ensure that this file's functions are globally accessible

class_alias('ElegantGlacier\\ElegantGlacier', 'ElegantGlacier');


