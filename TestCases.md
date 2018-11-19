
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
1. A me with "Note added." is d
2. The no is displaunder "Notes are list down below:" with an ID and text content.
#### Status
_Success_
## Test case 2.2 Create a new note with no text content
#### Input 
1. Login to the application.
2. Enter no text in thetext field next to the button _Add note_
3. Click _Add note_.
#### Output 
1. A me with "Cannot add an empty note!" is displayed
#### Status
_Success_
## Test case 2.3 Create a new note with code content
#### Input 
1. Login to the application.
2. Enter `<p> Hello </p>` in the text field next to the button _Add note_
3. Click _Add note_.
#### Output 
1. A message with "Code is not allowed to be subbmitted to a note!" is displayed.
#### Status
_Success_

## Test case 2.4 Create a new note with too much content
#### Input 
1. Login to the application.
2. Enter `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet sem ac nisl consectetur rhoncus. In placerat lacus et diam maximus, sed lacinia sem varius. Cras commodo risus at tristique pretium. In at libero dui. Aliquam erat volutpat. Phasellus in leo vitae arcu vehicula sodales. Curabitur tincidunt suscipit mi vitae molestie. Maecenas ultrices ex eget massa tincidunt ultricies. Cras eu sagittis mauris, vitae rhoncus nunc. Integer nisi risus, sollicitudin sed sapien vitae, vulputate tincidunt risus. Aenean sodales est sit amet felis placerat lobortis. Pellentesque auctor leo quis tellus vehicula elementum id vitae ligula. Vestibulum pharetra urna ac urna interdum, vel placerat mauris tristique. Nullam ultricies venenatis ligula ac finibus. Donec laoreet nisl vitae ligula finibus aliquet.`  in the text field next to the button _Add note_
3. Click _Add note_.
#### Output 
1. A message with "Note cannot be longer than 500 characters!" is displayed.
#### Status
_Success_

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
_Success_
## Test case 3.2 Delete a note with wrong id
#### pre-requisites
A note with ID is added in the database.
#### Input 
1. Login to the application.
2. Enter an ID of a note that isn't displayed in the list.
3. Click _Remove note with id_.
#### Output 
1. A message with "Remove note error: no note with that ID found." is displayed.
#### Status
_Success_
