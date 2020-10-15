<?php
/**
 * Trait For Routing HTTP Requests
 */
trait Router
{
    /**
     * Perform Redirect Rules
     *
     * @param string $uri HTTP Request URL
     */
    public function routeRedirect(?string $url = null): void
    {
    }

    /**
     * Perform Rewrite Rules
     *
     * @param string $uri HTTP Request URL
     *
     * @return string Rewrited HTTP Request URL
     */
    public function routeRewrite(?string $url = null): string
    {
        if (empty($url)) {
            $url = '/';
        }

        return $url;
    }
}
