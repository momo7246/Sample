<?php

class SampleRelatedFillerOne extends FillerAbstract
{
    public function getRelated($post, $options)
    {
        if (empty($post)) {

            return [];
        }
        $tags = $this->getTags($post['terms']);
        $related = array();
        while (count($related) < $options['limit'] && !empty($tags)) {
            $params = array_merge($options, $tags, $this->getAdditionalParams($post['id'], $related));
            $related = array_merge($related, $this->search($params));
            array_pop($tags);
        }
        return $related;
    }

    protected function getTags($terms)
    {
        $categories = $this->container->getParameter('categories');
        if (empty($terms)) {

            return [];
        }
        $searchKeys = [];
        foreach ($categories as $key => $value) {
            if (empty($terms[$value])) {
                continue;
            }
            $searchKeys[$value] = $terms[$value]['name'];
        }

        return $searchKeys;
    }
}
