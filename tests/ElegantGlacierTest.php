<?php

namespace ElegantGlacier\Tests;

use ElegantGlacier\ElegantGlacier;
use PHPUnit\Framework\TestCase;
use Brain\Monkey\Functions;
use Brain\Monkey\WP\Filters;
use Brain\Monkey;
use Mockery;

class ElegantGlacierTest extends TestCase
{
    protected function setUp(): void
    {
        Brain\Monkey::setUp();
        parent::setUp();

        // Initialize BrainMonkey
        Functions\stubs([
            'post_type_exists' => function($post_type) {
                return $post_type === 'portfolio'; // Adjust as needed
            },
            'get_the_title' => function() {
                return 'Sample Title'; // Adjust as needed
            },
            'add_action' => function() {
                // No-op for add_action
            },
            'get_the_content' => function() {
                return 'Sample Content'; // Adjust as needed
            },
        ]);

        // Mock WP_Query
        $this->mockWPQuery();
    }

    private function mockWPQuery()
    {
        $this->wpQueryMock = Mockery::mock('WP_Query');
        $this->wpQueryMock->shouldReceive('query')->andReturn([]);
        $this->wpQueryMock->shouldReceive('have_posts')->andReturn(true);
        $this->wpQueryMock->shouldReceive('the_post')->andReturn(null);
        $this->wpQueryMock->posts = []; // Mock the `posts` property
    }

    protected function tearDown(): void
    {
        Mockery::close(); // Close Mockery
        parent::tearDown();
    }

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
        ElegantGlacier::init(__DIR__);
        $output = ElegantGlacier::render('test.twig', ['name' => 'Test']);
        $this->assertSame('<p>Test</p>', $output); // Ensure `test.twig` contains `<p>Test</p>`
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

    public function testGetPosts()
    {
        $posts = ElegantGlacier::getPosts([
            'post_type' => 'post',
            'posts_per_page' => 1
        ]);

        $this->assertCount(0, $posts); // Adjust according to mockWPQuery setup
    }
}
