Feature: Handle a wrong formed packed

  Scenario: Auth info fails to validate because authorization info
    Given A packet coming from an agent with the following "metadata" wrong:
      | auth | invalidAuthKey |
    When The packet is prepared to be verified against a schema
    Then The plugin service fails to validate
     And The packet is rejected with reason "the authinfo is invalid"

  Scenario: Incoming packet cannot be handled by the system because invalid source
    Given A packet coming from an agent with the following "metadata" wrong:
      | source | nonRegisteredPlugin |
    When The packet is prepared to be verified against a schema
    Then The plugin service fails to validate
     And The packet is rejected with reason "the source is invalid"

  Scenario: Incoming packet has an invalid JSON structure
    Given A packet coming from an agent with invalid structure
     When The packet is prepared to be verified against a schema
     Then The plugin service fails to validate
      And The packet is rejected with reason "the packet is empty or has invalid JSON structure"