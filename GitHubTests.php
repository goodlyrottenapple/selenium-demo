<?php
// https://codeception.com/11-12-2013/working-with-phpunit-and-selenium-webdriver.html
// https://github.com/php-webdriver/php-webdriver/blob/main/example.php
// https://github.com/SeleniumHQ/docker-selenium

namespace Facebook\WebDriver;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;


class GitHubTests extends TestCase {

  protected $webDriver;

	public function setUp(): void {
    $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', DesiredCapabilities::firefox());
  }

  public function tearDown(): void {
    $this->webDriver->quit();
  }

  protected $url = 'https://github.com';

  public function testGitHubHome() {
    $this->webDriver->get($this->url);

    // check that page title contains the word 'GitHub'
    $this->assertStringContainsString('GitHub', $this->webDriver->getTitle());
  }

  public function testSearch() {
    $this->webDriver->get($this->url);

    // find the search bar, enter the text 'goodlyrottenapple' and submit
    $search = $this->webDriver->findElement(WebDriverBy::className('header-search-input'));
    $search->sendKeys('goodlyrottenapple')->submit();

    // wait until the Users tab appears on the LHS of the website, then click it
    $this->webDriver->wait()->until(
      WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::partialLinkText('Users'))
    );
    $this->webDriver->findElement(WebDriverBy::partialLinkText('Users'))->click();

    // wait until a link with the text 'Samuel Balco' becomes visible, then click it
    $this->webDriver->wait()->until(
      WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::partialLinkText('Samuel Balco'))
    );
    $this->webDriver->findElement(WebDriverBy::partialLinkText('Samuel Balco'))->click();

    // find the followers count
    $this->webDriver->wait()->until(
      WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('a.no-wrap:nth-child(1) > span:nth-child(2)'))
    );
    $followers = $this->webDriver->findElement(WebDriverBy::cssSelector('a.no-wrap:nth-child(1) > span:nth-child(2)'))->getText();
    
    // must have more than 5 followers!!
    $this->assertGreaterThan(5, intval($followers));
	}
}