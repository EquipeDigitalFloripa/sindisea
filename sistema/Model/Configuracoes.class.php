<?php

class Configuracoes {

    private $id_config;
    private $analytics;
    private $title;
    private $content_type;
    private $pragma;
    private $cache_control;
    private $author;
    private $content_language;
    private $reply_to;
    private $url;
    private $copyright;
    private $owner;
    private $rating;
    private $robots;
    private $googlebot;
    private $classification;
    private $revisit_after;
    private $geo_placename;
    private $geo_country;
    private $dc_language;
    private $description;
    private $keywords;
    private $status_config;

    function get_id_config() {
        return $this->id_config;
    }

    function set_id_config($id_config) {
        $this->id_config = $id_config;
    }

    public function get_analytics() {
        return $this->analytics;
    }

    public function set_analytics($analytics) {
        $this->analytics = $analytics;
    }

    public function get_title() {
        return $this->title;
    }

    public function set_title($title) {
        $this->title = $title;
    }

    public function get_content_type() {
        return $this->content_type;
    }

    public function set_content_type($content_type) {
        $this->content_type = $content_type;
    }

    public function get_pragma() {
        return $this->pragma;
    }

    public function set_pragma($pragma) {
        $this->pragma = $pragma;
    }

    public function get_cache_control() {
        return $this->cache_control;
    }

    public function set_cache_control($cache_control) {
        $this->cache_control = $cache_control;
    }

    public function get_author() {
        return $this->author;
    }

    public function set_author($author) {
        $this->author = $author;
    }

    public function get_content_language() {
        return $this->content_language;
    }

    public function set_content_language($content_language) {
        $this->content_language = $content_language;
    }

    public function get_reply_to() {
        return $this->reply_to;
    }

    public function set_reply_to($reply_to) {
        $this->reply_to = $reply_to;
    }

    public function get_url() {
        return $this->url;
    }

    public function set_url($url) {
        $this->url = $url;
    }

    public function get_copyright() {
        return $this->copyright;
    }

    public function set_copyright($copyright) {
        $this->copyright = $copyright;
    }

    public function get_owner() {
        return $this->owner;
    }

    public function set_owner($owner) {
        $this->owner = $owner;
    }

    public function get_rating() {
        return $this->rating;
    }

    public function set_rating($rating) {
        $this->rating = $rating;
    }

    public function get_robots() {
        return $this->robots;
    }

    public function set_robots($robots) {
        $this->robots = $robots;
    }

    public function get_googlebot() {
        return $this->googlebot;
    }

    public function set_googlebot($googlebot) {
        $this->googlebot = $googlebot;
    }

    public function get_classification() {
        return $this->classification;
    }

    public function set_classification($classification) {
        $this->classification = $classification;
    }

    public function get_revisit_after() {
        return $this->revisit_after;
    }

    public function set_revisit_after($revisit_after) {
        $this->revisit_after = $revisit_after;
    }

    public function get_geo_placename() {
        return $this->geo_placename;
    }

    public function set_geo_placename($geo_placename) {
        $this->geo_placename = $geo_placename;
    }

    public function get_geo_country() {
        return $this->geo_country;
    }

    public function set_geo_country($geo_country) {
        $this->geo_country = $geo_country;
    }

    public function get_dc_language() {
        return $this->dc_language;
    }

    public function set_dc_language($dc_language) {
        $this->dc_language = $dc_language;
    }

    public function get_description() {
        return $this->description;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    public function get_keywords() {
        return $this->keywords;
    }

    public function set_keywords($keywords) {
        $this->keywords = $keywords;
    }

    public function get_status_config() {
        return $this->status_config;
    }

    public function set_status_config($status_config) {
        $this->status_config = $status_config;
    }

    public function get_all_dados() {
        $classe = new ReflectionClass($this);
        $props = $classe->getProperties();
        $props_arr = array();
        foreach ($props as $prop) {
            $f = $prop->getName();
            // pra nao voltar a conexao
            if ($f != "conexao") {
                $exec = '$valor = $this->get_' . $f . '();';
                eval($exec);
                $props_arr[$f] = $valor;
            }
        }
        return $props_arr;
    }

}

?>