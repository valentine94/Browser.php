<?php
/**
 * @file
 * Browser class definition file.
 *
 * The class has been forked from https://github.com/cbschuld/Browser.php.
 */

/**
 * Typical Usage.
 *
 * @code
 *   $browser = new Browser();
 *   if ($browser->getBrowser() == Browser::BROWSER_FIREFOX
 *   && $browser->getVersion() >= 2) {
 *    echo 'You have FireFox version 2 or greater';
 *   }
 */

/**
 * Class Browser.
 */
class Browser {
  private $httpAgent = '';
  private $webBrowserName = '';
  private $browserVersion = '';
  private $browserPlatform = '';
  private $operationSystem = '';
  private $isAol = FALSE;
  private $isMobile = FALSE;
  private $isTablet = FALSE;
  private $isRobot = FALSE;
  private $isFacebook = FALSE;
  private $aolVersion = '';
  const BROWSER_UNKNOWN = 'unknown';
  const VERSION_UNKNOWN = 'unknown';
  const BROWSER_OPERA = 'Opera';
  const BROWSER_OPERA_MINI = 'Opera Mini';
  const BROWSER_WEBTV = 'WebTV';
  const BROWSER_IE = 'Internet Explorer';
  const BROWSER_POCKET_IE = 'Pocket Internet Explorer';
  const BROWSER_KONQUEROR = 'Konqueror';
  const BROWSER_ICAB = 'iCab';
  const BROWSER_OMNIWEB = 'OmniWeb';
  const BROWSER_FIREBIRD = 'Firebird';
  const BROWSER_FIREFOX = 'Firefox';
  const BROWSER_ICEWEASEL = 'Iceweasel';
  const BROWSER_SHIRETOKO = 'Shiretoko';
  const BROWSER_MOZILLA = 'Mozilla';
  const BROWSER_AMAYA = 'Amaya';
  const BROWSER_LYNX = 'Lynx';
  const BROWSER_SAFARI = 'Safari';
  const BROWSER_IPHONE = 'iPhone';
  const BROWSER_IPOD = 'iPod';
  const BROWSER_IPAD = 'iPad';
  const BROWSER_CHROME = 'Chrome';
  const BROWSER_ANDROID = 'Android';
  const BROWSER_GOOGLEBOT = 'GoogleBot';
  const BROWSER_SLURP = 'Yahoo! Slurp';
  const BROWSER_W3CVALIDATOR = 'W3C Validator';
  const BROWSER_BLACKBERRY = 'BlackBerry';
  const BROWSER_ICECAT = 'IceCat';
  const BROWSER_NOKIA_S60 = 'Nokia S60 OSS Browser';
  const BROWSER_NOKIA = 'Nokia Browser';
  const BROWSER_MSN = 'MSN Browser';
  const BROWSER_MSNBOT = 'MSN Bot';
  const BROWSER_BINGBOT = 'Bing Bot';
  const BROWSER_NETSCAPE_NAVIGATOR = 'Netscape Navigator';
  const BROWSER_GALEON = 'Galeon';
  const BROWSER_NETPOSITIVE = 'NetPositive';
  const BROWSER_PHOENIX = 'Phoenix';
  const PLATFORM_UNKNOWN = 'unknown';
  const PLATFORM_WINDOWS = 'Windows';
  const PLATFORM_WINDOWS_CE = 'Windows CE';
  const PLATFORM_APPLE = 'Apple';
  const PLATFORM_LINUX = 'Linux';
  const PLATFORM_OS2 = 'OS/2';
  const PLATFORM_BEOS = 'BeOS';
  const PLATFORM_IPHONE = 'iPhone';
  const PLATFORM_IPOD = 'iPod';
  const PLATFORM_IPAD = 'iPad';
  const PLATFORM_BLACKBERRY = 'BlackBerry';
  const PLATFORM_NOKIA = 'Nokia';
  const PLATFORM_FREEBSD = 'FreeBSD';
  const PLATFORM_OPENBSD = 'OpenBSD';
  const PLATFORM_NETBSD = 'NetBSD';
  const PLATFORM_SUNOS = 'SunOS';
  const PLATFORM_OPENSOLARIS = 'OpenSolaris';
  const PLATFORM_ANDROID = 'Android';
  const OPERATING_SYSTEM_UNKNOWN = 'unknown';

  /**
   * Browser constructor.
   *
   * @param string $user_agent
   *   User agent($_SERVER['HTTP_USER_AGENT']).
   */
  public function __construct($user_agent = "") {
    $this->reset();
    if ($user_agent != "") {
      $this->setUserAgent($user_agent);
    }
    else {
      $this->determine();
    }
  }

  /**
   * Reset all properties.
   */
  public function reset() {
    $this->httpAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
    $this->webBrowserName = self::BROWSER_UNKNOWN;
    $this->browserVersion = self::VERSION_UNKNOWN;
    $this->browserPlatform = self::PLATFORM_UNKNOWN;
    $this->operationSystem = self::OPERATING_SYSTEM_UNKNOWN;
    $this->isAol = FALSE;
    $this->isMobile = FALSE;
    $this->isTablet = FALSE;
    $this->isRobot = FALSE;
    $this->isFacebook = FALSE;
    $this->aolVersion = self::VERSION_UNKNOWN;
  }

  /**
   * Check to see if the specific browser is valid.
   *
   * @param string $browser_name
   *   Browser name.
   *
   * @return bool
   *   True if the browser is the specified browser.
   */
  public function isBrowser($browser_name) {
    return (0 == strcasecmp($this->webBrowserName, trim($browser_name)));
  }
  /**
   * The name of the browser.
   *
   * All return types are from the class constants.
   *
   * @return string
   *   Name of the browser.
   */
  public function getBrowser() {
    return $this->webBrowserName;
  }
  /**
   * Set the name of the browser.
   *
   * @param string $browser
   *   The name of the Browser.
   */
  public function setBrowser($browser) {
    $this->webBrowserName = $browser;
  }
  /**
   * The name of the platform.
   *
   * All return types are from the class constants.
   *
   * @return string
   *   Name of the browser.
   */
  public function getPlatform() {
    return $this->browserPlatform;
  }
  /**
   * Set the name of the platform.
   *
   * @param string $platform
   *   The name of the Platform.
   */
  public function setPlatform($platform) {
    $this->browserPlatform = $platform;
  }
  /**
   * The version of the browser.
   *
   * @return string
   *   Version of the browser
   *   (will only contain alpha-numeric characters and a period).
   */
  public function getVersion() {
    return $this->browserVersion;
  }
  /**
   * Set the version of the browser.
   *
   * @param string $version
   *   The version of the Browser.
   */
  public function setVersion($version) {
    $this->browserVersion = preg_replace('/[^0-9,.,a-z,A-Z-]/', '', $version);
  }
  /**
   * The version of AOL.
   *
   * @return string
   *   Version of AOL
   *   (will only contain alpha-numeric characters and a period).
   */
  public function getAolVersion() {
    return $this->aolVersion;
  }
  /**
   * Set the version of AOL.
   *
   * @param string $version
   *   The version of AOL.
   */
  public function setAolVersion($version) {
    $this->aolVersion = preg_replace('/[^0-9,.,a-z,A-Z]/', '', $version);
  }
  /**
   * Is the browser from AOL?.
   *
   * @return bool
   *   True if the browser is from AOL otherwise false.
   */
  public function isAol() {
    return $this->isAol;
  }
  /**
   * Is the browser from a mobile device?.
   *
   * @return bool
   *   True if the browser is from a mobile device otherwise false.
   */
  public function isMobile() {
    return $this->isMobile;
  }
  /**
   * Is the browser from a tablet device?.
   *
   * @return bool
   *   True if the browser is from a tablet device otherwise false.
   */
  public function isTablet() {
    return $this->isTablet;
  }
  /**
   * Is the browser from a robot (ex Slurp,GoogleBot)?.
   *
   * @return bool
   *   True if the browser is from a robot otherwise false.
   */
  public function isRobot() {
    return $this->isRobot;
  }
  /**
   * Is the browser from facebook?.
   *
   * @return bool
   *   True if the browser is from facebook otherwise false.
   */
  public function isFacebook() {
    return $this->isFacebook;
  }
  /**
   * Set the browser to be from AOL.
   *
   * @param bool $is_aol
   *   Is AOL value.
   */
  public function setAol($is_aol) {
    $this->isAol = $is_aol;
  }
  /**
   * Set the Browser to be mobile.
   *
   * @param bool $value
   *   Value param for isMobile.
   */
  protected function setMobile($value = TRUE) {
    $this->isMobile = $value;
  }
  /**
   * Set the Browser to be tablet.
   *
   * @param bool $value
   *   Value param for isTablet.
   */
  protected function setTablet($value = TRUE) {
    $this->isTablet = $value;
  }
  /**
   * Set the Browser to be a robot.
   *
   * @param bool $value
   *   Value param for isRobot.
   */
  protected function setRobot($value = TRUE) {
    $this->isRobot = $value;
  }
  /**
   * Set the Browser to be a Facebook request.
   *
   * @param bool $value
   *   Value param for isFacebook.
   */
  protected function setFacebook($value = TRUE) {
    $this->isFacebook = $value;
  }
  /**
   * Get the user agent value in use to determine the browser.
   *
   * @return string
   *   The user agent from the HTTP header.
   */
  public function getUserAgent() {
    return $this->httpAgent;
  }
  /**
   * Set the user agent value.
   *
   * The construction will use the HTTP header value - this will overwrite it.
   *
   * @param string $agent_string
   *   The value for the User Agent.
   */
  public function setUserAgent($agent_string) {
    $this->reset();
    $this->httpAgent = $agent_string;
    $this->determine();
  }
  /**
   * Used to determine if the browser is actually "chromeframe".
   *
   * @since 1.7
   *
   * @return bool
   *   True if the browser is using chromeframe.
   */
  public function isChromeFrame() {
    return (strpos($this->httpAgent, "chromeframe") !== FALSE);
  }
  /**
   * Returns a formatted string with a summary of the details of the browser.
   *
   * @return string
   *   Formatted string with a summary of the browser.
   */
  public function __toString() {
    return "<strong>Browser Name:</strong> {$this->getBrowser()}<br/>\n" .
    "<strong>Browser Version:</strong> {$this->getVersion()}<br/>\n" .
    "<strong>Browser User Agent String:</strong> {$this->getUserAgent()}<br/>\n" .
    "<strong>Platform:</strong> {$this->getPlatform()}<br/>";
  }
  /**
   * Protected routine to calculate and determine what the browser is in use.
   *
   * Including platform.
   */
  protected function determine() {
    $this->checkPlatform();
    $this->checkBrowsers();
    $this->checkForAol();
  }
  /**
   * Protected routine to determine the browser type.
   *
   * @return bool
   *   True if the browser was detected otherwise false.
   */
  protected function checkBrowsers() {
    return (
      $this->checkBrowserWebTv() ||
      $this->checkBrowserInternetExplorer() ||
      $this->checkBrowserOpera() ||
      $this->checkBrowserGaleon() ||
      $this->checkBrowserNetscapeNavigator9Plus() ||
      $this->checkBrowserFirefox() ||
      $this->checkBrowserChrome() ||
      $this->checkBrowserOmniWeb() ||
      $this->checkBrowserAndroid() ||
      $this->checkBrowseriPad() ||
      $this->checkBrowseriPod() ||
      $this->checkBrowseriPhone() ||
      $this->checkBrowserBlackBerry() ||
      $this->checkBrowserNokia() ||
      $this->checkBrowserGoogleBot() ||
      $this->checkBrowserMsnBot() ||
      $this->checkBrowserBingBot() ||
      $this->checkBrowserSlurp() ||
      $this->checkFacebookExternalHit() ||
      $this->checkBrowserSafari() ||
      $this->checkBrowserNetPositive() ||
      $this->checkBrowserFirebird() ||
      $this->checkBrowserKonqueror() ||
      $this->checkBrowserIcab() ||
      $this->checkBrowserPhoenix() ||
      $this->checkBrowserAmaya() ||
      $this->checkBrowserLynx() ||
      $this->checkBrowserShiretoko() ||
      $this->checkBrowserIceCat() ||
      $this->checkBrowserIceweasel() ||
      $this->checkBrowserWorldWideWebConsortiumValidator() ||
      $this->checkBrowserMozilla()
    );
  }
  /**
   * Determine if the user is using a BlackBerry (last updated 1.7).
   *
   * @return bool
   *   True if the browser is the BlackBerry browser otherwise false.
   */
  protected function checkBrowserBlackBerry() {
    if (stripos($this->httpAgent, 'blackberry') !== FALSE) {
      $aresult = explode("/", stristr($this->httpAgent, "BlackBerry"));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion($aversion[0]);
        $this->webBrowserName = self::BROWSER_BLACKBERRY;
        $this->setMobile(TRUE);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the user is using an AOL User Agent (last updated 1.7).
   *
   * @return bool
   *   True if the browser is from AOL otherwise false.
   */
  protected function checkForAol() {
    $this->setAol(FALSE);
    $this->setAolVersion(self::VERSION_UNKNOWN);
    if (stripos($this->httpAgent, 'aol') !== FALSE) {
      $aversion = explode(' ', stristr($this->httpAgent, 'AOL'));
      if (isset($aversion[1])) {
        $this->setAol(TRUE);
        $this->setAolVersion(preg_replace('/[^0-9\.a-z]/i', '', $aversion[1]));
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is the GoogleBot or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is the GoogletBot otherwise false.
   */
  protected function checkBrowserGoogleBot() {
    if (stripos($this->httpAgent, 'googlebot') !== FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'googlebot'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion(str_replace(';', '', $aversion[0]));
        $this->webBrowserName = self::BROWSER_GOOGLEBOT;
        $this->setRobot(TRUE);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is the MSNBot or not (last updated 1.9).
   *
   * @return bool
   *   True if the browser is the MSNBot otherwise false.
   */
  protected function checkBrowserMsnBot() {
    if (stripos($this->httpAgent, "msnbot") !== FALSE) {
      $aresult = explode("/", stristr($this->httpAgent, "msnbot"));
      if (isset($aresult[1])) {
        $aversion = explode(" ", $aresult[1]);
        $this->setVersion(str_replace(";", "", $aversion[0]));
        $this->webBrowserName = self::BROWSER_MSNBOT;
        $this->setRobot(TRUE);
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Determine if the browser is the BingBot or not (last updated 1.9).
   *
   * @return bool
   *   True if the browser is the BingBot otherwise false.
   */
  protected function checkBrowserBingBot() {
    if (stripos($this->httpAgent, "bingbot") !== FALSE) {
      $aresult = explode("/", stristr($this->httpAgent, "bingbot"));
      if (isset($aresult[1])) {
        $aversion = explode(" ", $aresult[1]);
        $this->setVersion(str_replace(";", "", $aversion[0]));
        $this->webBrowserName = self::BROWSER_BINGBOT;
        $this->setRobot(TRUE);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is the W3C Validator or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is the W3C Validator otherwise false.
   */
  protected function checkBrowserWorldWideWebConsortiumValidator() {
    if (stripos($this->httpAgent, 'W3C-checklink') !== FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'W3C-checklink'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion($aversion[0]);
        $this->webBrowserName = self::BROWSER_W3CVALIDATOR;
        return TRUE;
      }
    }
    elseif (stripos($this->httpAgent, 'W3C_Validator') !== FALSE) {
      // Some of the Validator versions do not delineate w/
      // a slash - add it back in.
      $ua = str_replace("W3C_Validator ", "W3C_Validator/", $this->httpAgent);
      $aresult = explode('/', stristr($ua, 'W3C_Validator'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion($aversion[0]);
        $this->webBrowserName = self::BROWSER_W3CVALIDATOR;
        return TRUE;
      }
    }
    elseif (stripos($this->httpAgent, 'W3C-mobileOK') !== FALSE) {
      $this->webBrowserName = self::BROWSER_W3CVALIDATOR;
      $this->setMobile(TRUE);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is the Yahoo! Slurp Robot or not.
   *
   * @return bool
   *   True if the browser is the Yahoo! Slurp Robot otherwise false.
   */
  protected function checkBrowserSlurp() {
    if (stripos($this->httpAgent, 'slurp') !== FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'Slurp'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion($aversion[0]);
        $this->webBrowserName = self::BROWSER_SLURP;
        $this->setRobot(TRUE);
        $this->setMobile(FALSE);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Internet Explorer or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Internet Explorer otherwise false.
   */
  protected function checkBrowserInternetExplorer() {
    if (stripos($this->httpAgent, 'Trident/7.0; rv:11.0') !== FALSE) {
      $this->setBrowser(self::BROWSER_IE);
      $this->setVersion('11.0');
      return TRUE;
    }
    elseif (stripos($this->httpAgent, 'microsoft internet explorer') !== FALSE) {
      $this->setBrowser(self::BROWSER_IE);
      $this->setVersion('1.0');
      $aresult = stristr($this->httpAgent, '/');
      if (preg_match('/308|425|426|474|0b1/i', $aresult)) {
        $this->setVersion('1.5');
      }
      return TRUE;
    }
    elseif (stripos($this->httpAgent, 'msie') !== FALSE && stripos($this->httpAgent, 'opera') === FALSE) {
      // See if the browser is the odd MSN Explorer.
      if (stripos($this->httpAgent, 'msnb') !== FALSE) {
        $aresult = explode(' ', stristr(str_replace(';', '; ', $this->httpAgent), 'MSN'));
        if (isset($aresult[1])) {
          $this->setBrowser(self::BROWSER_MSN);
          $this->setVersion(str_replace(array('(', ')', ';'), '', $aresult[1]));
          return TRUE;
        }
      }
      $aresult = explode(' ', stristr(str_replace(';', '; ', $this->httpAgent), 'msie'));
      if (isset($aresult[1])) {
        $this->setBrowser(self::BROWSER_IE);
        $this->setVersion(str_replace(array('(', ')', ';'), '', $aresult[1]));
        if (stripos($this->httpAgent, 'IEMobile') !== FALSE) {
          $this->setBrowser(self::BROWSER_POCKET_IE);
          $this->setMobile(TRUE);
        }
        return TRUE;
      }
    }
    elseif (stripos($this->httpAgent, 'trident') !== FALSE) {
      $this->setBrowser(self::BROWSER_IE);
      $result = explode('rv:', $this->httpAgent);
      if (isset($result[1])) {
        $this->setVersion(preg_replace('/[^0-9.]+/', '', $result[1]));
        $this->httpAgent = str_replace(array("Mozilla", "Gecko"), "MSIE", $this->httpAgent);
      }
    }
    elseif (stripos($this->httpAgent, 'mspie') !== FALSE || stripos($this->httpAgent, 'pocket') !== FALSE) {
      $aresult = explode(' ', stristr($this->httpAgent, 'mspie'));
      if (isset($aresult[1])) {
        $this->setPlatform(self::PLATFORM_WINDOWS_CE);
        $this->setBrowser(self::BROWSER_POCKET_IE);
        $this->setMobile(TRUE);
        if (stripos($this->httpAgent, 'mspie') !== FALSE) {
          $this->setVersion($aresult[1]);
        }
        else {
          $aversion = explode('/', $this->httpAgent);
          if (isset($aversion[1])) {
            $this->setVersion($aversion[1]);
          }
        }
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Opera or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Opera otherwise false.
   */
  protected function checkBrowserOpera() {
    if (stripos($this->httpAgent, 'opera mini') !== FALSE) {
      $resultant = stristr($this->httpAgent, 'opera mini');
      if (preg_match('/\//', $resultant)) {
        $aresult = explode('/', $resultant);
        if (isset($aresult[1])) {
          $aversion = explode(' ', $aresult[1]);
          $this->setVersion($aversion[0]);
        }
      }
      else {
        $aversion = explode(' ', stristr($resultant, 'opera mini'));
        if (isset($aversion[1])) {
          $this->setVersion($aversion[1]);
        }
      }
      $this->webBrowserName = self::BROWSER_OPERA_MINI;
      $this->setMobile(TRUE);
      return TRUE;
    }
    elseif (stripos($this->httpAgent, 'opera') !== FALSE) {
      $resultant = stristr($this->httpAgent, 'opera');
      if (preg_match('/Version\/(1*.*)$/', $resultant, $matches)) {
        $this->setVersion($matches[1]);
      }
      elseif (preg_match('/\//', $resultant)) {
        $aresult = explode('/', str_replace("(", " ", $resultant));
        if (isset($aresult[1])) {
          $aversion = explode(' ', $aresult[1]);
          $this->setVersion($aversion[0]);
        }
      }
      else {
        $aversion = explode(' ', stristr($resultant, 'opera'));
        $this->setVersion(isset($aversion[1]) ? $aversion[1] : "");
      }
      if (stripos($this->httpAgent, 'Opera Mobi') !== FALSE) {
        $this->setMobile(TRUE);
      }
      $this->webBrowserName = self::BROWSER_OPERA;
      return TRUE;
    }
    elseif (stripos($this->httpAgent, 'OPR') !== FALSE) {
      $resultant = stristr($this->httpAgent, 'OPR');
      if (preg_match('/\//', $resultant)) {
        $aresult = explode('/', str_replace("(", " ", $resultant));
        if (isset($aresult[1])) {
          $aversion = explode(' ', $aresult[1]);
          $this->setVersion($aversion[0]);
        }
      }
      if (stripos($this->httpAgent, 'Mobile') !== FALSE) {
        $this->setMobile(TRUE);
      }
      $this->webBrowserName = self::BROWSER_OPERA;
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Chrome or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Chrome otherwise false.
   */
  protected function checkBrowserChrome() {
    if (stripos($this->httpAgent, 'Chrome') !== FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'Chrome'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion($aversion[0]);
        $this->setBrowser(self::BROWSER_CHROME);
        // Chrome on Android.
        if (stripos($this->httpAgent, 'Android') !== FALSE) {
          if (stripos($this->httpAgent, 'Mobile') !== FALSE) {
            $this->setMobile(TRUE);
          }
          else {
            $this->setTablet(TRUE);
          }
        }
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is WebTv or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is WebTv otherwise false.
   */
  protected function checkBrowserWebTv() {
    if (stripos($this->httpAgent, 'webtv') !== FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'webtv'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion($aversion[0]);
        $this->setBrowser(self::BROWSER_WEBTV);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is NetPositive or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is NetPositive otherwise false.
   */
  protected function checkBrowserNetPositive() {
    if (stripos($this->httpAgent, 'NetPositive') !== FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'NetPositive'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion(str_replace(array('(', ')', ';'), '', $aversion[0]));
        $this->setBrowser(self::BROWSER_NETPOSITIVE);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Galeon or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Galeon otherwise false.
   */
  protected function checkBrowserGaleon() {
    if (stripos($this->httpAgent, 'galeon') !== FALSE) {
      $aresult = explode(' ', stristr($this->httpAgent, 'galeon'));
      $aversion = explode('/', $aresult[0]);
      if (isset($aversion[1])) {
        $this->setVersion($aversion[1]);
        $this->setBrowser(self::BROWSER_GALEON);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Konqueror or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Konqueror otherwise false.
   */
  protected function checkBrowserKonqueror() {
    if (stripos($this->httpAgent, 'Konqueror') !== FALSE) {
      $aresult = explode(' ', stristr($this->httpAgent, 'Konqueror'));
      $aversion = explode('/', $aresult[0]);
      if (isset($aversion[1])) {
        $this->setVersion($aversion[1]);
        $this->setBrowser(self::BROWSER_KONQUEROR);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is iCab or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is iCab otherwise false.
   */
  protected function checkBrowserIcab() {
    if (stripos($this->httpAgent, 'icab') !== FALSE) {
      $aversion = explode(' ', stristr(str_replace('/', ' ', $this->httpAgent), 'icab'));
      if (isset($aversion[1])) {
        $this->setVersion($aversion[1]);
        $this->setBrowser(self::BROWSER_ICAB);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is OmniWeb or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is OmniWeb otherwise false.
   */
  protected function checkBrowserOmniWeb() {
    if (stripos($this->httpAgent, 'omniweb') !== FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'omniweb'));
      $aversion = explode(' ', isset($aresult[1]) ? $aresult[1] : "");
      $this->setVersion($aversion[0]);
      $this->setBrowser(self::BROWSER_OMNIWEB);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Phoenix or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Phoenix otherwise false.
   */
  protected function checkBrowserPhoenix() {
    if (stripos($this->httpAgent, 'Phoenix') !== FALSE) {
      $aversion = explode('/', stristr($this->httpAgent, 'Phoenix'));
      if (isset($aversion[1])) {
        $this->setVersion($aversion[1]);
        $this->setBrowser(self::BROWSER_PHOENIX);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Firebird or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Firebird otherwise false.
   */
  protected function checkBrowserFirebird() {
    if (stripos($this->httpAgent, 'Firebird') !== FALSE) {
      $aversion = explode('/', stristr($this->httpAgent, 'Firebird'));
      if (isset($aversion[1])) {
        $this->setVersion($aversion[1]);
        $this->setBrowser(self::BROWSER_FIREBIRD);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Netscape Navigator 9+ or not.
   *
   * NOTE: http://browser.netscape.com/
   * Official support ended on March 1st, 2008).
   *
   * @return bool
   *   True if the browser is Netscape Navigator 9+ otherwise false.
   */
  protected function checkBrowserNetscapeNavigator9Plus() {
    if (stripos($this->httpAgent, 'Firefox') !== FALSE && preg_match('/Navigator\/([^ ]*)/i', $this->httpAgent, $matches)) {
      $this->setVersion($matches[1]);
      $this->setBrowser(self::BROWSER_NETSCAPE_NAVIGATOR);
      return TRUE;
    }
    elseif (stripos($this->httpAgent, 'Firefox') === FALSE && preg_match('/Netscape6?\/([^ ]*)/i', $this->httpAgent, $matches)) {
      $this->setVersion($matches[1]);
      $this->setBrowser(self::BROWSER_NETSCAPE_NAVIGATOR);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Shiretoko or not.
   *
   * See: https://wiki.mozilla.org/Projects/shiretoko.
   *
   * @return bool
   *   True if the browser is Shiretoko otherwise false.
   */
  protected function checkBrowserShiretoko() {
    if (stripos($this->httpAgent, 'Mozilla') !== FALSE && preg_match('/Shiretoko\/([^ ]*)/i', $this->httpAgent, $matches)) {
      $this->setVersion($matches[1]);
      $this->setBrowser(self::BROWSER_SHIRETOKO);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Ice Cat or not.
   *
   * See: http://en.wikipedia.org/wiki/GNU_IceCat.
   *
   * @return bool
   *   True if the browser is Ice Cat otherwise false.
   */
  protected function checkBrowserIceCat() {
    if (stripos($this->httpAgent, 'Mozilla') !== FALSE && preg_match('/IceCat\/([^ ]*)/i', $this->httpAgent, $matches)) {
      $this->setVersion($matches[1]);
      $this->setBrowser(self::BROWSER_ICECAT);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Nokia or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Nokia otherwise false.
   */
  protected function checkBrowserNokia() {
    if (preg_match("/Nokia([^\/]+)\/([^ SP]+)/i", $this->httpAgent, $matches)) {
      $this->setVersion($matches[2]);
      if (stripos($this->httpAgent, 'Series60') !== FALSE || strpos($this->httpAgent, 'S60') !== FALSE) {
        $this->setBrowser(self::BROWSER_NOKIA_S60);
      }
      else {
        $this->setBrowser(self::BROWSER_NOKIA);
      }
      $this->setMobile(TRUE);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Firefox or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Firefox otherwise false.
   */
  protected function checkBrowserFirefox() {
    if (stripos($this->httpAgent, 'safari') === FALSE) {
      if (preg_match("/Firefox[\/ \(]([^ ;\)]+)/i", $this->httpAgent, $matches)) {
        $this->setVersion($matches[1]);
        $this->setBrowser(self::BROWSER_FIREFOX);
        // Firefox on Android.
        if (stripos($this->httpAgent, 'Android') !== FALSE) {
          if (stripos($this->httpAgent, 'Mobile') !== FALSE) {
            $this->setMobile(TRUE);
          }
          else {
            $this->setTablet(TRUE);
          }
        }
        return TRUE;
      }
      elseif (preg_match("/Firefox$/i", $this->httpAgent, $matches)) {
        $this->setVersion("");
        $this->setBrowser(self::BROWSER_FIREFOX);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Firefox or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Firefox otherwise false.
   */
  protected function checkBrowserIceweasel() {
    if (stripos($this->httpAgent, 'Iceweasel') !== FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'Iceweasel'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion($aversion[0]);
        $this->setBrowser(self::BROWSER_ICEWEASEL);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Mozilla or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Mozilla otherwise false.
   */
  protected function checkBrowserMozilla() {
    if (stripos($this->httpAgent, 'mozilla') !== FALSE && preg_match('/rv:[0-9].[0-9][a-b]?/i', $this->httpAgent) && stripos($this->httpAgent, 'netscape') === FALSE) {
      $aversion = explode(' ', stristr($this->httpAgent, 'rv:'));
      preg_match('/rv:[0-9].[0-9][a-b]?/i', $this->httpAgent, $aversion);
      $this->setVersion(str_replace('rv:', '', $aversion[0]));
      $this->setBrowser(self::BROWSER_MOZILLA);
      return TRUE;
    }
    elseif (stripos($this->httpAgent, 'mozilla') !== FALSE && preg_match('/rv:[0-9]\.[0-9]/i', $this->httpAgent) && stripos($this->httpAgent, 'netscape') === FALSE) {
      $aversion = explode('', stristr($this->httpAgent, 'rv:'));
      $this->setVersion(str_replace('rv:', '', $aversion[0]));
      $this->setBrowser(self::BROWSER_MOZILLA);
      return TRUE;
    }
    elseif (stripos($this->httpAgent, 'mozilla') !== FALSE && preg_match('/mozilla\/([^ ]*)/i', $this->httpAgent, $matches) && stripos($this->httpAgent, 'netscape') === FALSE) {
      $this->setVersion($matches[1]);
      $this->setBrowser(self::BROWSER_MOZILLA);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Lynx or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Lynx otherwise false.
   */
  protected function checkBrowserLynx() {
    if (stripos($this->httpAgent, 'lynx') !== FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'Lynx'));
      $aversion = explode(' ', (isset($aresult[1]) ? $aresult[1] : ""));
      $this->setVersion($aversion[0]);
      $this->setBrowser(self::BROWSER_LYNX);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Amaya or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Amaya otherwise false.
   */
  protected function checkBrowserAmaya() {
    if (stripos($this->httpAgent, 'amaya') !== FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'Amaya'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion($aversion[0]);
        $this->setBrowser(self::BROWSER_AMAYA);
        return TRUE;
      }
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Safari or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Safari otherwise false.
   */
  protected function checkBrowserSafari() {
    if (stripos($this->httpAgent, 'Safari') !== FALSE
      && stripos($this->httpAgent, 'iPhone') === FALSE
      && stripos($this->httpAgent, 'iPod') === FALSE) {
      $aresult = explode('/', stristr($this->httpAgent, 'Version'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion($aversion[0]);
      }
      else {
        $this->setVersion(self::VERSION_UNKNOWN);
      }
      $this->setBrowser(self::BROWSER_SAFARI);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Detect if URL is loaded from FacebookExternalHit.
   *
   * @return bool
   *   True if it detects FacebookExternalHit otherwise false.
   */
  protected function checkFacebookExternalHit() {
    if (stristr($this->httpAgent, 'FacebookExternalHit')) {
      $this->setRobot(TRUE);
      $this->setFacebook(TRUE);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Detect if URL is being loaded from internal Facebook browser.
   *
   * @return bool
   *   True if it detects internal Facebook browser otherwise false.
   */
  protected function checkForFacebookIos() {
    if (stristr($this->httpAgent, 'FBIOS')) {
      $this->setFacebook(TRUE);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Detect Version for the Safari browser on iOS devices.
   *
   * @return bool
   *   True if it detects the version correctly otherwise false.
   */
  protected function getSafariVersionOnIos() {
    $aresult = explode('/', stristr($this->httpAgent, 'Version'));
    if (isset($aresult[1])) {
      $aversion = explode(' ', $aresult[1]);
      $this->setVersion($aversion[0]);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Detect Version for the Chrome browser on iOS devices.
   *
   * @return bool
   *   True if it detects the version correctly otherwise false.
   */
  protected function getChromeVersionOnIos() {
    $aresult = explode('/', stristr($this->httpAgent, 'CriOS'));
    if (isset($aresult[1])) {
      $aversion = explode(' ', $aresult[1]);
      $this->setVersion($aversion[0]);
      $this->setBrowser(self::BROWSER_CHROME);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is iPhone or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is iPhone otherwise false.
   */
  protected function checkBrowseriPhone() {
    if (stripos($this->httpAgent, 'iPhone') !== FALSE) {
      $this->setVersion(self::VERSION_UNKNOWN);
      $this->setBrowser(self::BROWSER_IPHONE);
      $this->getSafariVersionOnIos();
      $this->getChromeVersionOnIos();
      $this->checkForFacebookIos();
      $this->setMobile(TRUE);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is iPad or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is iPad otherwise false.
   */
  protected function checkBrowseriPad() {
    if (stripos($this->httpAgent, 'iPad') !== FALSE) {
      $this->setVersion(self::VERSION_UNKNOWN);
      $this->setBrowser(self::BROWSER_IPAD);
      $this->getSafariVersionOnIos();
      $this->getChromeVersionOnIos();
      $this->checkForFacebookIos();
      $this->setTablet(TRUE);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is iPod or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is iPod otherwise false.
   */
  protected function checkBrowseriPod() {
    if (stripos($this->httpAgent, 'iPod') !== FALSE) {
      $this->setVersion(self::VERSION_UNKNOWN);
      $this->setBrowser(self::BROWSER_IPOD);
      $this->getSafariVersionOnIos();
      $this->getChromeVersionOnIos();
      $this->checkForFacebookIos();
      $this->setMobile(TRUE);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine if the browser is Android or not (last updated 1.7).
   *
   * @return bool
   *   True if the browser is Android otherwise false.
   */
  protected function checkBrowserAndroid() {
    if (stripos($this->httpAgent, 'Android') !== FALSE) {
      $aresult = explode(' ', stristr($this->httpAgent, 'Android'));
      if (isset($aresult[1])) {
        $aversion = explode(' ', $aresult[1]);
        $this->setVersion($aversion[0]);
      }
      else {
        $this->setVersion(self::VERSION_UNKNOWN);
      }
      if (stripos($this->httpAgent, 'Mobile') !== FALSE) {
        $this->setMobile(TRUE);
      }
      else {
        $this->setTablet(TRUE);
      }
      $this->setBrowser(self::BROWSER_ANDROID);
      return TRUE;
    }
    return FALSE;
  }
  /**
   * Determine the user's platform (last updated 1.7).
   */
  protected function checkPlatform() {
    if (stripos($this->httpAgent, 'windows') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_WINDOWS;
    }
    elseif (stripos($this->httpAgent, 'iPad') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_IPAD;
    }
    elseif (stripos($this->httpAgent, 'iPod') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_IPOD;
    }
    elseif (stripos($this->httpAgent, 'iPhone') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_IPHONE;
    }
    elseif (stripos($this->httpAgent, 'mac') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_APPLE;
    }
    elseif (stripos($this->httpAgent, 'android') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_ANDROID;
    }
    elseif (stripos($this->httpAgent, 'linux') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_LINUX;
    }
    elseif (stripos($this->httpAgent, 'Nokia') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_NOKIA;
    }
    elseif (stripos($this->httpAgent, 'BlackBerry') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_BLACKBERRY;
    }
    elseif (stripos($this->httpAgent, 'FreeBSD') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_FREEBSD;
    }
    elseif (stripos($this->httpAgent, 'OpenBSD') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_OPENBSD;
    }
    elseif (stripos($this->httpAgent, 'NetBSD') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_NETBSD;
    }
    elseif (stripos($this->httpAgent, 'OpenSolaris') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_OPENSOLARIS;
    }
    elseif (stripos($this->httpAgent, 'SunOS') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_SUNOS;
    }
    elseif (stripos($this->httpAgent, 'OS\/2') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_OS2;
    }
    elseif (stripos($this->httpAgent, 'BeOS') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_BEOS;
    }
    elseif (stripos($this->httpAgent, 'win') !== FALSE) {
      $this->browserPlatform = self::PLATFORM_WINDOWS;
    }
  }

}
