<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\TestCase as BaseTestCase;

/**
 * Defines how to open up a new browser window for testing purposes.
 */
abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Do the setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('bootstrap:application');
    }

    /**
     * Prepare for Dusk test execution.
     *
     * Warning! Do not remove the annotation below. This is used by Selenium.
     *
     * @beforeClass
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions())->addArguments([
            '--disable-gpu',
            '--no-sandbox',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }
}
