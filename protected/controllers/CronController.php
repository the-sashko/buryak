<?php
class CronController extends CronControllerCore
{
    public function jobShare() : void
    {
        $this->getModel('post')->shareThreads();
    }

    public function jobSitemap() : void
    {
        $sitemap     = $this->getPlugin('sitemap');
        $sections    = $this->getModel('sections')->getAllThreads();
        $sitemapList = [];

        foreach ($sections as $section) {
            $postLinks = [];
            $page      = 1;

            $posts = $this->getModel('post')->getBySectionID(
                $section->getID(),
                $page
            );

            while (count($posts)) {
                foreach ($posts as $post) {
                    $postLinks[] = $this->_getThreadLink($post, $section);
                }
            }

            $sitemapName   = 'sections/'.$section->getSlug();
            $sitemapList[] = $this->_getSitemapLink($sitemapName);

            $sitemap->saveLinksToSitemap($sitemapName, $postLinks, 'hourly', 1);
        }

        $sitemap->saveSummarySitemap('sitemap', $sitemapList);
    }

    public function jobRemoveBanUsers() : void
    {
        $this->getModel('user')->removeBans();
    }

    public function jobAutoBanUsers() : void
    {
        $this->getModel('user')->autoBan();
    }

    private function _getThreadLink(
        PostVO    $post    = NULL,
        SectionVO $section = NULL
    ) : string
    {
        $mainConfig = $this->getConfig('main');

        $host = $mainConfig['site_protocol'].'://'.$mainConfig['site_domain'];

        return $host.'/'.$section->getSlug().'/'.$post->getRelativeCode().'/';
    }

    private function _getSitemapLink(string $sitemapName = '') : string
    {
        $mainConfig = $this->getConfig('main');

        $host = $mainConfig['site_protocol'].'://'.$mainConfig['site_domain'];

        return $host.'/xml/'.$sitemapName.'.xml';
    }
}
?>
