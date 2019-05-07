-- 수업 목록 페이지에서 사용할 쿼리

-- 교수 시험 일정 목록 출력
SELECT	Cnumber, Cname, Lname, Exam_room, Estime, Eftime, Eday
FROM	COURSE, EXAM, PROFESSOR, LOCATION, CLASSROOM
WHERE	Pnumber = '교수' AND Pnumber = Pnum AND Cnumber = Cnum AND Exam_room = Class_room;

-- 교수 수업 목록 출력
SELECT	Cname, Course_room, Cstime, Cftime, Cday
FROM	COURSE, PROFESSOR, LOCATION, CLASSROOM, CLASSHOUR
WHERE	Pnumber = '교수' AND Pnumber = Pnum AND Cnumber = Conum AND Course_room = Class_room;

-- 학생 시험 일정 목록 출력
SELECT	Cnumber, Cname, Lname, Exam_room, Estime, Eftime, Eday
FROM	COURSE, EXAM, STUDENT, TAKE_CLASS, LOCATION, CLASSROOM
WHERE	Snumber = '학생' AND Snumber = Snum AND Cno = Cnumber AND Cnumber = Cnum AND Exam_room = Class_room;

-- 학생 수업 목록 출력
SELECT	Cname, Pnum, Course_room, Cstime, Cftime, Cday
FROM	COURSE, STUDENT, TAKE_CLASS, LOCATION, CLASSROOM, CLASSHOUR
WHERE	Snumber = '학생' AND Snumber = Snum AND Cno = Cnumber AND Cnumber = Conum AND Course_room = Class_room;
