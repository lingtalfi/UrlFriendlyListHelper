<?php

namespace UrlFriendlyListHelper\Plugin\Pagination;

/*
 * LingTalfi 2015-11-01
 * 
 * This example plugin displays $width pagination links.
 * 
 */


use Bat\StringTool;
use UrlFriendlyListHelper\ItemGenerator\ItemGeneratorInterface;
use UrlFriendlyListHelper\Plugin\BaseListHelperPlugin;

class MyHtmlPaginationPlugin extends BaseListHelperPlugin
{

    private $nbRows;
    private $width;
    private $activeLinkAttr;

    /**
     * @var ItemGeneratorInterface
     */
    private $generator;

    public function __construct()
    {
        parent::__construct();
        $this->width = 5;
        $this->activeLinkAttr = ['class' => 'active'];
        $this->pluginParams['nbItemsPerPage'] = 10;
    }

    public static function create()
    {
        return new static();
    }

    public function renderHtml()
    {
        $s = '';
        $currentPage = (int)$this->widgetParams['page'];
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $nbTotalPages = (int)ceil($this->generator->getNbTotalItems() / $this->pluginParams['nbItemsPerPage']);
        if ($currentPage > $nbTotalPages) {
            $currentPage = $nbTotalPages;
        }

        if ($nbTotalPages > $this->width) {
            $nbTotalPages = $this->width;
        }


        $concreteName = $this->getConcreteName('page');

        for ($i = 1; $i <= $nbTotalPages; $i++) {
            if (1 !== $i) {
                $s .= ' | ';
            }


            $sActive = '';
            if ($i === $currentPage) {
                $sActive = StringTool::htmlAttributes($this->activeLinkAttr);
            }

            $href = $this->listHelper->getRouter()->getUrl([$concreteName => $i]);

            $s .= '<a href="' . htmlspecialchars($href) . '"' . $sActive . '>' . $i . '</a>';
        }
        return $s;
    }

    public function meetGenerator(ItemGeneratorInterface $g)
    {
        $this->generator = $g;
    }


    public function getDefaultWidgetParameters()
    {
        return [
            'page' => 1,
        ];
    }


    public function setNbItemsPerPage($nbItemsPerPage)
    {
        $this->pluginParams['nbItemsPerPage'] = $nbItemsPerPage;
        return $this;
    }


    public function setActiveLinkAttr(array $activeLinkAttr)
    {
        $this->activeLinkAttr = $activeLinkAttr;
        return $this;
    }


}
