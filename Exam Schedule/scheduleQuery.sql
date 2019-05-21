-- 시험일정 선택 페이지에서 사용할 쿼리

-- 해당 시험 일정과 겹치는 수업 또는 시험일정이 없는지 확인
-- 1. 시험일정을 등록하지 않은 강의를 먼저 저장한다.
CREATE OR REPLACE VIEW NOT_EXIST_EXAM AS
SELECT Cnumber AS VCnumber
FROM COURSE
WHERE Cnumber NOT IN ( SELECT DISTINCT Cnum FROM EXAM );

-- 2. 위에서 저장한 강의의 강의실, 요일이 겹치는 경우를 저장한다.
CREATE OR REPLACE VIEW COURSE_LOCA AS
SELECT VCnumber, Pnum
FROM NOT_EXIST_EXAM, COURSE, CLASSHOUR
WHERE VCnumber = Cnumber AND Cnumber = Conum AND Course_room = '강의실' AND Cday = '요일';

-- 3. 위에서 저장한 강의의 시간대가 겹치는 경우를 찾는다.
SELECT DISTINCT VCnumber, Pnum
FROM COURSE_LOCA JOIN CLASSHOUR ON Vcnumber = Conum
WHERE TIME('시작시간') BETWEEN Cstime AND Cftime OR TIME('종료시간') BETWEEN Cstime AND Cftime;
-- 시작시간, 종료시간 포맷 : '00:00:00' 형태
-- VCnumber이 하나 이상 있을 경우 사용자는 각 교수에게 메시지를 보낼 것인지 결정한다.

-- 
