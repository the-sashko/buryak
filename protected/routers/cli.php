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

        if (!preg_match('/^\/$/su', $uri)) {
            header('Location: /');
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
    public function routeRewrite(?string $uri = null): string
    {
        if (empty($uri)) {
            $uri = '/';
        }

        if (preg_match('/^\/$/su', $uri)) {
            return '/en/main/index/';
        }

        return $uri;
    }
}
