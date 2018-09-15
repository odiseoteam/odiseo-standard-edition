@login
Feature: Login
  In order to sign in on the site
  User should be able to login

  Background:
    Given there are following users:
      | username        | password  |
      | test@test.com   | 123456    |

  # Login
  Scenario: A user can signin to the site using their credentials
    Given I am on "/login"
    When I fill in the following:
      | _username | test@test.com |
      | _password | 123456 |
    And I press "Signin"
    Then I should see the "test@test.com" email on homepage