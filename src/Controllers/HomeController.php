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

        foreach ($context['latest_posts'] as $post) {
            $post->thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
            error_log("Post ID {$post->ID} - Thumbnail URL: " . $post->thumbnail_url);
        }
        
        foreach ($context['latest_pages'] as $page) {
            $page->thumbnail_url = get_the_post_thumbnail_url($page->ID, 'full');
            error_log("Page ID {$page->ID} - Thumbnail URL: " . $page->thumbnail_url);
        }

        ElegantGlacier::render('themes/defaultTheme/templates/home.twig', $context);
    }
}
