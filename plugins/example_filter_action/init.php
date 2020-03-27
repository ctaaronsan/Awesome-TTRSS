<?php
class example_filter_action extends Plugin {
    
    private $host;

    function about() {
        return array(
            1.0,
            "Example plugin for filter actions",
            "Aaron San",
            false
            );
    }

    function init($host) {
        $this->host = $host;

        $host->add_filter_action($this, "action_name", "action_desc");
    }

    function hook_article_filter_action($article, $action_name) {
        //

        return $article;
    }

    function api_version() {
        return 2;
    }

}
