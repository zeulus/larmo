Feature: Create a Domain Packet Aggregate with data from an Agent Packet
  As a System
  In order to be able to create a Domain Packet Aggregate
  I need to verify an Agent Packet's structure, source and auth info

  Scenario: An Agent Packet with invalid authorization key is rejected by the Packet Validation Service
    Given An Agent Packet with the following wrong "metadata" fields:
      | auth | invalidAuthKey |
    When The Agent Packet is validated
    Then It should have been rejected by the Packet Validation Service
     And The rejection reason must be "the authinfo is invalid"

  Scenario: An Agent Packet with invalid source is rejected by the Packet Validation Service
    Given An Agent Packet with the following wrong "metadata" fields:
      | source | invalidSource |
    When The Agent Packet is validated
    Then It should have been rejected by the Packet Validation Service
     And The rejection reason must be "the source is invalid"

  Scenario: A malformed Agent Packet is rejected by the packet validation service
    Given A malformed Agent Packet
    When The Agent Packet is validated
    Then It should have been rejected by the Packet Validation Service
     And The rejection reason must be "the packet is empty or has invalid JSON structure"

  Scenario: A Domain Packet Aggregate is created with the Agent Packet data
    Given A valid Agent Packet
    When The Agent Packet is validated
    Then It should have been accepted by the Packet Validation Service
     And The Agent Packet is decoded into an array
     And The Domain Packet Aggregate is created