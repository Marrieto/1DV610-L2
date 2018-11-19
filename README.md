
# 1DV610 - Workshop 3

An assignment in the course **Introduction to software quality**

### Introduction
The project is currently hosted on [DigitalOcean](http://159.89.2.45/). In the [automated tests](http://csquiz.lnu.se:25083/index.php) I got 81% with the username _Admin_ and the password _*Password*_, but feel free to create a new user. 

### Status
For the first hand in I implemented the use of session, (started with cookies)  and a database. That's where I stopped. There is still some work that could be done on the second assignment, the use of cookies and cookie safety, more specific the test cases 3.3, 3.4, 3.6, 3.7 and 3.8 .

### Changes
I've made some changes since my last submission. I tried to summarize most of them [here](https://github.com/Marrieto/1DV610-L2/blob/master/Changes.md). I also updated the test cases since my last submission.

### How to run the code
To be able to run the code, you must first install a stack with Apache, MySQL and PHP. On my server I'm running a LAMP stack.

1. Pull down the repo to your folder where your stack is executed. On my LAMP server this is "~/var/www/html".
2. Copy the file "configexample.php" and name it "config.php", and fill it with your settings such as username, password, port etc. It's a file with empty settings that consist of 'XXX' and zeros. Make sure to replace them. When you first start the project, the table/s are created with the right information if they don't already exist.

### Extra use cases and tests
I added three extra use cases to the project after the first hand-in. I was satisfied with 81% on the other functionality. The extra use cases is regarding the creation of notes, and is as follows:
1. A user is able to see his/her posts.
2. A user is able to create a new post.
3. A user is able to delete a post.

The use cases are described in more detail below.

#### Use case 1 - View note/s 
1. User logs in to his/her account.
2. The system checks if that user has any saved notes in the database
3. If there's any notes to show, the note is displayed under _Notes are listed down below:_ with an ID and the content of the note.

#### Use case 2 - Add note 
1. User logs in to his/her account.
2. User fills in the text box next to _Add note_ with the content of the note
3. The system creates and saves the note to the database
4. The message _Note added._ is displayed on the screen

#### Use case 3 - Delete note 
1. User logs in to his/her account.
2. User fills in the text box next to _Remove note with id_ with the id of the note
3. The system deletes the note from the database
4. The message _Note deleted._ is displayed on the screen
 
 The test cases created for the use cases can be found [here](https://github.com/Marrieto/1DV610-L2/blob/master/TestCases.md). 
