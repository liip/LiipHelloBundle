Feature: Tree view page
    In order to navigate the content tree
    As a visitor
    I need to be able to click on a tree element and see its children

    Scenario: Successfully add a hello node
        Given I am on "/liip/phpcr/hello"
        Then I should see "hello"

    Scenario: Successfully add a world node
        Given I am on "/liip/phpcr/hello/world"
        Then I should see "hello/world"

    @javascript
    Scenario: Successfully navigate the content tree
        Given I am on "/liip/tree"
        When I click on "/hello"
        Then I wait for "/world" element to appear
        Then I should see "world"
