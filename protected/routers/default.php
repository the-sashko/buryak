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
    public function routeRedirect(string $uri = '') : void
    {
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
    public function routeRewrite(string $uri = '') : string
    {

        if (preg_match('/^\/$/su', $uri)) {
            return '/main/index/';
        }

        return $uri;
    }
}
?>
