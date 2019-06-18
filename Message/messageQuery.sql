-- message.php : 요청 메시지를 쓰고 전송하는 페이지
-- 요청 메시지를 저장한다.
SELECT MAX(Mnumber) AS max_number FROM MESSAGE; -- 메시지가 아무것도 없는 경우도 처리해야한다.
SELECT NOW() AS time;
INSERT INTO MESSAGE VALUES (max_number + 1, '받는사람', R수업번호, '보내는사람', S수업번호, '제목', '시작시간', '종료시간', '요일', '본문', 'time');

