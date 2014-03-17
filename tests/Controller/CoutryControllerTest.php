<?php

namespace Api\Country\Controller;

/**
 */
class CoutryControllerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CountryManager
     */
    protected $sut;

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
                ->getMock();
        $this->app->container->singleton('rest-formatter', function() use ($mockFormatter) {
            return $this->mockFormatter;
        });
        $this->mockFormatter = $mockFormatter;
    }

    /**
     *
     */
    public function testListCountriesGetAction()
    {
        $this->mockManager
                ->expects($this->once())
                ->method('listAll')
                ->willReturn(array());

        $this->mockFormatter
                ->expects($this->once())
                ->method('generateContentData');

        CountryController::listCountriesAction($this->app);
    }
}
