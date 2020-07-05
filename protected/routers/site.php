<?php
/**
 * Trait For Routing HTTP Requests
 */
trait Router
{
    /**
     * Perform Redirect Rules
     *
     * @param string $uri HTTP Request URI
     */
    public function routeRedirect(?string $uri = null): void
    {
        if (empty($uri)) {
            $uri = '/';
        }

        if (!preg_match('/^(.*?)\/$/su', $uri)) {
            header("Location: {$uri}/", true, 301);
            exit(0);
        }

        if (preg_match('/^(.*?)\/\/(.*?)$/su', $uri)) {
            $url = preg_replace('/([\/]+)/su', '', $uri);
            header("Location: {$uri}", true, 301);
            exit(0);
        }

        if (preg_match('/^(.*?)\/page-0\/$/su', $uri)) {
            $url = preg_replace('/^(.*?)\/page-0\/$/su', '$1/', $uri);
            header('Location: '.$url, true, 301);
            exit(0);
        }

        if (preg_match('/^(.*?)\/page-1\/$/su', $uri)) {
            $url = preg_replace('/^(.*?)\/page-1\/$/su', '$1/', $uri);
            header('Location: '.$url, true, 301);
            exit(0);
        }

        if (preg_match('/^\/([a-z]{2})\/(.*?)\/$/su', $uri)) {
            $url = preg_replace('/^\/([a-z]{2})\/(.*?)\/$/su', '$2', $uri);
        }

        if (preg_match('/^\/thread\/(.*?)\/$/su', $uri)) {
            header('Location: /error/404/', true, 301);
            exit(0);
        }

        if (preg_match('/^\/board\/(.*?)\/$/su', $uri)) {
            header('Location: /error/404/', true, 301);
            exit(0);
        }

        if (preg_match('/^\/main\/(.*?)\/$/su', $uri)) {
            header('Location: /error/404/', true, 301);
            exit(0);
        }

        if (preg_match('/^\/page\/$/su', $uri)) {
            header('Location: /error/404/', true, 301);
            exit(0);
        }
    }

    /**
     * Perform Rewrite Rules
     *
     * @param string $uri HTTP Request URI
     *
     * @return string Rewrited HTTP Request URI
     */
    public function routeRewrite(?string $uri = null): ?string
    {
        if (empty($uri)) {
            $uri = '/';
        }

        if ($uri == '/') {
            return '/ua/main/index/';
        }

        if (preg_match('/^\/page\-([0-9]+)\/$/su', $uri)) {
            return preg_replace(
                '/^\/page\-([0-9]+)\/$/su',
                '/ua/main/index/$1/',
                $uri
            );
        }

        if (preg_match('/^\/error\/([0-9]+)\/$/su', $uri)) {
            return preg_replace(
                '/^\/error\/([0-9]+)\/$/su',
                '/ua/main/error/$1/',
                $uri
            );
        }

        if (preg_match('/^\/([a-z]+)\/([0-9]+)\/$/su', $uri)) {
            return preg_replace(
                '/^\/([a-z]+)\/([0-9]+)\/$/su',
                '/ua/post/thread/$1_$2/',
                $uri
            );
        }

        if (preg_match('/^\/([a-z]+)\/$/su', $uri)) {
            return '/ua/post/board/$1/page-1/';
        }

        if (preg_match('/^\/([a-z]+)\/page\-([0-9]+)\/$/su', $uri)) {
            return preg_replace(
                '/^\/([a-z]+)\/page\-([0-9]+)\/$/su',
                '/ua/post/board/$1/page-$2/',
                $uri
            );
        }

        if (preg_match('/^\/page\/([a-z]+)\/$/su', $uri)) {
            return preg_replace(
                '/^\/page\/([a-z]+)\/$/su',
                '/ua/main/page/$1/',
                $uri
            );
        }

        if (preg_match('/^\/search\/$/su', $uri)) {
            return preg_replace(
                '/^\/main\/search\/$/su',
                '/ua/main/search/',
                $uri
            );
        }

        $uri = sprintf('/ua%s', $uri);

        return $uri;
    }
}
