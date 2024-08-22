<?php
namespace ElegantGlacier\Controllers;

use ElegantGlacier\ElegantGlacier;

class PageController {
    public function show($id) {
        $page = get_post($id);
        if ($page && $page->post_type == 'page') {
            ElegantGlacier::render('theme/defaultTheme/templates/singlePage.twig', [
                'title' => $page->post_title,
                'content' => $page->post_content,
                'page' => $page
            ]);
        } else {
            ElegantGlacier::render('theme/defaultTheme/templates/404.twig', ['message' => 'Page not found']);
        }
    }
}
