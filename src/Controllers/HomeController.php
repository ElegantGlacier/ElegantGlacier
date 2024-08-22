<?php
namespace ElegantGlacier\Controllers;

use ElegantGlacier\ElegantGlacier;

class HomeController {
    public function index() {
        $context = [
            'site_name' => 'Elegant',
            'latest_posts' => ElegantGlacier::getPosts([
                'post_type' => 'post',
                'posts_per_page' => 5
            ]),
            'latest_pages' => ElegantGlacier::getPosts([
                'post_type' => 'page',
                'posts_per_page' => 5
            ]),
        ];

        ElegantGlacier::render('themes/defaultTheme/templates/home.twig', $context);
    }
}
