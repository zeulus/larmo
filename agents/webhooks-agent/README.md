# Larmo WebHooks Agent
It is a WebHooks Agent for open source project *Larmo*.

## Supported services
- Github (events: push, commit comment)
- Bitbucket (events: push)

## To do
- Connect with *Larmo*
- Add more supported events from Github
- Add support to more services:
    - Jira
    - Gitlab
    - Trello
- Add more security

## Installation guide
Agent is simple PHP application ready to deploy for different servers like Heroku.

1. Deploy this Agent to your server
2. Get address of your Agent and set in your repository webhook address. (Go to Github > Your repository > Settings > Webhooks & Services > Add webhook > Type URL of agent and save).
