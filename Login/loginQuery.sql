-- 로그인 인증 시 사용할 쿼리

SELECT	Ppwd
FROM	PROFESSOR
WHERE	Pnumber = '아이디';

-- 아이디가 없으면 밑의 SELECT 문장으로 이동
-- 아이디가 있으면 Ppwd를 입력한 비밀번호와 비교
-- 비밀번호가 일치하면 교수로 로그인, Session에 등록
-- 비밀번호가 일치하지 않으면 비밀번호가 틀렸다고 출력 

SELECT 	Spwd
FROM	STUDENT
WHERE	Snumber = '아이디';

-- 아이디가 없으면 아이디가 일치하지 않습니다 출력
-- 아이디가 있으면 Spwd를 입력한 비밀번호와 비교
-- 비밀번호가 일치하면 학생으로 로그인, Session에 등록
-- 비밀번호가 일치하지 않으면 비밀번호가 틀렸다고 출력