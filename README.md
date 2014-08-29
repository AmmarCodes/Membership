# Membership

Membership Management System using Laravel framework. for learning purposes.

## Introduction

- The system doesn't have a front-end, it's just a back-end.
- The system should allow adding/modifying members.
- Each member can be enrolled in a package or more.
- Each package has a monthly fees.
- Each member should pay fees.
- Administrator should be able to see which members doesn't pay the fees after their package recurring. 

## Dependencies

### PHP

- Confide

### HTML/CSS/JavaScript

- Gulp
- Bower
- Twitter Bootstrap

## Local Development Setup

- Clone the project & cd to its directory.
- Make sure you should have [Vagrant](http://vagrantup.com) installed, then run: `vagrant up`.
- ssh to vagrant machine, then run `cd /vagrant`
- Update project dependencies by running this inside vm machine: `composer update --dev`.

For HTML/CSS/JavaScript development either update `Vagrantfile` to include `Gulp`, `Bower`, `Sass` and run `vagrant provision` or install them directly on your host machine. I prefer installing them on the host machine.

## Configuration

## Deploy