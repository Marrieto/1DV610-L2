

## Updates and changes

I did many changes since my last assignment failed. I continuously improved the names of the variables and functions to improve understandability. I cannot list all of these. However, in the list below I'll list bigger changes made since the last submission:

 - [x] Time is properly displayed with hours and minutes
**calculateDateAndTime** in **TimeModel** now displays the time with the hh:mm format.
 - [x] All functions are now withing a class 
E.g the **TimeModel** is now in its own class.
 - [x] Do not allow empty notes
 If the user writes an empty note, the user is met with the message "Cannot add an empty note!".
 - [x] Do not allow too long notes
If the user write too many characters into the input field, the user is met with the message "Note cannot be longer than 500 characters!".
 - [x] Do not allow deletion of other users notes
If the user tries to delete another users' notes, or removing a note that doesn't exist, the user gets the message "Remove note error: no note with that ID found.".
 - [x] Do not allow code in notes
 If the user write code in the input, the user is met with the message "Code is not allowed to be submitted to a note!".
  - [x] Changes name on **StatusMessage** class
I changed the name of **StatusMessage** to **ResponseObject**, to make it clearer that it is a object containing a response from different operations.
  - [x] Removed dead and unreachable code

  - [x] Exceptions for increased code readability and understandability
I started to throw exceptions in many places instead of linking if-statement after if-statement, e.g. **userTriedToRegister()** in **RegisterController.php**.

An important note here, I chose to use the generic Exception class with informative error messages, instead of using custom exceptions, as Robert C. Martin explained in *Clean Code* on p. 108


The test cases have been updated.
