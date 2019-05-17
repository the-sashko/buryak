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
        if (preg_match('/^\/admin\/$/su', $uri)) {
            header('Location: /admin/post/', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/main\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^(.*?)\/page\-1\/(.*?)$/su', $uri)) {
            $uri = str_replace($uri, '/page-1/', '/');
            header('Location: '.$uri, TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/editpost\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/post\/edit\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/delpost\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/post\/del\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/editban\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/ban\/edit\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/delban\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/ban\/del\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/editcron\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/cron\/edit\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/delcron\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/cron\/del\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/editsection\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/section\/edit\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/delsection\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/section\/del\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/edituser\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/user\/edit\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/deluser\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/admin\/user\/del\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/ajax\/post\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/ajax\/thread\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/page\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/error\/$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/post\/thread\/(.*?)$/su', $uri)) {
            header('Location: /', TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/post\/all\/(.*?)$/su', $uri)) {
            $uri = preg_replace('/^\/post\/all\/(.*?)/su', '/all/$1', $uri);
            header('Location: '.$uri, TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/section\/(.*?)$/su', $uri)) {
            $uri = preg_replace('/^\/section\/(.*?)/su', '/$1', $uri);
            header('Location: '.$uri, TRUE, 301);
            exit(0);
        }

        if (preg_match('/^\/all\/(.*?)$/su', $uri)) {
            $uri = preg_replace('/^\/all\/(.*?)/su', '/$1', $uri);
            header('Location: '.$uri, TRUE, 301);
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
        if (preg_match('/^\/admin\/post\/edit\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/admin\/post\/edit\/([0-9]+)\/$/su', '/admin/editpost/$1/', $uri);
        }

        if (preg_match('/^\/admin\/post\/del\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/admin\/post\/del\/([0-9]+)\/$/su', '/admin/delpost/$1/', $uri);
        }

        if (preg_match('/^\/admin\/ban\/edit\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/admin\/ban\/edit\/([0-9]+)\/$/su', '/admin/editban/$1/', $uri);
        }

        if (preg_match('/^\/admin\/ban\/del\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/admin\/ban\/del\/([0-9]+)\/$/su', '/admin/delban/$1/', $uri);
        }

        if (preg_match('/^\/admin\/cron\/edit\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/admin\/cron\/edit\/([0-9]+)\/$/su', '/admin/editcron/$1/', $uri);
        }

        if (preg_match('/^\/admin\/cron\/del\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/admin\/cron\/del\/([0-9]+)\/$/su', '/admin/delcron/$1/', $uri);
        }

        if (preg_match('/^\/admin\/section\/edit\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/admin\/section\/edit\/([0-9]+)\/$/su', '/admin/editsection/$1/', $uri);
        }

        if (preg_match('/^\/admin\/section\/del\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/admin\/section\/del\/([0-9]+)\/$/su', '/admin/delsection/$1/', $uri);
        }

        if (preg_match('/^\/admin\/user\/edit\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/admin\/user\/edit\/([0-9]+)\/$/su', '/admin/edituser/$1/', $uri);
        }

        if (preg_match('/^\/admin\/user\/del\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/admin\/user\/del\/([0-9]+)\/$/su', '/admin/deluser/$1/', $uri);
        }

        if (preg_match('/^\/page\/([A-Za-z0-9\-]+)\/$/su', $uri)) {
            return preg_replace('/^\/page\/([A-Za-z0-9\-]+)\/$/su', '/main/page/$1/', $uri);
        }

        if (preg_match('/^\/error\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/error\/([0-9]+)\/$/su', '/main/error/$1/', $uri);
        }

        if (preg_match('/^\/search\/$/su', $uri)) {
            return '/post/search/';
        }
    
        if (preg_match('/^\/$/su', $uri)) {
            return '/section/all/';
        }

        if (preg_match('/^\/page-([0-9]+)$/su', $uri)) {
            return preg_replace('/^\/page-([0-9]+)\/$/su', '/section/all/page-$1/', $uri);
        }
    
        if (preg_match('/^\/all\/$/su', $uri)) {
            return '/post/all/';
        }

        if (preg_match('/^\/all\/page-([0-9]+)$/su', $uri)) {
            return preg_replace('/^\/all\/page-([0-9]+)\/$/su', '/post/all/page-$1/', $uri);
        }

        if (preg_match('/^\/([a-z]+)\/$/su', $uri)) {
            return preg_replace('/^\/([a-z]+)\/$/su',' /section/threads/$1/', $uri);
        }

        if (preg_match('/^\/([a-z]+)\/page-([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/([a-z]+)\/page-([0-9]+)\/$/su',' /section/threads/$1/page-$2/', $uri);
        }

        if (preg_match('/^\/([a-z]+)\/([0-9]+)\/$/su', $uri)) {
            return '/post/all/';
        }

        if (preg_match('/^\/([a-z]+)\/([0-9]+)\/$/su', $uri)) {
            return preg_replace('/^\/([a-z]+)\/([0-9]+)\/$/su',' /post/thread/$1_$2/', $uri);
        }

        return $uri;
    }
}
?>
