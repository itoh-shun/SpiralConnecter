<?php

namespace SiLibrary\SpiralConnecter;

use HttpRequestParameter;

interface SpiralConnecterInterface
{
    public function request(
        XSpiralApiHeaderObject $header,
        HttpRequestParameter $httpRequestParameter
    );
    public function bulkRequest(
        XSpiralApiHeaderObject $header,
        array $httpRequestParameters
    );
}
