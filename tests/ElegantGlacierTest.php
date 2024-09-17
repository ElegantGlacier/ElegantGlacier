<?php

namespace ElegantGlacier\Tests;

// require_once __DIR__ . '/../wordpress/wp-load.php';

use ElegantGlacier\ElegantGlacier;
use PHPUnit\Framework\TestCase;
use Brain\Monkey\Functions;

class ElegantGlacierTest extends TestCase
{

    public function setUp(): void
    {
        Functions\stubs()->create();
    }

    public function tearDown(): void
    {
        Functions\stubs()->reset();
    }


    public function testInit()
    {
        ElegantGlacier::init(__DIR__ . '/../../../..');
        $reflection = new ReflectionClass(ElegantGlacier::class);
        $property = $reflection->getProperty('twig');
        $property->setAccessible(true);
        $twigInstance = $property->getValue();

        $this->assertInstanceOf(\Twig\Environment::class, $twigInstance);
    }

    public function testRender()
    {
        ElegantGlacier::init(__DIR__);
        $output = ElegantGlacier::render('test.twig', ['name' => 'Test']);
        $this->assertSame('<p>Test</p>', $output);  
    }

    public function testGetTitle()
    {

        $title = ElegantGlacier::getTitle();
        $this->assertIsString($title); 
    }

    public function testPostTypeRegistration()
    {
        ElegantGlacier::PostType('portfolio');

        $this->assertTrue(post_type_exists('portfolio'));
    }


    public function testGetContent()
{
    $content = ElegantGlacier::getContent();
        $this->assertIsString($content); 
}


// tests/ElegantGlacierTest.php

public function testGetPosts()
{
    $posts = ElegantGlacier::getPosts([
        'post_type' => 'post',
        'posts_per_page' => 1
    ]);

    // Call the method and check if it returns the mocked posts
    
    $this->assertCount(1, $posts);
    
}

}
