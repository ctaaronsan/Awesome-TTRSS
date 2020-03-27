<?php
class explain_xkcd extends Plugin {

    private $host;

    function about() {
        return array(
            1.0,
            "Add a link to Explain xkcd for xkcd feeds",
            "Aaron San",
            false
            );
    }

    function init($host) {
        $this->host = $host;

        $host->add_hook($host::HOOK_ARTICLE_FILTER, $this);
    }

    function hook_article_filter($article) {
        $xkcd_pat = '/^https?:\/\/xkcd.com\/(?=[0-9]+\/?$)/';
        if ( preg_match($xkcd_pat, $article["link"]) ) {
            $article["content"] .= '<p><a href="' .
                preg_replace($xkcd_pat, 'https://www.explainxkcd.com/', $article["link"]) .
                '">Explain it</a></p>';
        }

        return $article;
    }

    function api_version() {
        return 2;
    }
}
?>
