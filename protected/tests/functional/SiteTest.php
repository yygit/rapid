<?php

class SiteTest extends WebTestCase{
    public function testIndex() {
        $this->open('');
        $this->assertTitle("regexpi:.*rapid.*");
        $this->assertTextPresent('Welcome');
        $this->assertTextPresent("regexpi:welcome.*");
        $this->assertText("css=h1", "regexpi:welcome.*");
        $this->assertText("//div[@id='content']/h1", "regexpi:welcome.*");
    }

    public function testContact() {
//        $this->open('?r=site/contact');
        $this->open('/rapid/site/contact');
        $this->assertTextPresent('Contact Us');
        $this->assertTextPresent('regexpi:Contact Us');
        $this->assertText("//div[@id='content']/h1", "regexpi:contact us.*");
        $this->assertTitle("regexpi:.*contact us.*");
        $this->assertElementPresent('name=ContactForm[name]');

        $this->type('name=ContactForm[name]', 'tester');
        $this->type('name=ContactForm[email]', 'tester@example.com');
        $this->type('name=ContactForm[subject]', 'test subject');
        $this->click("//input[@value='Submit']");
        $this->waitForTextPresent('Body cannot be blank.');
    }

    public function testLoginLogout() {
        $this->open('');
        // ensure the user is logged out
        if ($this->isElementPresent("//a[contains(@href, '/rapid/site/logout')]")) {
            $this->assertElementPresent("//a[contains(@href, '/rapid/site/logout')]");
            $this->clickAndWait("//a[contains(@href, '/rapid/site/logout')]");
        }

        // ensure user management page is not accessible (when logged out)
        $this->open('/rapid/user');
        $this->assertElementNotPresent("//a[contains(@href, '/rapid/user')]");
        $this->assertElementNotPresent("//div[@id='user-grid']/table//a[1]/img[contains(@src, 'assets')]");
        $this->assertElementNotPresent("//div[@id='user-grid']/table//a[2]/img[contains(@src, 'assets')]");
        $this->assertElementNotPresent("//div[@id='user-grid']/table//a[3]/img[contains(@src, 'assets')]");
        $this->assertElementPresent("//form[@id='login-form']//input[@type='submit']");

        // test login process, including validation
        $this->assertElementPresent("//a[contains(@href, '/rapid/site/login')]");
        $this->clickAndWait("//a[contains(@href, '/rapid/site/login')]");
        $this->assertElementPresent('name=LoginForm[username]');
        $this->type('name=LoginForm[username]', 'demo');
        $this->click("//form[@id='login-form']//input[@type='submit']");
        $this->waitForTextPresent('Password cannot be blank.');
        $this->type('name=LoginForm[password]', 'demo');
        $this->clickAndWait("//form[@id='login-form']//input[@type='submit']");
        $this->assertTextNotPresent('Password cannot be blank.');
        $this->assertTextPresent('regexpi:logout');
        $this->assertElementPresent("//a[contains(@href, '/rapid/site/logout')]");

        // test logout process
        $this->assertTextNotPresent('regexpi:login'); // YY; 20140116 text assertions will work for EN localization only
        $this->assertElementNotPresent("//a[contains(@href, '/rapid/site/login')]");
        $this->clickAndWait("//a[contains(@href, '/rapid/site/logout')]");
        $this->assertTextPresent('regexpi:login');
        $this->assertElementPresent("//a[contains(@href, '/rapid/site/login')]");
    }

    public function testJobSchedulesPage() {
        $this->open('');

        /*ensure the user is logged in*/
        if ($this->isElementPresent("//a[contains(@href, '/rapid/site/login')]")) {
            $this->assertElementPresent("//a[contains(@href, '/rapid/site/login')]");
            $this->clickAndWait("//a[contains(@href, '/rapid/site/login')]");
            $this->assertElementPresent('name=LoginForm[username]');
            $this->type('name=LoginForm[username]', 'admin');
            $this->type('name=LoginForm[password]', 'admin');
            $this->clickAndWait("//form[@id='login-form']//input[@type='submit']");
            $this->assertElementPresent("//a[contains(@href, '/rapid/site/logout')]");
        }

        $this->open('/rapid/jobQueue/jobScheduled/index');
        /*ensure the page title is proper*/
        $this->assertTitle("regexpi:.*schedule.*");
        /*ensure the page header h1 is proper*/
        $this->assertText("//div[@id='content']/h1", "regexpi:.*schedule.*");

        /*test filter for id=1*/
        $this->assertElementPresent("//div[@id='job-scheduled-grid']//input[@name='JobScheduled[id]']");
        $this->type("//div[@id='job-scheduled-grid']//input[@name='JobScheduled[id]']", '1');
        $this->keyDown("//div[@id='job-scheduled-grid']//input[@name='JobScheduled[id]']", '\13');
        $this->pause(2000);
        $this->assertElementPresent("//div[@id='job-scheduled-grid']/table/tbody/tr[1]/td[1]");
        $this->assertText("//div[@id='job-scheduled-grid']/table/tbody/tr[1]/td[1]", 'regexpi:.*1.*');
        $this->assertNotText("//div[@id='job-scheduled-grid']/table/tbody/tr[1]/td[1]", 'regexpi:.*2.*');
    }
}
