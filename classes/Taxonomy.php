<?php

class Taxonomy
{

    public static function getChildren($tid) {
        if (isset($tid)) {
            $children = array_keys(taxonomy_get_children($tid));
            if ($children) {
                return $children;
            }
        }
        return false;
    }

    /**
    * returns a field name associated with a particular taxonomy vocabulary id (vid)
    */
    public static function getFieldName($vid) {
        switch ($vid) {
            case $GLOBALS['tag']:
                return 'field_tag';
                break;
            case $GLOBALS['category']:
                return 'field_category';
                break;
            default:
                return false;
                break;
        }
    }

    public static function getSeriesInfo($node = null) {
        if ($node) {
            if (isset($node->field_series[$node->language][0]['tid'])) {
                $term = taxonomy_term_load($node->field_series[$node->language][0]['tid']);
                if ($term) {
                    return self::getTermInfo($term);
                }
            }
        }
        return false;
    }

    public static function getTerm($tid) {
        if (isset($tid)) {
            $term = taxonomy_term_load($tid);
            if ($term) {
                return self::getTermInfo($term);
            }
        }
    }

    public static function getTermInfo($term = null) {
        if ($term) {
            return array(
                'name'      => $term->name,
                'image_uri' => isset($term->field_image[LANGUAGE_NONE][0]['uri']) ? $term->field_image[LANGUAGE_NONE][0]['uri'] : false,
                'path'      => '/' . drupal_lookup_path('alias', 'taxonomy/term/' . $term->tid),

            );
        }
        return false;
    }

    public static function getTids($field, $language) {
        $tids = array();
        if (isset($field[$language])) {
            foreach ($field[$language] as $f) {
                if (isset($f['tid'])) {
                    $tids[] = intval($f['tid']);
                }
            }
            if ($tids) {
                return $tids;
            }
        }
        return false;
    }

}

