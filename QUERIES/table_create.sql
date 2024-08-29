CREATE TABLE admin (
    username VARCHAR(255) NOT NULL PRIMARY KEY,
    password VARCHAR(25) NOT NULL
);

CREATE TABLE students (
    StudentName VARCHAR(100) NOT NULL,
    StudentRoll INT(11) NOT NULL PRIMARY KEY,
    StudentEmail VARCHAR(100) NOT NULL,
    StudentPassword VARCHAR(255) NOT NULL,
    StudentPhoneNo VARCHAR(15) NOT NULL,
    StudentAltPhoneNo VARCHAR(15),
    StudentPhotoPath VARCHAR(255),
    StudentSex ENUM('M', 'F') NOT NULL,
    StudentDOB DATE NOT NULL,
    StudentDept ENUM('BTech', 'MCA', 'MTech', 'BE') NOT NULL,
    StudentSpecialisation ENUM('AEIE', 'CSBS', 'CSE', 'DS', 'AIML', 'CE', 'IT', 'ECE', 'EE'),
    ClassXPercentage FLOAT NOT NULL,
    ClassXIIPercentage FLOAT NOT NULL,
    UndergraduateCGPA FLOAT,
    PostgraduateCGPA FLOAT,
    NumberOfBacklogs INT(11) DEFAULT 0,
    PassoutYear YEAR(4) NOT NULL
);

CREATE TABLE job_posting (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    reference_number VARCHAR(255) NOT NULL,
    post_date DATE NOT NULL,
    batch_year YEAR(4) NOT NULL,
    recruiting_company VARCHAR(255) NOT NULL,
    streams TEXT,
    backlogs INT(11) NOT NULL,
    minimum_cgpa FLOAT NOT NULL,
    eligibility_description TEXT,
    selection_mode VARCHAR(255) NOT NULL,
    selection_mode_description TEXT,
    selection_process VARCHAR(255) NOT NULL,
    selection_date VARCHAR(255),
    designation VARCHAR(255) NOT NULL,
    remuneration VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    job_link VARCHAR(255) NOT NULL,
    class_x_percentage FLOAT NOT NULL,
    class_xii_percentage FLOAT NOT NULL,
    graduation_cgpa FLOAT NOT NULL,
    postgraduation_cgpa FLOAT
);

CREATE TABLE student_login_credentials (
    roll INT(11) NOT NULL PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    FOREIGN KEY (roll) REFERENCES students(StudentRoll)
);

CREATE TABLE placements (
    placement_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_roll INT(11),
    StudentDept ENUM('BTech', 'MCA', 'MTech', 'BE'),
    StudentSpecialisation ENUM('AEIE', 'CSBS', 'CSE', 'DS', 'AIML', 'CE', 'IT', 'ECE', 'EE'),
    job_post_id INT(11),
    company_name VARCHAR(255),
    designation VARCHAR(255),
    salary_package FLOAT,
    placement_date DATE,
    placement_status ENUM('Placed', 'Rejected')
);

CREATE TABLE applications (
    application_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_roll INT(11),
    job_post_id INT(11),
    application_date DATE,
    application_status ENUM('Applied', 'Shortlisted', 'Rejected', 'Selected') DEFAULT 'Applied',
    resume_path VARCHAR(255),
    FOREIGN KEY (student_roll) REFERENCES students(StudentRoll),
    FOREIGN KEY (job_post_id) REFERENCES job_posting(id)
);

CREATE TABLE issues (
    IssueID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    StudentRoll INT(11) NOT NULL,
    Issues TEXT NOT NULL,
    Description TEXT,
    DateRaised TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (StudentRoll) REFERENCES students(StudentRoll)
);

CREATE TABLE issue_history (
    IssueID INT(11) NOT NULL AUTO_INCREMENT,
    StudentRoll INT(11) NOT NULL,
    Issues TEXT NOT NULL,
    Description TEXT,
    DateRaised TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (IssueID),
    INDEX (StudentRoll)
);