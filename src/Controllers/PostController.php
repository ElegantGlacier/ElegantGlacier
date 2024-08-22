<?php
namespace ElegantGlacier\Controllers;

use ElegantGlacier\ElegantGlacier;

class PostController {
    public function index() {
        $posts = ElegantGlacier::getPosts([
            'post_type' => 'post',
            'posts_per_page' => 10
        ]);

        ElegantGlacier::render('theme/defaultTheme/templates/posts.twig', ['posts' => $posts]);
    }

    public function show($id) {
        $post = get_post($id);
        if ($post) {
            ElegantGlacier::render('theme/defaultTheme/templates/singlePost.twig', [
                'title' => $post->post_title,
                'content' => $post->post_content,
                'post' => $post
            ]);
        } else {
            ElegantGlacier::render('theme/defaultTheme/templates/404.twig', ['message' => 'Post not found']);
        }
    }
}
