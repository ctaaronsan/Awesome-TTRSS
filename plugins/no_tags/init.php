<?php
class no_tags extends Plugin {

    private $host;

    function about() {
        return array(
            1.0,
            "A filter action to remove tags from articles",
            "Aaron San",
            false);
    }

    function init($host) {
        $this->host = $host;

        $host->add_filter_action($this, "Remove Tags", "remove all the tags of this article");
    }

    function hook_article_filter_action($article, $action_name) {
        $article["tags"] = array();

        return $article;
    }

    function api_version() {
        return 2;
    }
}
