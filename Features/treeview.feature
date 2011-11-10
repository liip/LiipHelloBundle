Feature: Tree view page
    In order to navigate the content tree
    As a visitor
    I need to be able to click on a tree element and see its children

    @javascript
    Scenario: Successfully navigate the content tree
        Given I am on "/liip/tree"
        When I click on "/hello"
        Then I wait for "/world" element to appear
        Then I should see "world"
