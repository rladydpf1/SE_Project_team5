-- 시험일정 선택 페이지에서 사용할 쿼리

-- 해당 시험 일정과 겹치는 시험 일정이 없는지 확인 (시험의 건물, 강의실, 요일, 시간대가 겹치는 수업을 찾음)
-- 1. 시험 일정을 등록하지 않은 강의를 먼저 저장한다.
CREATE OR REPLACE VIEW NOT_EXIST_EXAM AS
SELECT Cnumber AS VCnumber
FROM COURSE
WHERE Cnumber NOT IN ( SELECT DISTINCT Cnum FROM EXAM );

-- 2. 위에서 저장한 강의의 강의실, 요일이 겹치는 경우를 저장한다.
CREATE OR REPLACE VIEW COURSE_LOCA AS
SELECT VCnumber
FROM NOT_EXIST_EXAM, COURSE, CLASSHOUR
WHERE VCnumber = Cnumber AND Cnumber = Conum AND Course_room = '강의실' AND Cday = '요일';

-- 3. 위에서 저장한 강의의 시간대가 겹치는 경우를 찾는다.
SELECT VCnumber
FROM COURSE_LOCA JOIN CLASSHOUR ON Vcnumber = Conum
WHERE TIME(Estime) BETWEEN '시작시간' AND '종료시간' OR TIME(Eftime) BETWEEN '시작시간' AND '종료시간';
