<?php
/**
 * Trait For Routing HTTP Requests
 */
trait Router
{
    /**
     * Perform Redirect Rules
     *
     * @param string $url HTTP Request URL
     */
    public function routeRedirect(?string $url = null): void
    {
        if (empty($url)) {
            $url = '/';
        }

        /*if (!preg_match('/^(.*?)\/$/su', $url)) {
            header("Location: {$url}/", true, 301);
            exit(0);
        }*/

        if (preg_match('/^(.*?)\/\/(.*?)$/su', $url)) {
            $url = preg_replace('/([\/]+)/su', '', $url);
            header("Location: {$url}", true, 301);
            exit(0);
        }

        if (preg_match('/^(.*?)\/page-0\/$/su', $url)) {
            $url = preg_replace('/^(.*?)\/page-0\/$/su', '$1/', $url);
            header('Location: '.$url, true, 301);
            exit(0);
        }

        if (preg_match('/^(.*?)\/page-1\/$/su', $url)) {
            $url = preg_replace('/^(.*?)\/page-1\/$/su', '$1/', $url);
            header('Location: '.$url, true, 301);
            exit(0);
        }

        if (preg_match('/^\/([a-z]{2})\/(.*?)\/$/su', $url)) {
            $url = preg_replace('/^\/([a-z]{2})\/(.*?)\/$/su', '$2', $url);
        }

        if (preg_match('/^\/thread\/(.*?)\/$/su', $url)) {
            header('Location: /error/404/', true, 301);
            exit(0);
        }

        if (preg_match('/^\/board\/(.*?)\/$/su', $url)) {
            header('Location: /error/404/', true, 301);
            exit(0);
        }

        if (preg_match('/^\/main\/(.*?)\/$/su', $url)) {
            header('Location: /error/404/', true, 301);
            exit(0);
        }

        if (preg_match('/^\/page\/$/su', $url)) {
            header('Location: /error/404/', true, 301);
            exit(0);
        }
    }

    /**
     * Perform Rewrite Rules
     *
     * @param string $url HTTP Request URL
     *
     * @return string Rewrited HTTP Request URL
     */
    public function routeRewrite(?string $url = null): ?string
    {
        if (empty($url)) {
            $url = '/';
        }

        if ($url == '/') {
            return '/ua/main/index/';
        }

        if (preg_match('/^\/page\-([0-9]+)\/$/su', $url)) {
            return preg_replace(
                '/^\/page\-([0-9]+)\/$/su',
                '/ua/main/index/page-$1/',
                $url
            );
        }

        if (preg_match('/^\/error\/([0-9]+)\/$/su', $url)) {
            return preg_replace(
                '/^\/error\/([0-9]+)\/$/su',
                '/ua/main/error/?code=$1',
                $url
            );
        }

        if (preg_match('/^\/([a-z]+)\/([0-9]+)\/$/su', $url)) {
            return preg_replace(
                '/^\/([a-z]+)\/([0-9]+)\/$/su',
                '/ua/post/thread/?board=$1&thread_id=$2',
                $url
            );
        }

        if (preg_match('/^\/([a-z]+)\/$/su', $url)) {
            return preg_replace(
                '/^\/([a-z]+)\/$/su',
                '/ua/post/board/page-1/?board=$1',
                $url
            );
        }

        if (preg_match('/^\/([a-z]+)\/page\-([0-9]+)\/$/su', $url)) {
            return preg_replace(
                '/^\/([a-z]+)\/page\-([0-9]+)\/$/su',
                '/ua/post/board/page-$2/?board=$1',
                $url
            );
        }

        if (preg_match('/^\/page\/([a-z]+)\/$/su', $url)) {
            return preg_replace(
                '/^\/page\/([a-z]+)\/$/su',
                '/ua/main/page/?slug=$1',
                $url
            );
        }

        if (preg_match('/^\/search\/$/su', $url)) {
            return preg_replace(
                '/^\/main\/search\/$/su',
                '/ua/main/search/',
                $url
            );
        }

        $url = sprintf('/ua%s', $url);

        return $url;
    }
}
