PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE contact_form (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    email TEXT NOT NULL,
    telephone TEXT NOT NULL,
    subject TEXT NOT NULL,
    message TEXT NOT NULL
);
INSERT INTO contact_form VALUES(13,'someone','else','someone@else.com','01111222333','Enquiry','Someone wants to know something');
INSERT INTO contact_form VALUES(14,'last','person','last@person.com','01123456789','Complaint','why am i last?');
DELETE FROM sqlite_sequence;
INSERT INTO sqlite_sequence VALUES('contact_form',14);
COMMIT;
