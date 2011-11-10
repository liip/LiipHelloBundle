<?php

namespace Liip\HelloBundle\Features\Context;

use Behat\BehatBundle\Context\MinkContext,
    Behat\Mink\Exception\ElementNotFoundException;

/**
 * Feature context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @When /^I click on "([^"]*)"$/
     */
    public function iClickOn($argument1)
    {
       $this->clickById($argument1);
    }

    public function clickById($locator)
    {
        $page = $this->getSession()->getPage();

        $link = $page->findById($locator);

        if (null === $link) {
            throw new ElementNotFoundException(
                $this->getSession(), 'id', 'id', $locator
            );
        }

        $link->click();
    }

    /**
     * @Then /^I wait for "([^"]*)" element to appear$/
     */
    public function iWaitForElementToAppear($argument1)
    {
        $this->getSession()->wait(2000, "document.getElementById('$argument1')");
    }
}
