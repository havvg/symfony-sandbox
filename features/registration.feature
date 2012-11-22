Feature: Multi-Step Registration
    In order to become a registered user
    As an anonymous user
    I need to be able to register a new user account

    Scenario: The registration can be started.
        Given I am on "/register"
         Then the response status code should be 200
          And I should see a "form" element
          And the response should contain "Your billing address"

    Scenario: Submitting an invalid billing address shows form errors.
        Given I am on "/register"
         When I fill in the following:
             | Street  |   |
             | Zipcode |   |
             | City    |   |
          And I press "Next"
         Then the response should contain "Your billing address"

    Scenario: Submitting valid data continues to next step.
        Given I am on "/register"
         When I fill in the following:
             | Street  | Subbelrather Str. 142  |
             | Zipcode | 50823                  |
             | City    | Köln                   |
          And I press "Next"
         Then the response should contain "Your account information"
          And I should see 1 "input[type=email]" element
          And I should see 2 "input[type=password]" elements
