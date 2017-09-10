<?php
namespace App\Services\Logic;
use App\Services\Logic\ILogic;
class MakeSitemapXmlGmae extends MakeSitemapXml implements ILogic
{
	protected $_domain = "game.siyoz.net";
	protected $_sitemap = "sitemap";
	protected $_sitemap_xml = "sitemap.xml";
	protected $_sitemap_gz = "sitemap/gz";
	protected $_sitemap_gz_url = "sitemap_gz";
	protected $_module = "default";
}
