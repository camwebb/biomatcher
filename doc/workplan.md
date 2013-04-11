# Workplan for development

## Phase 1. Setup and simple intro

 1. Create a simple home page @ http://biomatcher.org which is also an
    alias of http://biomatcher.org/index.php, 
    http://biomatcher.org/pages/view, and
    http://biomatcher.org/pages/view/home
 2. Create a login and register link on the homepage
 3. Allow the user to register a username and password, saving to the
    `users` table in the biomatcher database
 4. Allow the user to log in, saving a cookie to the browser
 5. If the user is logged in, show the username, rather than
 `login/register`

## Phase 2. Allow upload and deletion of image sets

 1. After user login, link to form allowing creation of a **project** 
 2. On the project creation page, ask for name of project, and save
    name in `project.name` in DB, and save the `userID` 
 3. On main page (after login), show a link to all existing projects
 4. Project link leads to project page
 5. Project page shows a ‘message `<DIV/>` at top, including a file
    upload button, and then a **table** of all images so far in the
    project, with a 100x100px thumbnail, and a checkbox on the right
 6. On file upload:
    * check MIME type for zip (`application/zip`, `application/x-zip`,
      `application/x-zip-compressed`)
    * accept maximum **50 Mb**
    * create temp directory on filesystem under `tmp/` - use the `md5sum`
      hash of the file as the directory name, and store the zip file
      in this directory
    * unzip all files from the **root directory** of the zip archive
      into the `tmp/<md5sumhash>/` directory
    * Check the filetype of each file using the PHP equivalent of unix
      `file`
    * For all files that are type `JPEG image data`, use the PHP
      eqivalent of **ImageMagick** to convert them to a jpeg file with
      maximum dimensions 500x500 px,  
      named `<md5sum>.jpg` where `<md5sum>` is the md5sum hash of the
      original file.
    * Save each of these files in a directory:
      `data/<username>/<projectID>/img/` where project ID is
      `project.id` from DB.
    * Save the image data in DB under `images`: `projectID`, `nameOri` =
      original file name in zip file, `md5sum` = hash
    * Delete `tmp/<md5sumhash>/` directory
 7. After upload return to project page, reporting errors or success in
    the message <DIV/> and the table of uploaded images.
 8. At bottom of page, there is a button “Delete selected images” -
    this will remove selected images from the database and fromthe
    filesystem.
