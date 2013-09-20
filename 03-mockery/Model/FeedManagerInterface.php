<?php

namespace Model;

interface FeedManagerInterface
{
    public function fetchItemsByKeyword($keyword);
    public function setupFeed(FeedConfigInterface $config);
}
