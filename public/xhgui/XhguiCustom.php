<?php
class XhguiCustom
{
	public static function start()
	{
		xhprof_enable();
	}
	// stop profiler
	public static function finish()
	{
		// stop profiler
		$xhprof_data = xhprof_disable();
		$XHPROF_ROOT = "/var/www/xhgui";//dirname(__FILE__); // xhprofをインストールしたディレクトリ
		$XHPROF_SOURCE_NAME = 'app_name';			// アプリ名とか識別する名前
		global $_xhprof;
		define('XHPROF_LIB_ROOT', $XHPROF_ROOT . '/xhprof_lib/');
		include_once $XHPROF_ROOT . "/xhprof_lib/config.php";
		include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
		include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";
		$xhprof_runs = new XHProfRuns_Default();
		$run_id = $xhprof_runs->save_run($xhprof_data, $XHPROF_SOURCE_NAME);
		// echo "<!--<a href=\"/xhgui/xhprof_html/index/php\">xhprof Result</a>\n-->";
	}
}

