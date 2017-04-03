<?php
namespace AppBundle\Utils;

use AppBundle\Entity\Job;
use DOMDocument;
use DOMXPath;

/**
 * Enables the parsing of the employment page of alsacreation
 * 
 * @author Blety
 */
class HtmlParser {

    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }
    /**
     * Returns the html pages as an array of strings
     * 
     * @return array
     */
    public function getHtml() 
    {
        $typeContrat = array(
            'stage' => 'typecontratstage', 
            'cdd' => 'typecontratcdd', 
            'cdi' => 'typecontratcdi',
            'apprentissage' => 'typecontratapprentissage',
            'pro' => 'typecontratpro', 
            'teletravail' => 'teletravail'
        );
        foreach ($typeContrat as $k => $type) 
        {
            $url = $this->url."/?action=q&g_type=offres&".$type."=1&q=&region=";
            $html[$k] = file_get_contents($url);
        }
        
        return $html;
    }
    
    /**
     * Parses the html pages and returns array of Job entities
     * @return array
     */
    public function parseHtml()
    {
        $jobs = array();
        $html = $this->getHtml();
        
        foreach ($html as $k => $page) 
        {
            $dom = new DOMDocument();
            @$dom->loadHTML($page);
            $finder = new DOMXPath($dom);
            $classname = "offre";
            $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
            for ($i = 0; $i < $nodes->length; $i++) {
                $offreDom = $nodes->item($i);
                $job = new Job();
                $job->setTitle($offreDom->childNodes->item(0)->childNodes->item(1)->childNodes->item(1)->nodeValue);
                $job->setCompany($offreDom->childNodes->item(0)->childNodes->item(1)->childNodes->item(4)->nodeValue);

                $locationDom = $finder->query('.//span[@class="lieu"]', $offreDom);
                $location = ($locationDom->length == 0) ? '' : $locationDom->item(0)->nodeValue;
                $job->setLocation($location);
                $job->setType($k);

                $jobs[] = $job;
            }
        }
        
        return $jobs;
    }
}
