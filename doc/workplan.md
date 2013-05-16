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
      eqivalent of **ImageMagick** to convert them to: 1) a jpeg file
      with maximum dimensions 500x500 px, named `<md5sum>.500px.jpg`,
      2) a
      jpeg file with maximum dimensions 100x100 px, named
      `<md5sum>.100px.jpg`,
      and 3) a jpeg file, with same dimensions as the original,
      named `<md5sum>.ori.jpg` (where `<md5sum>` is the
      md5sum hash of the original file).
    * Save each of these files in a directory:
      `data/<username>/<projectID>/img/` where project ID is
      `project.id` from DB.
    * Save the image data in DB under `images`: `projectID`, `nameOri` =
      original file name in zip file, `md5sum` = hash
    * Delete `tmp/<md5sumhash>/` directory
 7. After upload return to project page, reporting errors or success in
    the message <DIV/> and the table of uploaded images.
 8. At bottom of page, there is a button “Delete selected images” -
    this will remove selected images from the database and from the
    filesystem.

## Phase 3: Add labels

 1. If the `Add labels` button is clicked, a textbox appears
    (Javascript)
 2. A two-column, comma-delimited list is pasted in: Filename (exact),
    Label string
 3. On submit, this list is parsed and if the Filename matches
    `image.nameOri`, the label is written into `image.label`
    (overwriting existing entries)
 4. Alternatively, the edit button next to an image in the table can
    be selected and `[Edit]` pressed, and the Label name cell in the
    table is replaced by a text input, prefilled with the label
    contents. A `[Save]` button allows the data to be saved.

## Phase 4. Matching

Choose matches from random projects.

## Phase 5. Statistics

## Phase 6. Quality control

Maintain several sets of images that have been pre-matched.  As the
matcher looks at images, every ca. 15 matches (randomize), insert a
pre-known set (match or not at ca. 50% frequency) and record the
result. The payment rate to the matcher is dependent on the % of known
matches that they correctly record.  This will prevent the matcher
simply clicking randomly without actually assessing the image. It is
important there are no indications that the known pairs are actually
QC pairs, or else the user can learn to cheat.

## Phase 7. External JavaScript popup, with Captcha

----

## GUI Design

 * (Convention: `[xxxx]` is a input element)

### Frontpage

      +-------------------------------+
      | Biomatcher         [Log in]   |
      |                               |
      | texttexttexttext              |
      | texttexttexttext              |
      | texttexttexttext              |
      |                               |
      +-------------------------------+
      
### Register

      +-------------------------------+
      | Biomatcher : Register         |
      |                               |
      | data1: _________              |
      | data2: _________              |
      | data3: _________   [Submit]   |
      |                               |
      +-------------------------------+

### Frontpage after login

      +-------------------------------+
      | Biomatcher            <user>  |
      |                               |
      | texttexttexttext              |
      | texttexttexttext              |
      |                               |
      | [My projects]   [Match now!]  |
      +-------------------------------+

### Projects page

      +-------------------------------+
      | Your projects          <user> |
      |                               |
      |   1. Fish of Borneo [Go]      |
      |   2. Flies of Java  [Go]      |
      |                               |
      | [Add project]                 |
      +-------------------------------+

### Project page

      +-------------------------------+
      | Fish of Borneo         <user> |
      |                               |
      | ( Message area )              |
      |                               |
      | Filename Label Thumb Edit Del |
      | IMG1.jpg       XXX    [R] [C] |  <- [R]=radio button, [C]=checkbox
      | IMG3.jpg Fish1 XXX    [R] [C] |
      | IMG5.jpg       XXX    [R] [C] |
      |                 [next] [last] |
      |                               |
      | [Upload Images] [Add Labels]  |
      | [Edit]  [Delete]  [Settings]  |
      | [Matching Stats]
      +-------------------------------+

`[Upload Images]` opens file selection box (with `Submit`),
`[Add labels]` opens textbox for pasting CSV (with `Submit`): 

      IMG1.jpg,Fish2
      IMG3.jpg,Fish8

### Project seetings page

      +-------------------------------+
      | Fish of Borneo         <user> |
      |                               |
      | Matching type:                |
      |   Label <-> unlabeled  [R]    |
      |   All files random     [R]    |
      +-------------------------------+

### Statistics page

      +-------------------------------+
      | Fish of Borneo         <user> |
      |                               |
      | Total matches : 2300          |
      |                               |
      | FilenameA FilenameB Same Diff |
      | IMG1.jpg  IMG23.jpg    2   30 |
      | IMG1.jpg  IMG25.jpg   42    3 |
      | IMG2.jpg  IMG23.jpg   10   20 |
      | ...                           |
      +-------------------------------+
