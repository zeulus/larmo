# Larmo WebHooks Agent
It is a WebHooks Agent for open source project *Larmo*.

## Supported services
- [Github](#github) (events: push, commit comment, issues, issue comment, pull request)
- [Bitbucket](#bitbucket) (events: push, issues, issue comment)
- [Gitlab](#gitlab) (event: push)
- [Travis CI](#travis-c)
- [Scrutinizer CI](#scrutinizer-ci) (event: completed)

## To do
- Add support to more services:
    - Jira
    - Trello

## Installation guide
Agent is simple PHP application ready to deploy for different servers.

### Deploying
#### Use case: Deploying to Heroku 
*The best way with usage Heroku Toolbelt https://toolbelt.heroku.com/*

1. Create empty git repository in this directory (if isn't exists), type in console `git init`
2. Create heroku app, run command in console `heroku apps:create`
3. Install composer dependencies, type in console `composer install`
4. Commit all files, use command: `git commit -am "Save files for deploy"`
5. Deploy to heroku, run command: `git push heroku master`

After deploying process you can check that your site is running thanks command `heroku open`.

### Activate WebHooks in supported services
#### GitHub
1. Copy your deployed site URL.
2. Go to Github, and select your repository. Go to Settings > Webhooks & Services > Add webhook (https://github.com/USER-NAME/REPO-NAME/settings/hooks/new)
3. In field *Payload URL* put your site URL and add to end of URL */github*, example full URL: *http://still-reef-8508.herokuapp.com/github*
4. Select individual events, but check which events are [supported](#supported-services) in agent.
5. Click 'Add webhook' button.

#### Bitbucket
1. Copy your deployed site URL.
2. Go to Bitbucket, and select your repository. Go to Settings > Integrations > Webhooks > 
Add webhook (https://bitbucket.org/USER-NAME/REPO-NAME/admin/addon/admin/bitbucket-webhooks/bb-webhooks-repo-admin)
3. In field *URL* put your site URL and add to end of URL */bitbucket*, example full URL: *http://still-reef-8508.herokuapp.com/bitbucket*
4. Choose from a full list of triggers, but check which events are [supported](#supported-services) in agent.
5. Click 'Save' button.

#### Gitlab
1. Copy your deployed site URL.
2. Go to your Gitlab page, and select repository. Go to Settings > Web Hooks (https://your-gitlab-site/USER-NAME/REPO-NAME/hooks)
3. In field *URL* put your site URL and add to end of URL */gitlab*, example full URL: *http://still-reef-8508.herokuapp.com/gitlab*
4. Choose from list of triggers, but check which events are [supported](#supported-services) in agent.
5. Click 'Add Web Hook' button.

#### Travis CI
1. Copy your deployed site URL.
2. Open .travis file in your project, and add webhooks notifications, for example:
```
 notifications:
   webhooks: http://your-deployed-site.herokuapp.com/travis
```
3. Save file, commit and push changes to your repository.

#### Scrutinizer CI
1. Copy your deployed agent URL.
2. Go to settings your repository on Scrutinizer and find 'Service Hooks' (example url: https://scrutinizer-ci.com/g/USER/REPO-NAME/settings/service-hooks).
3. Click 'Add web-hook' button and paste agent URL. Save settings.