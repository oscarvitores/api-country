<?php

namespace Api\Country\Model;

class RestFormatter
{

    const TYPE_JSON = "application/json";

    /**
     *
     * @param string $acceptHeader
     * @return string
     * @throws \InvalidArgumentException
     */
    public function validContentType($acceptHeader)
    {
        if (strpos($acceptHeader, self::TYPE_JSON) === false && strpos($acceptHeader, '*/*') === false) {
            throw new \InvalidArgumentException("Client don't accept valid content type '" . self::TYPE_JSON . "'", 406);
        }
        return self::TYPE_JSON;
    }

    /**
     *
     * @param array $listContent
     * @return string
     */
    public function generateContentData(array $listContent)
    {
        $dataList = array("data" => $listContent);

        return json_encode($dataList, true);
    }

    /**
     * @return string
     */
    public static function getContentType()
    {
        return self::TYPE_JSON;
    }
}
