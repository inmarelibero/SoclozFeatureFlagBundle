<?php

/*
 * Copyright CloseToMe 2011/2012
 */

namespace Socloz\FeatureFlagBundle\State;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;

/**
 * Description of StateChain
 *
 * @author jfb
 */
class StateChain implements StateInterface
{

    protected $chain;
    
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param array $states
     */
    public function __construct($container, $states)
    {
        $this->chain = array();
        foreach ($states as $state) {
            try {
                $service = $container->get($state, ContainerInterface::NULL_ON_INVALID_REFERENCE);
            } catch (InactiveScopeException $e) {
                continue;
            }
            if ($service) {
                $this->chain[] = $service;
            }
        }
    }
    
    public function setFeatureEnabled($feature, $enabled)
    {
        foreach ($this->chain as $item) {
            $item->setFeatureEnabled($feature, $enabled);
        }
    }
    
    public function getFeatureEnabled($feature)
    {
        foreach ($this->chain as $item) {
            $ret = $item->getFeatureEnabled($feature);
            if ($ret !== null) {
                return $ret;
            }
        }
        return null;
    }
    
    public function setFeatureVariation($feature, $variation)
    {
        foreach ($this->chain as $item) {
            $item->setFeatureVariation($feature, $variation);
        }
    }
    
    public function getFeatureVariation($feature)
    {
        foreach ($this->chain as $item) {
            $ret = $item->getFeatureVariation($feature);
            if ($ret !== null) {
                return $ret;
            }
        }
        return null;
    }
}
