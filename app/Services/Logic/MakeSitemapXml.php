<?php
namespace App\Services\Logic;
use App\Services\Logic\ILogic;
ini_set("memory_limit", "4096M");
define('APPLICATION_PATH', __DIR__ . '/../../');
/**
 * サイトマップxml作成
 */
class MakeSitemapXml implements ILogic
{
	protected $_http = "https://";
	protected $_domain = "poke.siyoz.net";
	protected $_sitemap = "sitemap";
	protected $_sitemap_xml = "sitemap.xml";
	protected $_sitemap_gz = "sitemap/gz";
	protected $_sitemap_gz_url = "sitemap_gz";
	protected $_module = "default";
	private $_kz;
	public function __construct()
	{
		$this->_kz = app('Kz_Core');
	}
	public function execLogic()
	{
echo "makeIndex\n";
		$this->_makeIndex();
		$cnts = array();
echo "makeMeet\n";
		$sitemapname = "meet";
		$cnts[$sitemapname] = $this->_makeMeet($sitemapname);
echo $cnts[$sitemapname]."\n";
echo "makeMatch\n";
		$sitemapname = "match";
		$cnts[$sitemapname] = $this->_makeMatch($sitemapname);
echo $cnts[$sitemapname]."\n";
		$urls = array();
		$urls[] = $this->_http.$this->_domain."/" . $this->_sitemap_gz_url . "_index.xml.gz";
		$this->_kz->set_sitemapindex_file(APPLICATION_PATH . "/../public/". $this->_sitemap ."/".$this->_sitemap_xml, $urls);

		foreach ($cnts as $sitemapname => $cnt) {
			$this->_makeSitemapindex($cnt, $sitemapname);
		}

	}
	protected function _makeSitemapUrls($cnt, $name) {
		$urls = array();
		for ($i = 0; $i < $cnt; $i++) {
		  $urls[] = $this->_http.$this->_domain."/" . $this->_sitemap_gz_url . "_".$name."_".($i+1).".xml.gz";
		}
		return $urls;
	}
	protected function _makeSitemapindex($cnt, $sitemapname)
	{
		$urls = $this->_makeSitemapUrls($cnt, $sitemapname);
echo $sitemapname."_".$this->_sitemap_xml."\n";
		$this->_kz->set_sitemapindex_file(APPLICATION_PATH . "/../public/". $this->_sitemap."/".$sitemapname."_".$this->_sitemap_xml, $urls);
	}
	protected function _makeIndex()
	{
		$urls = array();
		$urls[] = $this->_http.$this->_domain;
		$urls[] = $this->_http.$this->_domain. "/help/privacy";
		$urls[] = $this->_http.$this->_domain. "/help/company";
		$urls[] = $this->_http.$this->_domain. "/help/condition";

		if ($this->_domain == "poke.siyoz.net") {
			$codes = $this->_kz->get_dir_file(__DIR__ . "/../../../resources/blogs/poke/");
			if ($codes) {
				foreach ($codes as $code) {
					if (!preg_match("/.txt$/", $code)) continue;
					$urls[] = $this->_http.$this->_domain. "/blog/".str_replace(".txt", "", $code);
				}
			}
		}
		$this->_kz->set_sitemap_file_gz(APPLICATION_PATH . "/../public/" . $this->_sitemap_gz . "/index.xml", $urls);
	}
	protected function _makeMeet($sitemapname)
	{
		$meets = \App\Meet::findAllByAplId(1);
		$urls = array();
		$i = 1;
		$meets = app('App\Services\Meet')->getObjectsByRecords($meets);
		foreach ($meets as $meet) {
			if ($meet->fuser->del_flag) continue;
			$urls[] = $this->_http.$this->_domain. "/meet/".$meet->id;
		}
		$this->_kz->set_sitemap_file_gz(APPLICATION_PATH . "/../public/" . $this->_sitemap_gz . "/".$sitemapname."_".$i.".xml", $urls);
		return $i;
	}
	protected function _makeMatch($sitemapname)
	{
		$matches = \App\Match::findAllByAplId(1);
		$urls = array();
		$i = 1;
		$fusers = [];
		foreach ($matches as $match) {
			if (array_key_exists($match->fuser_id, $fusers)) {
				$match->fuser = $fusers[$match->fuser_id];
			} else {
				$fuser = \App\Match::find($match->id);
				$fusers[$match->fuser_id] = $fuser;
				$match->fuser = $fuser;
			}
			if ($match->fuser->del_flag) continue;
			$urls[] = $this->_http.$this->_domain. "/match/".$match->id;
		}
		$this->_kz->set_sitemap_file_gz(APPLICATION_PATH . "/../public/" . $this->_sitemap_gz . "/".$sitemapname."_".$i.".xml", $urls);
		return $i;
	}
}
