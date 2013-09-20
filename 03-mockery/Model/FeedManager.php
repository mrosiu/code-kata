<?php 

namespace Model;

use Buzz\Browser;
use Buzz\Exception\ClientException;
use Exception\WonkyConnectionException;

class FeedManager implements FeedManagerInterface
{
    protected $config;
    protected $browser;

    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }

    public function fetchItemsByKeyword($keyword)
    {
        if (null == $this->config) {
            throw new \RuntimeException('brak configa');
        }

        $keyword = trim((string) $keyword, " \n '\"");
        if (strlen($keyword) == 0) {
            throw new \InvalidArgumentException('Pusty keyword');
        }

        try {
            $xmlContent = $this->browser->get($this->config->getUrl());
        } catch (ClientException $e) {
            throw new WonkyConnectionException('Misieeeeek');
        }


        $sxe = simplexml_load_string($xmlContent);
        if (!$sxe) {
            throw new \RuntimeException('Bad xml');
        }
        $items = [];

        $matching = $sxe->xpath(sprintf("//item[contains(description, '%s')]", $keyword));
        foreach ($matching as $matchingSxe) {
            $items[] = [
                'link' => (string) $matchingSxe->link,
                'title' => (string) $matchingSxe->title,
                'description' => (string) $matchingSxe->description,
            ];
        }

        return $items;
    }

    public function setupFeed(FeedConfigInterface $config)
    {
        $this->config = $config;
    }
}
