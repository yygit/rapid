<?php

class CbdbComicVine{
    private $apiKey;
    private $baseUrl;

    public function __construct($apiKey, $baseUrl = 'http://api.comicvine.com/') {
        $this->setApiKey($apiKey);
        $this->setBaseUrl($baseUrl);
    }

    public function setAPiKey($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function setBaseUrl($baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    public static function buildQueryString($paramArray) {
        $paramString = http_build_query($paramArray);
        if ($paramString) {
            $paramString = '?' . $paramString;
        }
        return $paramString;
    }

    public static function makeRequest($url, $paramArray) {
        $queryUrl = $url . CbdbComicVine::buildQueryString($paramArray);
        // Yii::log(print_r($queryUrl, true) . "\r\n", 'cvine'); /*YY; 20140129*/
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $queryUrl);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $response = curl_exec($curl);
        $status = curl_getinfo($curl);
        if ($status['http_code'] == 200) {
            $responseObject = json_decode($response);
            if (is_object($responseObject) && ($responseObject->status_code == 1)) {
                return array('error' => 0, 'content' => $responseObject);
            }
            return array('error' => 1, 'error_type' => 'site', 'content' => $responseObject);
        }
        return array('error' => 1, 'error_type' => 'transfer', 'content' => $status);
    }

    private function setInitParams(&$params) {
        $params['api_key'] = $this->apiKey;
        $params['format'] = 'json';
        return $params;
    }

    public function getNewParamsArray() {
        $params = array();
        return $this->setInitParams($params);
    }

    public function baseRequest($resource, $addlParams) {
        $params = $this->getNewParamsArray();
        $params = array_merge($params, $addlParams);
        $url = $this->baseUrl . $resource . '/';
        return $this->makeRequest($url, $params);
    }

    public function detailRequest($resource, $id, $addlParams) {
        $params = $this->getNewParamsArray();
        $params = array_merge($params, $addlParams);
        return $this->makeRequest($this->baseUrl . $resource . '/' . $id . '/', $params);
    }

    public function volumeSearch($query, $params = array(), $offset = 0, $limit = 20, $page = 1) {
        $params['query'] = $query;
        $params['resources'] = 'volume';
        $params['offset'] = $offset; // 20140129 obsolete for searching?
        $params['limit'] = $limit;
        $params['page'] = $page;

        return $this->baseRequest('search', $params);
    }

    public function volume($id, $params = array()) {
        return $this->detailRequest('volume', $id, $params);
    }

    public function issue($id, $params = array()) {
        return $this->detailRequest('issue', $id, $params);
    }

    /**
     * The New API - Same as the old API except for the differences - API Developers - Comic Vine;
     * http://www.comicvine.com/forums/api-developers-2334/the-new-api-same-as-the-old-api-except-for-the-dif-1449264/?page=1#js-message-9328268
     * proper request: http://www.comicvine.com/api/issues/?api_key=[API KEY]&filter=volume:3976
     * @param $volumeId
     * @param array $params
     * @return array
     */
    public function issuesForVolume($volumeId, $params = array()) {
        $params['filter'] = 'volume:'.$volumeId;
        return $this->detailRequest('issues', $volumeId, $params);
    }
}

