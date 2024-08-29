CREATE TRIGGER before_issue_delete
BEFORE DELETE ON issues
FOR EACH ROW
BEGIN
    INSERT INTO issue_history (IssueID, StudentRoll, Issues, Description, DateRaised)
    VALUES (OLD.IssueID, OLD.StudentRoll, OLD.Issues, OLD.Description, OLD.DateRaised);
END;

CREATE TRIGGER after_student_insert
AFTER INSERT ON students
FOR EACH ROW
BEGIN
    INSERT INTO student_login_credentials (roll, email, password)
    VALUES (NEW.StudentRoll ,NEW.StudentEmail, NEW.StudentPassword);
END;

CREATE TRIGGER after_student_password_update
AFTER UPDATE ON students
FOR EACH ROW
BEGIN
    IF OLD.StudentPassword != NEW.StudentPassword THEN
        UPDATE student_login_credentials
        SET password = NEW.StudentPassword
        WHERE email = NEW.StudentEmail;
    END IF;
END;