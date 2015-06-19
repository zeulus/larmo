# Larmo Github Agent
It is a basic Github Agent for open source project *Larmo*. Agent is compatible with *Github Webhooks*.

At the moment is supported only *PUSH* event from Github, and output data saves to file.

## To do
- Connect with *Larmo*
- Add more supported events from Github
- Add support to Github API (?)
- Add security

## Installation guide
Agent is simple PHP application ready to deploy for different servers (like Heroku).

1. Deploy this Agent to your server
2. Get address of your Agent and set in your repository webhook address. (Go to Github > Your repository > Settings > Webhooks & Services > Add webhook > Type URL of agent and save).
