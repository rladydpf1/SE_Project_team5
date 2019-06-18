CREATE TABLE LOCATION (
Lnumber		INT UNSIGNED	NOT NULL,
Lname		VARCHAR(20)	,
PRIMARY KEY(Lnumber)
)DEFAULT CHARSET=utf8;

CREATE TABLE CLASSROOM (
Class_room	VARCHAR(20)	NOT NULL,
Lnum		INT UNSIGNED	NOT NULL,
Seat		INT UNSIGNED	,
FOREIGN KEY(Lnum) REFERENCES LOCATION (Lnumber),
PRIMARY KEY(Class_room)
)DEFAULT CHARSET=utf8;

CREATE TABLE STUDENT (
Snumber		VARCHAR(11)	NOT NULL,
Sname		VARCHAR(20)	,
Spwd		VARCHAR(10)	NOT NULL,
PRIMARY KEY(Snumber)
)DEFAULT CHARSET=utf8;

CREATE TABLE PROFESSOR (
Pnumber		VARCHAR(11)	NOT NULL,
Pname		VARCHAR(20)	,
Ppwd		VARCHAR(10)	NOT NULL,
PRIMARY KEY(Pnumber)
)DEFAULT CHARSET=utf8;

CREATE TABLE COURSE (
Cnumber		INT UNSIGNED	NOT NULL,
Cname		VARCHAR(20)	NOT NULL,
Pnum		VARCHAR(11)	NOT NULL,
Course_room	VARCHAR(10)	NOT NULL,
PRIMARY KEY(Cnumber),
FOREIGN KEY(Pnum) REFERENCES PROFESSOR (Pnumber),
FOREIGN KEY(Course_room) REFERENCES CLASSROOM (Class_room)
)DEFAULT CHARSET=utf8;

CREATE TABLE CLASSHOUR (
Hnumber		INT UNSIGNED	NOT NULL,
Conum		INT UNSIGNED	NOT NULL,
Cstime		TIME		,
Cftime		TIME		,
Cday		VARCHAR(10)	,		
PRIMARY KEY(Hnumber),
FOREIGN KEY(Conum) REFERENCES COURSE (Cnumber)
)DEFAULT CHARSET=utf8;

CREATE TABLE EXAM (
Enumber		INT UNSIGNED	NOT NULL,
Cnum		INT UNSIGNED	NOT NULL,
Exam_room	VARCHAR(10)	,
Estime		TIME		,
Eftime		TIME		,
Eday		VARCHAR(10)	,
FOREIGN KEY(Exam_room) REFERENCES CLASSROOM (Class_room),
FOREIGN KEY(Cnum) REFERENCES COURSE (Cnumber),
PRIMARY KEY(Enumber)
)DEFAULT CHARSET=utf8;

CREATE TABLE MESSAGE (
Mnumber		INT UNSIGNED	NOT NULL,
Receiver	VARCHAR(11)	    NOT NULL,
RCnumber    INT UNSIGNED    NOT NULL,
Sender		VARCHAR(11)	    NOT NULL,
SCnumber    INT UNSIGNED    NOT NULL,
title		VARCHAR(100)	NOT NULL,
Mstime		TIME		,
Mftime		TIME		,
Mday        VARCHAR(10)	,
Contents	VARCHAR(1000)	,
Mtime		DATETIME	,

PRIMARY KEY(Mnumber),
FOREIGN KEY(RCnumber) REFERENCES COURSE (Cnumber),
FOREIGN KEY(SCnumber) REFERENCES COURSE (Cnumber),
FOREIGN KEY(Receiver) REFERENCES PROFESSOR (Pnumber),
FOREIGN KEY(Sender) REFERENCES PROFESSOR (Pnumber)
)DEFAULT CHARSET=utf8;

CREATE TABLE TAKE_CLASS (
Snum		VARCHAR(11)	NOT NULL,
Cno		INT UNSIGNED	NOT NULL,
FOREIGN KEY(Cno) REFERENCES COURSE (Cnumber),
FOREIGN KEY(Snum) REFERENCES STUDENT (Snumber),
PRIMARY KEY(Snum, Cno)
)DEFAULT CHARSET=utf8;
