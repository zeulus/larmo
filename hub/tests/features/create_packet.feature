Feature:
  In order to process incoming messages
  As a system
  I need to verify it's structure, source and auth info

  Background:
    Given I have received string:
    """
    {
     "head": {
      "source" : "skype",
      "auth"   : "xxx",
      "time"   : 1434723490
     },
     "messages": [
      {
       "type"   : "skype.message.new",
       "time"   : 1434723489,
       "author" : {
                    "email": "someone@somewhere.tld"
                  },
       "body"   : "Hej łobuzie!",
       "extra"  : {
                    "ident": "something that would get decoded by skype plugin"
                  }
      }
     ]
    }
    """
    And it is valid JSON string
    And can be decoded to array


  Scenario: Verify sender auth info
    Given a packet metadata created from decoded string
    When auth info fails to validate
    Then I drop that packet

  Scenario: Verify packet can be handled by system
    Given a plugin identifier provided by "source" metadata field
    When that plugin is not registered in system
    Then I drop the packet


