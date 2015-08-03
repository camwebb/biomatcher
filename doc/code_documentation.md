# Biomatcher Code Documentation
## Introduction

biomatcher.com applications created using CodeIgniter framework. This framework is used to simplify the creation of applications.

Basic settings such as installation, configuration database, and others can be seen in CodeIgniter documentation.

	http://ellislab.com/codeigniter/
	http://ellislab.com/codeigniter/user-guide/

While this document is to explain classes and functions are created by programmers, which are used in the application program.

## Configuration

All configuration off CodeIgniter framework is contained in the "config" folder of application. 

### Configuration - Basic

"config.php" file is the basic configuration of the application. This file contained basic configuration such as base url, session name, encryption key, and others.

### Configuration - Database

"database.php" file contained configuration for database use in the application such as hostname, database name, prefix, username, password, and others.

### Configuration - Email

"email.php" file contained configuration used to send email to a user when registering or reseting password.

## Controller

### Controller - admin

#### function - index
	
used to check session of a user
redirect user to project page if session valid
redirect user to login page if session invalid.
	
access public

#### function - check_pass

check validity password of a user, used username session.

access public

#### function - check_username

check username availability.

access public

#### function - download_stats

generate match statistic document of a project and send it to client

access public

#### function - do_login

check validity of user data and set user session if data valid

access public

#### function - logout

delete user session

access public

#### function - pass_admin

update password

access public

#### function - profile_admin

update admin profile

access public

#### function - QC_report

count success rate of quality control by site id

access private

#### function - view

used to display view and it's data.
- view projects - display all projects created with 10 projects limit per page
- view users - display all users registered with 10 users limit per page
- view websites - display all websites registered with 10 websites limit per page
- view user_projects - display all projects from a spesific user by user id
- view setting - display user data and change password form
- view project - display images and it's labels from a project by project id
- view statistic - display match statistic of a project by project id

access public

### Controller - captcha

#### function - _check_captcha

check validity of captcha

return boolean TRUE/FALSE
access private

#### function - frame

display captcha page

access public

#### function - securimage

generate image captcha

return captcha image
access public

#### function - securimage_audio

generate audio captcha

return audio file
access public

#### function - si_test

process captcha sent by user and chec it's validity

see _check_captcha
access public

### Controller - demo

#### function - index

display demo captcha page

access public

### Controller - download

display download page for captcha resource

access public

### Controller - pages
### Controller - project
### Controller - setting
### Controller - user

## Model

### Model - m_admin
### Model - m_general
### Model - m_pages
