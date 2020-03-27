<?php
class eh_tags extends Plugin {

    private $host;

    function about() {
        return array(
            2.2,
            "Extract E-Hentai gallery tags from feed content",
            "Aaron San",
            false
            );
    }

    function init($host) {
        $this->host = $host;

        $host->add_hook($host::HOOK_ARTICLE_FILTER, $this);
    }

    function hook_article_filter($article) {
        if (preg_match('/^https?:\/\/e-hentai.org/', $article["feed"]["site_url"]) == 1) {
            if ( preg_match('/\btags: *none\b/i', $article["content"]) ) {
                $article["tags"] = array();
            }
            else {
                $regex_tags = '/\btags: *((?:[a-z0-9\- ]+,)*[a-z0-9\- ]+)\b/i';
                preg_match($regex_tags, $article["content"], $matches);

                $tags = explode(",", $matches[1]);

                $article["tags"] = $tags;
            }
        }

        return $article;
    }

    function api_version() {
        return 2;
    }
}
?>
