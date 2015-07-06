Feature: Handle a well formed packet coming from an agent
  Background:
    Given A well formed packet coming from an agent

  Scenario: Plugin service successes to validate
    When The packet is prepared to be verified against a schema
    Then The plugin service successes to validate

  Scenario: A packet can be created by the system
    When I decode a packet coming from an agent into an array
    Then The system can create a packet in the domain
