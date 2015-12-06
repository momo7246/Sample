<?php

class SampleRelatedFillerTwo extends FillerAbstract
{
    public function getRelated($post, $options)
    {
        if (!empty($post)) {
            $options = array_merge($options, $this->getAdditionalParams($post['id']));
        }
        $related = $this->search($options);

        return $related;
    }
}