<?php

namespace Liip\HelloBundle\View;

use FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class RSSViewHandler
{
    /**
     * @param ViewHandler $viewHandler
     * @param View $view
     * @param Request $request
     * @param string $format
     *
     * @return Response
     */
    public function createResponse(ViewHandler $handler, View $view, Request $request, $format)
    {
        $rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
        $rssfeed .= '<rss version="2.0">';
        $rssfeed .= '<channel>';
        $rssfeed .= '<title>My RSS feed</title>';
        $rssfeed .= '<link>http://www.mywebsite.com</link>';
        $rssfeed .= '<description>This is an example RSS feed</description>';
        $rssfeed .= '<language>en-us</language>';
        $rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>';

        return new Response($rssfeed, 200, $view->getHeaders());
    }
}
