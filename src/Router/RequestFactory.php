<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router;

use Symfony\Component\HttpFoundation\Request as HttpRequest;
use GT\ExtDirect\Router\Exception\BadRequestException;

/**
 * Class RequestFactory
 *
 * @package GT\ExtDirect
 */
class RequestFactory
{
    /**
     * @param HttpRequest $request
     * @return RequestCollection
     * @throws BadRequestException
     */
    public function createRequest(HttpRequest $request)
    {
        if ($request->getMethod() !== HttpRequest::METHOD_POST) {
            throw BadRequestException::createMethodNotAllowed($request);
        }

        if ($request->getContentType() == 'json') {
            return $this->createJsonRequest($request);
        } else {
            return $this->createFormRequest($request);
        }
    }

    /**
     * @param HttpRequest $request
     * @return RequestCollection
     */
    protected function createJsonRequest(HttpRequest $request)
    {
        $data = @json_decode($request->getContent(), true);
        if ($data === null && $request->getContent() !== 'null') {
            throw BadRequestException::createMalformedJsonString($request);
        }

        if (!is_array($data)) {
            throw BadRequestException::createInvalidExtDirectRequest($request);
        }

        $isSingleRequest = (array_keys($data) !== range(0, count($data) - 1));
        if ($isSingleRequest) {
            $data = array($data);
        }

        $requests = array();
        foreach ($data as $r) {

            if (!isset($r['tid'])
                || !isset($r['action'])
                || !isset($r['method'])
                || !isset($r['type'])
                || $r['type'] != 'rpc'
            ) {
                throw BadRequestException::createMissingInformation($request);
            }

            $requests[] = new Request(
                $r['tid'],
                $r['action'],
                $r['method'],
                (!isset($r['data']) || !is_array($r['data'])) ? array() : $r['data'],
                false,
                false
            );
        }

        return new RequestCollection($requests);
    }

    /**
     * @param HttpRequest $request
     * @return RequestCollection
     */
    protected function createFormRequest(HttpRequest $request)
    {
        if (!$request->request->has('extTID')
            || !$request->request->has('extAction')
            || !$request->request->has('extMethod')
            || !$request->request->has('extType')
            || $request->request->get('extType') != 'rpc'
        ) {
            throw BadRequestException::createMissingInformation($request);
        }


        $request = new Request(
            $request->request->get('extTID'),
            $request->request->get('extAction'),
            $request->request->get('extMethod'),
            array(),
            true,
            $request->request->get('extUpload') === 'true'
        );

        return new RequestCollection(array($request));
    }
}
