# Larmo

[![Build Status](https://travis-ci.org/adrianpietka/larmo.svg?branch=master)](https://travis-ci.org/adrianpietka/larmo)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/adrianpietka/larmo/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/adrianpietka/larmo/?branch=master)
[![Code Climate](https://codeclimate.com/github/adrianpietka/larmo/badges/gpa.svg)](https://codeclimate.com/github/adrianpietka/larmo)
[![Test Coverage](https://codeclimate.com/github/adrianpietka/larmo/badges/coverage.svg)](https://codeclimate.com/github/adrianpietka/larmo/coverage)

## What is it?
This project is a PoC of a central hub that stores information from many data feeds - control version systems, Skype, IRC, etc. - in order to have a clear project history with ability to search and analyse and sending out aggregated information to different media: email, IRC, Skype, etc.

## Is it really working?
Yes, you can check the webapp under http://larmo.herokuapp.com/ - it's currently connected to our Github repo.

## Directory structure

* [agents/](https://github.com/adrianpietka/larmo/tree/master/agents) - small independent applications that collect messages, normalize them and send it to the Larmo Hub,
* [hub/](https://github.com/adrianpietka/larmo/tree/master/hub) - central point to receive and storage messages,
* [webapp/](https://github.com/adrianpietka/larmo/tree/master/webapp) - web application for presenting stored messages.
