<?php

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use sample\SampleRelatedWidget;
use \Mockery as m;

class SampleRelatedWidgetTest extends WebTestCase
{
    public function tearDown()
    {
        m::close();
    }

    protected function getTemplating()
    {
        $templating = m::mock('Symfony\Component\Templating\EngineInterface');
        $templating
            ->shouldReceive('render')
            ->andReturnUsing(function($templateName, $data) {
                return $data;
            });
    }

    protected function getContainer($posts)
    {
        $services = [
            'sample_related_filler_1' => m::mock(['getRelated', $posts]),
            'sample_related_filler_2' => m::mock(['getRelated', $posts])
        ];
        $container = m::mock('Symfony\Component\DependencyInjection\ContainerInterface');
        $container->shouldReceive('get')
            ->andReturnUsing(
                function ($key) use ($services) {
                    return $services[$key];
                }
            );

        return $container;
    }

    /**
     * @dataProvider dataProvider
     */
    public function testRenderWidgetShouldReturnDataAsExpect($posts, $expected)
    {
        $widget = new SampleRelatedWidget(
            $this->getTemplating(),
            $this->getContainer($posts)
        );
        $reflectionClass = new \ReflectionClass('sample\SampleRelatedWidget');
        $reflectionMethod = $reflectionClass->getMethod('getListOfRelated');
        $reflectionMethod->setAccessible(true);
        $actual = $reflectionMethod->invokeArgs($widget, []);

        $this->assertEquals($expected, $actual);
    }
    
    public function dataProvider()
    {
        return [
            [
                [
                    ['id' => 1],['id' => 2],['id' => 3]
                ],
                [
                    'hasRelated' => true,
                    'related' => [
                        ['id' => 1],['id' => 2],['id' => 3]
                    ]
                ]
            ],
            [
                [],
                [
                    'hasRelated' => false,
                    'related' => []
                ]
            ]
        ];
    }
}