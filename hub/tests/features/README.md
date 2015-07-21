# Behat cheatsheet for Larmo tests

## Agent Packet Context

###### @beforeScenario

A new *Agent Packet Fixture Provider* instance is created.

#### A valid Agent Packet

```
@Given /^A valid Agent Packet$/
```

Builds a valid Agent Packet.

#### A malformed Agent Packet

```
@Given /^A malformed Agent Packet$/
```

Builds a malformed Agent Packet.

#### An Agent Packet with specific wrong fields
```
@Given /^An Agent Packet with the following wrong "([^"]*)" fields:$/
```

Builds a wrong formed agent packet with option to specify a `key` where wrong fields will be applied. A `TableNode` object is used to apply the desired wrong fields.

```
    Given An Agent Packet with the following wrong "metadata" fields:
      | key | value |
```

If you want to apply multiple wrong fields:

```
    Given An Agent Packet with the following wrong "metadata" fields:
      | auth | invalidAuthKey |
      | source | invalidSource |
```

If the desired `key` we want to modify does not exist, this will not modify anything.

## Domain Packet Context

#### Decode an Agent Packet into an array 

```
@Then /^The Agent Packet is decoded into an array$/
```

Note that this step **requires** a valid Agent Packet. Otherwise the step will be marked as failed.

#### Create a domain packet aggregate

```
@Then /^The Domain Packet Aggregate is created$/
```

It creates a Domain Packet Aggregate with using data provided from an Agent Fixture Provider

Note that this step **requires** a valid Agent Packet. Otherwise the step will be marked as failed.

## Packet Validation Service Context

###### @beforeScenario

A new *Packet Validation Service* instance is created.

#### Validate an Agent Packet

```
@When /^The Agent Packet is validated$/
```

It validates the Agent Packet

Note that this step **requires** an Agent Packet. Otherwise the step will be marked as failed.

#### Agent Packet has been accepted by the Packet Validation Service

```
@Then /^It should have been accepted by the Packet Validation Service$/
```

Checks if the Agent Packet is valid.

#### Agent Packet has been rejected by the Packet Validation Service

```
@Then /^It should have been rejected by the Packet Validation Service$/
```

Checks if the Agent Packet is invalid.

#### Check the reason why the packet was rejected by Packet Validation Service

```
@Then /^The rejection reason must be "([^"]*)"$/
```

Checks the failed validation reason given by the Packet Validation Service.

If an expected reason is not found, this step will be marked as failed.