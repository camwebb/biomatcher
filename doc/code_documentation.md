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

#### function - create_mail

create mail function.

return mail template code html/text

access private

#### function - do_pass

change user data function.
This function will change name, username, and email of a user trought post method.

access public

#### function - do_profile

change password function.
This function will change password of a user trought post method.

access public

### Controller - user

#### function - do_login

check validity of user data and set user session if data valid

access public

#### function - do_register

insert user data function

access public

#### function - do_reset_password

reset password function.
This function will check validity of the link and user data, and change user password if data provided is valid.

access public

#### function - do_verify

verify user function

access public

#### function - email_exists

check email existance function

return boolean TRUE/FALSE
access private

#### function - email_not_exists

check email existance function

return boolean TRUE/FALSE
access private

#### function - forgot_password

display forgot password page

access public

#### function - get_sha256

Generate sha256 hash for given data.

parameter mixed $to_hash. Can be string or array of data.
parameter string $mode Hash key mode, accepted values are session, password and cookie.
return string 64 characters hash of has_key concat with the given data

access protected

#### function - logout

delete user session

access public

#### function - register

display register page

access public

#### function - register_success

display register success page.

access public

#### function - reset_password

display reset password page.

access public

#### function - sendEmail

send email function

parameter string $subject for email subject
parameter string $email recipent email

return boolean TRUE if success
access private

#### function - send_reset_link

send password reset link password by email.

acccess public

#### function - template

display page.

parameter string $page. Filename of a page
parameter array $data. Data to be accessed in view page

access private

#### function - userlog

auto login using browser cookies.
This function is not used.

access public

#### function - username_exists

check username availability.

return boolean TRUE/FALSE
access private

## Model

### Model - m_admin

#### function - check_password

check password match in database

parameter integer $id_user. id of user
parameter string $key. Encrypted password
return boolean TRUE/FALSE. Return TRUE if password match and return FALSE if password does not match.

#### function - check_username

check username exist in database

parameter integer $id_user. id of user
parameter string $key. username of user
return boolean TRUE/FALSE. Return TRUE if username does not exist and return FALSE if username exist.

#### function - download_statistic

get matches data of a project and convert it to csv file

parameter $project_id. id of a project
parameter $same. attribute of match (same/different)
parameter $percent. yes/no. determined wether return percentage of matches data or not
return file download

#### function - get_csv

get list images by project id

array $result. List images's data

#### function - get_name_image

get original name of an image by image id

parameter $id. id of an image
return array original name of an image

#### function - image_data

get image's data with it's project's data by image id in QCSet project

parameter integer $imageID. image id
return array $result. image's data

#### function - isQC

check a project type is Quality Control Set or not

parameter integer $projectID. id of a project
return boolean TRUE/FALSE. Return TRUE if a project is a Quality Control Set, and return FALSE if a project is not a Quality Control Set.

#### function - list_image

get image per page by project id

parameter integer $perPage. Number of images's data to return per page
parameter integer $uri. Start index of images's data to return
return array $result. List images's data

#### function - list_project

get project per page

parameter integer $perPage. Number of project's data to return per page
parameter integer $uri. Start index of project's data to return
return array $result. List project's data

#### function - list_user

get user per page

parameter integer $perPage. Number of users's data to return per page
parameter integer $uri. Start index of users's data to return
return array $result. List users's data

#### function - list_website

get site per page with it's owner's data

parameter integer $perPage. Number of sites's data to return per page
parameter integer $uri. Start index of sites's data to return
return array $result. List sites's data

#### function - login_admin

login function for admin user

parameter string $username. Username used for login
return array userdata

#### function - matches_data

get a matches data by site id

parameter integer $siteID. site id
return array $result. Matches's data

#### function - match_images

get matches data by project id

parameter $projectID. id of a project
return array matches data

#### function - profile_admin

update admin userdata

parameter integer $id_user. id of user
parameter string $name. name of user
parameter string $username. username of user
parameter string $email. user's email
return json array(). success message

#### function - project_consumer

get list sites of a user with type consumer

parameter integer $user_id. id of user
return array $result. List sites data

#### function - project_data

get a project's data by project id

parameter integer $project_id. id of s project
return array $result. Project's data

#### function - project_supplier

get list projects of a user with type supplier

parameter integer $user_id. id of user
return array $result. List projects data

#### function - same

count matches data with same/different attribute

parameter $imageA. image id
parameter $imageB. image id
parameter $same. attribute of match (same/different)

return integer sum of matches data

#### function - total_matches

count total matches data of an image

parameter $imageA. image id

return integer sum of matches data

#### function - user_data

get a user's data by project id

parameter integer $user_id. id of a user
return array $result. User's data

#### function - user_type

check user type by user id

parameter integer $id_user. id of user
return string user type

### Model - m_general
### Model - m_pages
