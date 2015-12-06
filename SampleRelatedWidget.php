<?php

/**
 * Sample Related Widget
 */
class SampleRelatedWidget extends AbstractWidget
{
    protected $container;
    protected $config;

    public function __construct(
        EngineInterface $templatingEngine,
        ContainerInterface $container,
        array $data = array(),
        array $parameters = array()
    ) {
        parent::__construct($data, $parameters);

        $this->container = $container;
        $this->setEngine($templatingEngine);
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getFulfillService()
    {
        return $this->container->getParameter('sample_ralated_filler');
    }

    public function render($data = array()) {
        parent::render($this->getData());
    }

    protected function getListOfRelated($related = [])
    {
        $lists = [];
        foreach ($this->getFulfillService() as $fulfillService) {
            $newLists = $this->container->get($fulfillService)->getRelated($related, $this->config);
            $lists = array_merge($lists, $newLists);
        }
        $data['related'] = $lists;
        if (count($data['related']) > $this->config['limit']) {
            $data['related'] = array_slice(array_unique($data['related'], SORT_REGULAR), 0, $this->config['limit']);
        }
        $data['hasRelated'] = !empty($data['related']);

        $this->addData($data);
    }
}