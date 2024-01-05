# CNote - Online Task Note-Taking Web Application

### Is it  CuteNote 😻 ? CongviecNote 📑 ?  CamnguyenNote 👩‍💻 ?  CloudNote ☁️ ? 
### Try to find out [https://cnotee.000webhostapp.com/index.php?url=Login](https://cnotee.000webhostapp.com/index.php?url=Login)
---
CNote is a web-based PHP MVC application designed for online task note-taking. Users can log in to view, add, edit, mark as done, or delete notes directly on the web platform. Each note consists of a title, content, due date, and a status indicating whether it's completed or not.

## Features

1. **User:**
   - Sign up and log in to the application securely.
   - Update profile information or delete account.

2. **Note:**
   - Each task note includes a title, content, due date, and a status (done or undone).
   - View, add, edit, and delete notes with ease.
   - Mark tasks as done or not done to keep track of progress.
   - Separate done and undone tasks for better organization.
   - Search for tasks based on title and date for quick retrieval.
   - Import file to add multiple tasks note at once

## Technologies Used

- PHP (MVC Architecture)
- PostgreSQL
- HTML, CSS, JavaScript

## Getting Started

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/yourusername/CNote.git
   cd CNote
   ```

2. **Database Setup:**
   - Change your database information in [mvc/core/Database.php](mvc/core/Database.php)
   - Import the provided SQL file (`CNote.sql`) into your database.
   - On line 69 of TaskModel.php, when using PostgreSQL, use 'userid'. However, if you are using MySQL, please change it to 'userId'.

3. **Run the Application:**
   - Using XAMPP, WampServer,..:
        - Start your local server
        - Access the application through `http://localhost/index.php?url=Login`.
          
   - Using PHP:
       ```bash
       php -S 127.0.0.1:2106
       ```
       - Access the application through `http://127.0.0.1:2106/index.php?url=Login`.

## Usage

1. **User Registration and Login:**
   - Sign up for a new account.
   - Username (1-30 characters) and Password (6-30 characters). Alphanumeric only
   - Login to your account using your Username and Password
     <img width="1440" alt="image" src="https://github.com/cnmeow/cnote/assets/73975520/f151bf48-4eae-40d2-98a6-7b0a4c54d509">

2. **Note Management:**
   - Navigate to the "Notes" section to view, add or mark as done the undone task notes.
   - Select Completed to view all done task notes
   - Utilize the search bar to find tasks by title or date
      <img width="1440" alt="image" src="https://github.com/cnmeow/cnote/assets/73975520/1dd78d09-54e4-4180-9d55-b9d53715ba16">
  - Click Edit button to edit the task note
     <img width="1440" alt="image" src="https://github.com/cnmeow/cnote/assets/73975520/80acd541-8136-4ce1-b18e-bf274fe260a3">
  - Add individual tasks or import multiple tasks at once by uploading a file. Clicking on the 'Download Template' will download two sample files (txt and xlsx) with instructions on the correct format for importing. Those two files are also placed in the [public/templateFileForImport](public/templateFileForImport). Click 'Import file', choose a file correctly formatted according to the template, and upload.
     <img width="1084" alt="image" src="https://github.com/cnmeow/cnote/assets/73975520/c7f8179b-fb00-46cf-aa7d-10d3f2fc4225">


3. **User Profile Management:**
   - Update your profile information or delete your account in the "Profile" section.
      <img width="1440" alt="image" src="https://github.com/cnmeow/cnote/assets/73975520/2888b909-8aa5-4a47-9614-66b25ba2c9c6">


## Author: Cam Nguyen 👩‍💻
