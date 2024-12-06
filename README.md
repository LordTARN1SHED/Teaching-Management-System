# Teaching Management System

## Overview
This project was developed as part of the **Database System Principles Course Design** at the School of Computer Science and Technology, Jilin University. It aims to create a simplified teaching management system with features for students, teachers, and administrators.

### Features
1. **Student Functionality**:
   - Manage personal information.
   - Enroll, drop, and view courses.
   - Check grades and course details.

2. **Teacher Functionality**:
   - Manage personal information.
   - Manage courses they teach.
   - Enter and manage student grades.

3. **Administrator Functionality**:
   - Full control over database content.
   - Add, modify, and delete courses.
   - Assign or unassign teachers to courses.
   - Modify student grades and course details.
   - Manage schedules, locations, and other database elements.

---

## Responsibilities

I independently completed the entire project, which involved end-to-end design, development, integration, and testing of the system, covering:

- **Project Design**:
  - Developed the overall structure and implemented the initial framework, including setting up 9 core database tables: `account`, `admin`, `teacher`, `course`, `location`, `studenttake`, `teach`, `timetable`, and `weektable`.
  - Designed the database schema with a focus on ensuring data integrity and optimizing query performance.

- **Student Functionality**:
  - Created the student interface with features for course enrollment, viewing enrolled courses, grades, and course information.
  - Developed mechanisms to handle restrictions such as time conflicts, duplicate enrollments, and logic to ensure students cannot withdraw from courses with grades.

- **Teacher Functionality**:
  - Built the teacher interface, allowing teachers to manage their courses and input grades for students.
  - Ensured that grades, once entered, cannot be modified by teachers, requiring administrator intervention for changes.
  - Implemented dynamic table interactions for switching between courses and viewing student lists.

- **Administrator Functionality**:
  - Developed a comprehensive admin panel to manage all aspects of the database:
    - Add, delete, and modify courses with detailed fields.
    - Assign and unassign teachers to courses, with safeguards to prevent unassigning teachers for courses already selected by students.
    - Manage schedules, locations, and week data with full CRUD capabilities.
    - Implemented nested subqueries for real-time computation of course enrollment numbers.

- **Frontend Development**:
  - Designed dynamic and responsive HTML pages.
  - Integrated JavaScript for interactivity, animations, collapsible menus, and responsive layouts.
  - Created a user-friendly interface with features like dynamic resizing for different window sizes and content lengths.

- **Backend Development**:
  - Used PHP to handle server-side logic and manage database interactions.
  - Implemented robust data validation and error handling to ensure security and logical consistency.

- **Integration and Testing**:
  - Unified visual styles and integrated all features into a cohesive system.
  - Conducted extensive testing to ensure the system’s robustness, handling both edge cases and real-world scenarios.

---

## Technical Implementation
### **Frontend**:
- **Framework**: HTML and JavaScript.
- **Dynamic Effects**: JavaScript for animations and responsive UI.
- **Database Interaction**: PHP for dynamic content rendering.

### **Backend**:
- **PHP**: Server-side logic and database interaction.
- **MySQL**: Database operations with a focus on integrity and performance.

### **Challenges and Solutions**:
1. **Database Complexity**:
   - Managed relationships across multiple tables to ensure consistent data.
   - Optimized queries for faster performance.

2. **Administrator Functionality**:
   - Developed a flexible permission control system.
   - Handled complex logical dependencies (e.g., preventing student withdrawals after grades are entered).

3. **Frontend and Backend Integration**:
   - Ensured seamless communication between user interfaces and backend services.

---

## Conclusion
This project demonstrates the ability to design and implement a comprehensive teaching management system that integrates frontend and backend technologies. It provides a solid foundation for managing academic activities efficiently while offering a responsive and intuitive user experience.
