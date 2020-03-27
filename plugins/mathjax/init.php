<?php
class mathjax extends Plugin {

    private $host;

    function about() {
        return array(
            1.0,
            "Use MathJax to process articles(not working right now)",
            "Aaron San",
            false
            );
    }

    function init($host) {
        $this->host = $host;

        $host->add_hook($host::HOOK_RENDER_ARTICLE_CDM, $this);
    }

    function get_js() {
        return file_get_contents('https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.0/MathJax.js?config=TeX-MML-AM_CHTML');
    }

    function hook_render_article_cdm($article) {
        $article["content"] = "<p>test by mathjax plugin</p><script>print('hello');</script>" . $article["content"];

        return $article;
    }

    function api_version() {
        return 2;
    }
}
?>
