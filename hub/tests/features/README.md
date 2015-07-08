# Behat cheatsheet for Larmo tests

## Agent Packet Context

###### @beforeScenario

A new *Agent Packet Fixture Provider* instance is created.

#### Well formed packet
```
@Given /^A well formed packet coming from an agent$/
```

Builds a well formed agent packet fixture.

#### Wrong formed packet
```
@Given /^A packet coming from an agent with the following "([^"]*)" wrong:$/
```

Builds a wrong formed agent packet with option to specify a `key` where wrong fields will be applied. A `TableNode` object is used to apply the desired wrong fields.

```
    Given A packet coming from an agent with the following "metadata" wrong:
      | auth | invalidAuthKey |
```

If you want to apply multiple wrong fields:

```
    Given A packet coming from an agent with the following "metadata" wrong:
      | auth | invalidAuthKey |
      | source | nonValidSource |
      | anotherField | anotherWrongField |
```

If the desired field we want to modify does not exist, this will not modify anything.

## Domain Packet Context

#### Decoding a packet coming from an agent

```
@When /^I decode a packet coming from an agent into an array$/
```

Note that this step **requires** a previously well formed packet. Otherwise the step will be marked as failed.

#### Create a domain packet

```
@Then /^The system can create a packet in the domain$/
```

It creates a Domain Packet with using data provided from an Agent Fixture Provider

Note that this step **requires** a previously well formed packet. Otherwise the step will be marked as failed.

## Plugin Service Context

###### @beforeScenario

A new *Packet Validation Service* instance is created.

#### Prepare a packet to be verified against a schema

```
@When /^The packet is prepared to be verified against a schema$/
```

It prepares the agent packet and the validation schema.

Note that this step **requires** a previously well||wrong formed packet. Otherwise the step will be marked as failed.

#### Plugin service validation successes

```
@Then /^The plugin service success to validate$/
```

Checks if the plugin service validation has been completed successfully

#### Plugin service validation fails

```
@Then /^The plugin service fails to validate$/
```

Checks if the plugin service validation has been failed

#### Packet is rejected with a particular reason

```
@Given /^The packet is rejected with reason "([^"]*)"$/
```

Checks the failed validation reasons from Plugin Validation Services.

If an expected reason is not found, this step will be marked as failed.