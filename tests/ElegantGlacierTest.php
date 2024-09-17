<?php

namespace ElegantGlacier\Tests;

require_once getenv('WP_LOAD_PATH');

use ElegantGlacier\ElegantGlacier;
use PHPUnit\Framework\TestCase;

class ElegantGlacierTest extends TestCase
{

    public function testInit()
    {
        ElegantGlacier::init(__DIR__);
        $reflection = new \ReflectionClass(ElegantGlacier::class);
        $property = $reflection->getProperty('twig');
        $property->setAccessible(true);
        $twigInstance = $property->getValue();

        $this->assertInstanceOf(\Twig\Environment::class, $twigInstance);
    }

    public function testRender()
    {
        // Assuming you have a Twig template at this location
        $templatePath = __DIR__ . '/path/to/templates/test.twig';
        file_put_contents($templatePath, '<p>{{ name }}</p>');

        ElegantGlacier::init(__DIR__);
        $output = ElegantGlacier::render('test.twig', ['name' => 'Test']);
        $this->assertSame('<p>Test</p>', $output);
        
        // Clean up the template file after test
        unlink($templatePath);
    }

    public function testGetTitle()
    {
        // Insert a test post
        $post_id = wp_insert_post([
            'post_title'  => 'Test Title',
            'post_content' => 'This is a test post',
            'post_status' => 'publish',
        ]);

        $title = ElegantGlacier::getTitle();
        $this->assertIsString($title);
        $this->assertSame('Test Title', $title); // Adjust based on actual implementation
    }

    public function testPostTypeRegistration()
    {
        ElegantGlacier::PostType('portfolio');

        $this->assertTrue(post_type_exists('portfolio'));
    }

    public function testGetContent()
    {
        // Insert a test post
        $post_id = wp_insert_post([
            'post_title'  => 'Test Title',
            'post_content' => 'Test Content',
            'post_status' => 'publish',
        ]);

        $content = ElegantGlacier::getContent();
        $this->assertIsString($content);
        $this->assertSame('Test Content', $content); // Adjust based on actual implementation
    }

    public function testGetPosts()
    {
        // Insert a test post
        wp_insert_post([
            'post_title'  => 'Sample Post',
            'post_content' => 'This is a sample post',
            'post_status' => 'publish',
        ]);

        $posts = ElegantGlacier::getPosts([
            'post_type' => 'post',
            'posts_per_page' => 1
        ]);

        $this->assertCount(1, $posts);
        $this->assertEquals('Sample Post', $posts[0]->post_title);
    }
}
