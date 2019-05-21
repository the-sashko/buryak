<?php
class CronController extends CronControllerCore
{
    public function jobShare() : void
    {
        $this->initModel('post')->shareThreads();
    }

    public function jobSitemap() : void
    {
        $sitemap     = $this->initPlugin('sitemap');
        $sections    = $this->initModel('sections')->getAllThreads();
        $sitemapList = [];

        foreach ($sections as $section) {
            $postLinks = [];
            $page      = 1;

            $posts = $this->initModel('post')->getBySectionID(
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
        $this->initModel('user')->removeBans();
    }

    public function jobAutoBanUsers() : void
    {
        $this->initModel('user')->autoBan();
    }

    private function _getThreadLink(
        PostVO    $post    = NULL,
        SectionVO $section = NULL
    ) : string
    {
        $mainConfig = $this->initConfig('main');

        $host = $mainConfig['site_protocol'].'://'.$mainConfig['site_domain'];

        return $host.'/'.$section->getSlug().'/'.$post->getRelativeCode().'/';
    }

    private function _getSitemapLink(string $sitemapName = '') : string
    {
        $mainConfig = $this->initConfig('main');

        $host = $mainConfig['site_protocol'].'://'.$mainConfig['site_domain'];

        return $host.'/xml/'.$sitemapName.'.xml';
    }
}
?>
