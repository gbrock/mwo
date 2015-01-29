<?php

class AssetController extends BaseController {

	/**
	 * Whether or not the headers should cache the output
	 * @var boolean
	 */
	protected $cache = TRUE;

	/**
	 * Renders a LESS file based on a given CSS request.
	 * @param  string
	 */
	public function getStylesheet($sRequestScript = '')
	{
		$sCacheKey = 'css:' . $sRequestScript;
		$bAllowCache = $this->cache;
		$iCacheMinutes = 60*12;

		if($bAllowCache && Cache::has($sCacheKey))
		{
			$sContent = Cache::get($sCacheKey);
		}
		else
		{
			// The LESS parser
			$oParserOptions = array(
				
			);
			$oParser = new Less_Parser($oParserOptions);

			// Bootstrap and FontAwesome will be included only for "screen.css".
			$bIncludePlugins = (substr($sRequestScript, -10) === 'screen.css');
			$sBootstrapPath = base_path('vendor/twbs/bootstrap/less/bootstrap.less');
			$sFontAwesomePath = base_path('vendor/fortawesome/font-awesome/less/font-awesome.less');

			// Where to find the LESS file
			$sLessPath = 'views/assets/less/';

			// Swap out the extension for .less
			$sLessFilename = substr_replace($sRequestScript, 'less', -3);

			// What real LESS file are we looking for
			$sSrcFile = app_path($sLessPath . $sLessFilename);

			if(!file_exists($sSrcFile))
			{
				App::abort(404);
			}

			if($bIncludePlugins)
			{
				// Add Bootstrap (variables declared later will take precedence)
				$oParser->parseFile($sBootstrapPath);
				// Add FontAwesome
				$oParser->parseFile($sFontAwesomePath);
			}

			// Parse the file
			$sContent = $oParser
							->parseFile($sSrcFile, url())
							->getCss();

			if($bAllowCache)
			{
				Cache::put($sCacheKey, $sContent, $iCacheMinutes);
			}
		}

		if(!$bAllowCache)
		{
			Cache::forget($sCacheKey);
		}
		
		$response = Response::make($sContent);
		$response->header('Content-Type', 'text/css');

		if($bAllowCache)
		{
			$response = $this->cacheHeaders(60*60*2, $response); // two hours
		}


		return $response;
	}

	/**
	 * Renders a JS file based on a given request.
	 * @param  string
	 */
	public function getJavascript($sRequestScript = '')
	{
		$sContent = FALSE;
		$sCacheKey = 'js:' . $sRequestScript;
		$bAllowCache = $this->cache;
		$iCacheMinutes = 60*12;

		if($bAllowCache && Cache::has($sCacheKey))
		{
			$sContent = Cache::get($sCacheKey);
		}
		else
		{
			// Where to find the JS file
			$sScriptPath = 'views/assets/js/';

			$sScriptFilename = $sRequestScript;

			// What real JS file are we looking for
			$sJSFile = app_path($sScriptPath . $sScriptFilename);
			$sPHPFile = $sJSFile . '.php';


			if(file_exists($sJSFile))
			{
				$sContent = file_get_contents($sJSFile);
			}
			elseif(file_exists($sPHPFile))
			{
				ob_start();
				include($sPHPFile);
				$sContent = ob_get_clean();
			}
			else
			{
				App::abort(404);
			}


			if($sContent && $bAllowCache)
			{
				Cache::put($sCacheKey, $sContent, $iCacheMinutes);
			}
		}

		if(!$bAllowCache)
		{
			Cache::forget($sCacheKey);
		}

		if(!$sContent)
		{
			App::abort(404);
		}

		$response = Response::make($sContent);
		$response->header('Content-Type', 'application/javascript');

		if($bAllowCache)
		{
			$response = $this->cacheHeaders(60*60*2, $response); // two hours
		}

		return $response;
	}

	/**
	 * Finds the font file specified and serves it to the browser.
	 * @param  string
	 */
	public function getFont($sRequestFont = '')
	{
		$sFontAwesomePath = base_path('vendor/fortawesome/font-awesome/fonts/');
		$sFontPath = $sFontAwesomePath . $sRequestFont;

		if(file_exists($sFontPath))
		{
			// open the file in a binary mode
			$fp = fopen($sFontPath, 'rb');
			$path = pathinfo($sFontPath);

			switch($path['extension'])
			{
				case 'eot':
					$sHeader = 'application/vnd.ms-fontobject';
					break;
				case 'svg':
					$sHeader = 'image/svg+xml';
					break;
				case 'ttf':
					$sHeader = 'application/x-font-ttf';
					break;
				case 'woff':
					$sHeader = 'application/x-font-woff';
					break;
				case 'woff2':
					$sHeader = 'application/x-font-woff2';
					break;
				case 'otf':
					$sHeader = 'application/x-font-otf';
					break;

			}
			// send the right headers
			header("Content-Type: " . $sHeader);
			header("Content-Length: " . filesize($sFontPath));

			// how long to cache it
			$this->cacheHeaders(60*60*24);

			// dump the font and stop the script
			fpassthru($fp);
			exit;
		}

		App::abort(404);
	}

	public function getImg($request_path)
	{
		$root = app_path() . '/uploads/';
		$path = $root . $request_path;

		try
		{
			$file = new Symfony\Component\HttpFoundation\File\File($path);
		}
		catch(Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $e)
		{
			return App::abort(404);
		}

		// Craft the response
		$response = Response::make(
			File::get($path), 
			200
		);

		// Set the main content headers
		$response->header(
			'Content-type',
			$file->getMimeType()
		);

		return $response;
	}

	protected function cacheHeaders($iSeconds = 3600, $respObj = FALSE)
	{
		$sValidUntil = gmdate('D, d M Y H:i:s', time() + $iSeconds) . ' GMT';

		if($respObj)
		{
			$respObj->header('Cache-Control', 'public');
			$respObj->header('Expires', $sValidUntil);

			return $respObj;
		}
		else
		{
			header('Cache-Control: public');
			header('Expires: ' . $sValidUntil);
		}
	}

}
