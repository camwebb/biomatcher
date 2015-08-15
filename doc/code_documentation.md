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

display view and it's data.

- view project - display images and it's labels from a project by project id with 10 images limit per page
- view projects - display all projects created with 10 projects limit per page
- view setting - display user data and change password form
- view statistic - display match statistic of a project by project id
- view users - display all users registered with 10 users limit per page
- view user_projects - display all projects from a spesific user by user id
- view websites - display all websites registered with 10 websites limit per page

param string page = name of html file to be load
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

#### function - index

display download page for captcha resource

access public

### Controller - pages

#### function - index

display home page

access public

#### function - add_site

add site function

access public

#### function - do_addProject

add project function

access public

#### function - do_deleteWebsite

delete website function

access public

#### function - do_editAllLabel

edit multiple image label function with csv style

access public

#### function - do_editLabel

edit one image label function

access public

#### function - do_renameProject

rename project function

access public

#### function - do_renameWebsite

rename website function

access public

#### function - download_stats

generate csv file for same or different statistic of a project

access public

#### function - find_IDLabel

find image id from a label

access public

#### function - get_token

get site token by site id from GET method

return string token = site token
access public

#### function - insert_match

insert match image function 

access public

#### function - insert_match_byToken

insert match wiht token. used from another site

access public

#### function - install_auth

install site authentication database

access public

#### function - microtime_float

get current microtime

access public

#### function - project_exists

check project name availability

return bolean TRUE/FALSE
access public

#### function - selectRandom

get 2 random images from a project

return array image data
access public

#### function - site_exists

check existance of a site

return bolean TRUE/FALSE
access public

#### function - upload_file

upload function for zip file images, convert each image with 3 different size (100px, 400px, 1000px)

see image_lib library
access public

#### function - view

display view and it's data.

- view get_code - display page contain code and instruction to use biomatcher captcha
- view home - display home page (welcome page)
- view match - display matching page for user to match images on server
- view project - display images and it's labels from a project by project id with 10 images limit per page
- view projects - display all projects (per user) created with 10 projects limit per page
- view statistic - display match statistic of a project by project id
- view my_website - display all websites registered (per user) with 10 websites limit per page

param string page = name of html file to be load
access public

### Controller - project

#### function - deleteImage

delete image function.
This function will delete image files and data, and send warning to user if image has been match.

access public

#### function - delete_project

delete project function.
This function will delete project data and images, and send warning to user if the project is not empty or it's images has been matched.

access public

#### function - delImgCascade

delete image function.
This function will delete image file and data without checking match data.

access public

#### function - del_pr_cascade

delete project function.
This function will delete project data and images without checking if the project is not empty or it's images has been matched.

access public

### Controller - setting

#### function - index

display setting page

access public

#### function - check_pass

match password function.

return boolean TRUE/FALSE
access public

#### function - check_username

check username availability.

return boolean TRUE/FALSE
access public

#### function - do_pass

change user data function.
This function will change name, username, and email of a user trought post method.

access public

#### function - do_profile

change password function.
This function will change password of a user trought post method.

access public

### Controller - user

## Model

### Model - m_admin
### Model - m_general
### Model - m_pages
