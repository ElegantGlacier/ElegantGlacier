<?php
namespace ElegantGlacier;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ElegantGlacier {
    private static $twig;
    private static $base_path;

    private static $router;

    public static function init($path) {
        $loader = new FilesystemLoader($path . '/vendor/elegant-glacier/elegant-glacier/src');
        self::$base_path = rtrim(parse_url(get_site_url(), PHP_URL_PATH), '/') . '/';
        self::$twig = new Environment($loader, [
//            'cache' => $path . '/cache',
        ]);

        add_action('template_redirect', function() {
            $router = self::getRouterInstance();
            $router->matchClassRoute();
        });
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

    public static function getRouterInstance() {
        if (!isset(self::$router)) {
            self::$router = new Router();
        }
        return self::$router;
    }

    public static function setupDefaultTheme() {
        
        $router = self::getRouterInstance();
        // Define default routes
        $router->addRoute('GET', self::$base_path, 'HomeController@index');
        $router->addRoute('GET', self::$base_path . 'posts', 'PostController@index');
        $router->addRoute('GET', self::$base_path . 'post/:id', 'PostController@show');
        $router->addRoute('GET', self::$base_path . 'pages', 'PageController@index');
        $router->addRoute('GET', self::$base_path . 'page/:id', 'PageController@show');

        // Match and dispatch routes
        // add_action('template_redirect', function() use ($router) {
        //     $router->matchRoute();
        // });
    }

    public static function RegisterCustomPostType($name, $args = []) {
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

    public static function PostType($name, $args = []) {
        // Register the custom post type
        self::RegisterCustomPostType($name, $args);

        // Generate templates, routes, and controller for the custom post type
        self::generateTemplatesForCustomPostType($name);
        self::generateControllerForCustomPostType($name);

        // Add routes for the custom post type
        $router = self::getRouterInstance();
        $router->addRoute('GET', self::$base_path . "$name", ucfirst($name) . 'Controller@index');
        $router->addRoute('GET', self::$base_path . "$name/:id", ucfirst($name) . 'Controller@show');

        // Match and dispatch routes
        add_action('template_redirect', function() use ($router) {
            $router->matchRoute();
        });
    }

    protected static function generateTemplatesForCustomPostType($name) {
        $templatesDir = __DIR__ . "/themes/defaultTheme/templates/";

        // Ensure the templates directory exists
        if (!is_dir($templatesDir)) {
            mkdir($templatesDir, 0755, true);
        }

        // Generate the archive template (e.g., portfolios.twig)
        $archiveTemplate = $templatesDir . $name . 's.twig';
        if (!file_exists($archiveTemplate)) {
            file_put_contents($archiveTemplate, "{% extends 'layout.twig' %}\n\n{% block content %}\n    <h1>{{ post_type }} Archive</h1>\n    {% for post in posts %}\n        <div>\n            <a href=\"/{{ post_type }}/{{ post.ID }}\">{{ post.post_title }}</a>\n        </div>\n    {% endfor %}\n{% endblock %}");
        }

        // Generate the single template (e.g., singleportfolio.twig)
        $singleTemplate = $templatesDir . 'single' . ucfirst($name) . '.twig';
        if (!file_exists($singleTemplate)) {
            file_put_contents($singleTemplate, "{% extends 'layout.twig' %}\n\n{% block content %}\n    <h1>{{ title }}</h1>\n    <div>{{ content }}</div>\n{% endblock %}");
        }
    }

    protected static function generateControllerForCustomPostType($name) {
        $controllersDir = __DIR__ . "/Controllers/";
        $controllerName = ucfirst($name) . 'Controller';
        $controllerFile = $controllersDir . "$controllerName.php";

        // Ensure the controllers directory exists
        if (!is_dir($controllersDir)) {
            mkdir($controllersDir, 0755, true);
        }

        // Generate the controller file
        if (!file_exists($controllerFile)) {
            $controllerContent = <<<PHP
<?php
namespace ElegantGlacier\Controllers;

use ElegantGlacier\ElegantGlacier;

class $controllerName {

    public function index() {
        \$posts = ElegantGlacier::getPosts([
            'post_type' => '$name',
            'posts_per_page' => 10
        ]);

        ElegantGlacier::render('$name' . 's.twig', [
            'posts' => \$posts,
            'post_type' => '$name'
        ]);
    }

    public function show(\$id) {
        \$post = get_post(\$id);

        if (\$post && \$post->post_type == '$name') {
            ElegantGlacier::render('single' . ucfirst($name) . '.twig', [
                'title' => \$post->post_title,
                'content' => \$post->post_content
            ]);
        } else {
            ElegantGlacier::render('404.twig', [
                'message' => ucfirst($name) . ' not found'
            ]);
        }
    }
}
PHP;

            file_put_contents($controllerFile, $controllerContent);
        }
    }
}

// Ensure that this file's functions are globally accessible
class_alias('ElegantGlacier\\ElegantGlacier', 'ElegantGlacier');





