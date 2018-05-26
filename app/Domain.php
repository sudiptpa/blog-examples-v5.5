<?php

namespace App;

use Illuminate\Http\Request;

/**
 * Class Domain
 * @package App
 */
class Domain
{
    const FORCE_HTTP = 'http://';
    const FORCE_HTTPS = 'https://';

    const FORCE_WWW = '//www.';
    const FORCE_NOWWW = '//';

    const REGEX_FILTER_WWW = '/(\/\/www\.|\/\/)/';
    const REGEX_FILTER_HTTPS = '/^(http:\/\/|https:\/\/)/';

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $translated;

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function isEqual(): bool
    {
        return $this->request->fullUrl() !== $this->translated();
    }

    /**
     * Determines if the original url differs with translated.
     *
     * @return bool
     */
    public function diff(): bool
    {
        $this->translated = $this->translate();

        return $this->isEqual();
    }

    /**
     * @return string
     */
    public function translated(): string
    {
        if (!$this->translated) {
            $this->translated = $this->translate();
        }

        return $this->translated;
    }

    /**
     * @return string
     */
    public function translate(): string
    {
        $url = $this->request->fullUrl();

        $protocol = $this->getProtocol();

        $filtered = preg_replace(self::REGEX_FILTER_HTTPS, $protocol, $url);

        $preferred = $this->getPreferred();

        return preg_replace(self::REGEX_FILTER_WWW, $preferred, $filtered);
    }

    /**
     * Determines if the request supports the https,
     * otherwise, fallback to default (http) protocol.
     *
     * @return string
     */
    public function getProtocol(): string
    {
        if (!$this->request->secure()) {
            return self::FORCE_HTTP;
        }

        return config('domain.protocol') ?? self::FORCE_HTTP;
    }

    /**
     * Determines the preferred domain from config.
     *
     * @return string
     */
    public function getPreferred(): string
    {
        return config('domain.preferred') ?? self::FORCE_NOWWW;
    }
}
