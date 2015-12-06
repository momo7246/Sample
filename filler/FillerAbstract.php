<?php

abstract class FillerAbstract
{
    public function __construct(
        ContainerInterface $container,
        $relatedSDK
    ) {
        $this->container = $container;
        $this->relatedSDK = $relatedSDK;
    }

    public function search($params)
    {
        $related = $this->relatedSDK->getAll($params);

        return !empty($related) ? $related : [];
    }

    public function getExcludedIds(array $ids, $related)
    {
        if (!empty($related)) {
            foreach ($related as $r) {
                $ids[] = $r['id'];
            }
        }

        return implode(",", $ids);
    }

    public function getAdditionalParams($id, $related = array())
    {
        return [
            'exclude_ids'   => $this->getExcludedIds(array($id), $related)
        ];
    }

    abstract public function getRelated($post, $options);
}