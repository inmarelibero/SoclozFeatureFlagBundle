<?php

/*
 * Copyright CloseToMe 2011/2012
 */

namespace Socloz\FeatureFlagBundle\State;

/**
 * Fetches feature states in the user session
 *
 * @author jfb
 */
class Request implements StateInterface
{

    protected $request;
    
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }
    
    /**
     * Returns the session key
     * 
     * @param string $type
     */
    private function getSessionKey($type)
    {
        return strtr("socloz_feature_flag_$type", " .[]", "____");
    }
    
    /**
     * {@inheritDoc}
     */
    public function setFeatureEnabled($feature, $enabled)
    {
    }
    
    /**
     * {@inheritDoc}
     */
    public function getFeatureEnabled($feature)
    {
        $key = $this->getSessionKey("${feature}_enabled");
        return $this->request->query->has($key) ? $this->request->query->get($key) : null;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setFeatureVariation($feature, $variation)
    {
    }
    
    /**
     * {@inheritDoc}
     */
    public function getFeatureVariation($feature)
    {
        $key = $this->getSessionKey("${feature}_variation");
        return $this->request->query->has($key) ? $this->request->query->get($key) : null;
    }

}
