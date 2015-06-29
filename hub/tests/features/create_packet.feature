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
      },
      {
       "type"   : "skype.message.new",
       "time"   : 1434724489,
       "author" : {
                    "email": "someoneelse@somewhereelse.tld"
                  },
       "body"   : "sup!",
       "extra"  : {
                    "ident": "something that would get decoded by skype plugin"
                  }
      }
     ]
    }
    """
    And it can be decoded to an array
    And I create a packet

  Scenario: Verify sender auth info
    When auth info fails to validate
    Then I drop the packet

  Scenario: Verify packet can be handled by system
    Given a plugin identifier provided by metadata source field
    When that plugin is not registered in system
    Then I drop the packet