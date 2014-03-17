<?php

namespace Api\Country\Controller;

class CoutryControllerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CountryManager
     */
    protected $sut;

    /**
     *
     * @var \Slim\Slim
     */
    protected $app;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockFormatter;

    /**
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->sut = new CountryController();

        $this->app = new \Slim\Slim();

        $mockManager = $this->getMockBuilder("\Api\Country\Model\CountryManager")
                ->disableOriginalConstructor()
                ->getMock();
        $this->app->container->singleton('country-manager', function() use ($mockManager) {
            return $this->mockManager;
        });
        $this->mockManager = $mockManager;

        $mockFormatter = $this->getMockBuilder("\Api\Country\Model\RestFormatter")
                ->disableOriginalConstructor()
                ->setMethods(array('generateContentData'))
                ->getMock();
        $this->app->container->singleton('rest-formatter', function() use ($mockFormatter) {
            return $this->mockFormatter;
        });
        $this->mockFormatter = $mockFormatter;
    }

    public function testListCountriesGetAction()
    {
        $this->mockManager
                ->expects($this->once())
                ->method('listAll')
                ->willReturn(array());

        $this->mockFormatter
                ->expects($this->once())
                ->method('generateContentData');

        $this->sut->listCountriesAction($this->app);
    }

    public function testListCountriesResponseIsContentTypeJson()
    {
        $this->mockManager
                ->expects($this->any())
                ->method('listAll')
                ->willReturn(array());

        $this->sut->listCountriesAction($this->app);

        $expected = $this->mockFormatter->getContentType();

        $responseContenType = $this->app->response->headers->get('Content-Type');

        $this->assertEquals($expected, $responseContenType);
        $this->assertEquals(\Api\Country\Model\RestFormatter::TYPE_JSON, $responseContenType);
    }
}
