# Test cases

### Manual test cases for the use cases:
1. View note/s
2. Add note
3. Delete note

To view/add/remove notes one needs to be logged in. Make sure to create an account first.
## Test case 1.1 View note/s
#### pre-requisites
One or more note exist in the database that belong to that user.
#### Input 
1. Login to the application.
#### Output 
1. Under _Notes are listed down below:_ the note should appear with and ID next to it.
#### Status
_Success_
## Test case 2.1 Create a new note with text content
#### Input 
1. Login to the application.
2. Enter some text in the text field next to the button _Add note_
3. Click _Add note_.
#### Output 
1. A message with "Note added." is displayed.
2. The note is displayed under "Notes are list down below:" with an ID and text content.
#### Status
_Success_
## Test case 2.2 Create a new note with no text content
#### Input 
1. Login to the application.
2. Enter no text in the text field next to the button _Add note_
3. Click _Add note_.
#### Output 
1. A message with "Please enter some text to be saved." is displayed..
#### Status
_Failed_
## Test case 2.3 Create a new note with code content
#### Input 
1. Login to the application.
2. Enter `<p> Hello </p>` in the text field next to the button _Add note_
3. Click _Add note_.
#### Output 
1. A message with "No code allowed!" is displayed..
#### Status
_Failed_
## Test case 3.1 Delete a note with text content
#### pre-requisites
A note with ID is added in the database.
#### Input 
1. Login to the application.
2. Enter the ID of the note you want to delete in the text field next to the button _Remove note with id_.
3. Click _Remove note with id_.
#### Output 
1. A message with "Note deleted." is displayed.
2. The note is removed from the list.
#### Status
_Failed_
## Test case 3.2 Delete a note with wrong id
#### pre-requisites
A note with ID is added in the database.
#### Input 
1. Login to the application.
2. Enter an ID of a note that isn't displayed in the list.
3. Click _Remove note with id_.
#### Output 
1. A message with "No note with that id." is displayed.
#### Status
_Failed_
