-- message.php : 요청 메시지를 쓰고 전송하는 페이지
-- 요청 메시지를 저장한다.
SELECT MAX(Mnumber) AS max_number FROM MESSAGE; -- 메시지가 아무것도 없는 경우도 처리해야한다.
SELECT NOW() AS mtime;
INSERT INTO MESSAGE VALUES (max_number + 1, '받는사람', R수업번호, '보내는사람', S수업번호, '제목', '시작시간', '종료시간', '요일', '본문', 'mtime');

-- messageview.php : 요청 메시지 리스트를 보여주는 페이지
-- 요청 메시지의 대략적인 내용을 보여준다.
SELECT Mnumber, Title, Sender, Lname, Course_room, Mstime, Mftime, Mday, Mtime
FROM MESSAGE, LOCATION, CLASSROOM, COURSE
WHERE Receiver = '받는사람' AND RCnumber = Cnumber AND Course_room = Class_room AND Lnum = Lnumber;

-- messagedetail.php : 요청 메시지의 상세한 정보 및 본문 내용을 보여주는 페이지
-- MESSAGE 테이블의 모든 정보를 꺼낸다.
SELECT * FROM MESSAGE WHERE Mnumber = $num;

-- messageaprocess.php : 요청 메시지를 수락/거절했을 경우 해당 부분을 처리하는 페이지
-- 거절한 경우 : 거절했다고 자동으로 답장을 보낸다.
SELECT Receiver, Sender, Title FROM MESSAGE WHERE Mnumber = $num;
UPDATE MESSAGE 
SET Receiver = '$Sender', Sender = '$Receiver', Title = '<거절> ' + '$title', Mtime = NOW()
WHERE Mnumber = $num;

-- 수락한 경우 :
SELECT MAX(Enumber) AS max_number FROM EXAM; -- 시험일정이 아무것도 없는 경우도 처리해야한다.
SELECT SCnumber, Course_room, Mstime, Mftime, Mday
FROM MESSAGE, COURSE
WHERE Mnumber = $num AND Cnumber = RCnumber;
INSERT INTO EXAM VALUES (max_number + 1, $SCnumber, '$Course_room', '$Mstime', '$Mftime', '$Mday');

--수락했다고 자동으로 답장을 보낸다.
SELECT Receiver, Sender, Title FROM MESSAGE WHERE Mnumber = $num;
UPDATE MESSAGE 
SET Receiver = '$Sender', Sender = '$Receiver', Title = '<수락> ' + '$title', Mtime = NOW()
WHERE Mnumber = $num;
