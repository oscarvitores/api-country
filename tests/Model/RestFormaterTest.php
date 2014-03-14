<?php

namespace Api\Country\Model;

/**
 */
class RestFormaterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RestFormater
     */
    protected $sut;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->sut = new RestFormater();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @dataProvider providerValidAcceptType
     */
    public function testValidContentTypeFormatFromAcceptTypeHeader($acceptHeader)
    {
        $contentType         = $this->sut->validContentType($acceptHeader);
        $contentTypeExpected = RestFormater::TYPE_JSON;

        $this->assertEquals($contentTypeExpected, $contentType);
    }

    public function providerValidAcceptType()
    {
        return array(
            array("application/json"),
            array("application/json;q=0.9"),
            array("*/*,application/json"),
            array("application/xml,application/json"),
            array("text/plain,application/json,text/html"),
            array("text/html,application/json")
        );
    }

    /**
     * @expectedException Exception
     * @expectedExceptionCode 406
     */
    public function testAcceptHeaderNotContainValidContentThrowException()
    {
        $acceptHeader = "text/html,application/xml";

        $contentType = $this->sut->validContentType($acceptHeader);
    }

    /**
     * @dataProvider providerValidJsonFormats
     */
    public function testGenerateDataContentInFormatJson($listContent, $expectedJson)
    {
        $actualJson = $this->sut->generateContentList($listContent);

        $this->assertJsonStringEqualsJsonString($expectedJson, $actualJson);
    }

    public function providerValidJsonFormats()
    {
        return array(
            array(array(), '{"data":[]}'),
            array(
                array(
                    array("id" => "1", "name" => "España", "iso" => "ES"),
                    array("id" => "2", "name" => "Francia", "iso" => "FR")
                ),
                '{"data":[{"id":1,"name":"España", "iso":"ES"},{"id":2,"name":"Francia","iso":"FR"}]}')
        );
    }
}
