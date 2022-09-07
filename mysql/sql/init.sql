DROP SCHEMA IF EXISTS posse;
CREATE SCHEMA posse;
USE posse;

DROP TABLE IF EXISTS events;
CREATE TABLE events (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(10) NOT NULL,
  start_at DATETIME NOT NULL,
  end_at DATETIME NOT NULL,
  deadline DATETIME NOT NULL,
  detail VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

DROP TABLE IF EXISTS users;

CREATE TABLE users
(
  id         INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name       VARCHAR(10)  NOT NULL,
  email      VARCHAR(255) NOT NULL,
  password   VARCHAR(255) NOT NULL,
  admin      INT          NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);


DROP TABLE IF EXISTS event_attendance;
CREATE TABLE event_attendance (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  event_id INT NOT NULL,
  user_id INT NOT NULL,
  participation INT NOT NULL,
  nonparticipation INT NOT NULL,
  notsubmitted INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

INSERT INTO
    `events` (
        `name`,
        `start_at`,
        `end_at`,
        `deadline`,
        `detail`
    )
VALUES
    (
        '縦モク',
        '2021/08/01 21:00',
        '2021/08/01 23:00',
        '2021/08/01 23:00',
        'サンプルテキスト'
    );
INSERT INTO
    `events` (
        `name`,
        `start_at`,
        `end_at`,
        `deadline`,
        `detail`
    )
VALUES
    (
        '横モク',
        '2021/09/22 21:00',
        '2021/09/22 23:00',
        '2021/09/22 23:00',
        'サンプルテキスト'
    );
INSERT INTO
    `events` (
        `name`,
        `start_at`,
        `end_at`,
        `deadline`,
        `detail`
    )
VALUES
    (
        '縦モク',
        '2021/09/23 21:00',
        '2021/09/23 23:00',
        '2021/09/23 23:00',
        'サンプルテキスト'
    );
INSERT INTO
    `events` (
        `name`,
        `start_at`,
        `end_at`,
        `deadline`,
        `detail`
    )
VALUES
    (
        'リアイベ',
        '2021/09/23 21:00',
        '2021/09/23 23:00',
        '2021/09/23 23:00',
        'サンプルテキスト'
    );
INSERT INTO
    `events` (
        `name`,
        `start_at`,
        `end_at`,
        `deadline`,
        `detail`
    )
VALUES
    (
        'スペモク',
        '2021/09/10 21:00',
        '2021/09/10 23:00',
        '2021/09/10 23:00',
        'サンプルテキスト'
    );



INSERT INTO users SET name='つよちゃん', email='test@posse-ap.com', password='password',admin=0;
INSERT INTO users SET name='れい', email='test2@posse-ap.com', password='password',admin=1;
INSERT INTO users SET name='かずき', email='test3@posse-ap.com', password='password',admin=0;
INSERT INTO users SET name='なおき', email='test4@posse-ap.com', password='password',admin=1;

INSERT INTO event_attendance SET event_id=1, user_id=1, participation=0, nonparticipation=0, notsubmitted=1;
INSERT INTO event_attendance SET event_id=1, user_id=2, participation=0, nonparticipation=1, notsubmitted=0;
INSERT INTO event_attendance SET event_id=1, user_id=3, participation=0, nonparticipation=1, notsubmitted=0;
INSERT INTO event_attendance SET event_id=2, user_id=1, participation=1, nonparticipation=0, notsubmitted=0;
INSERT INTO event_attendance SET event_id=2, user_id=3, participation=0, nonparticipation=1, notsubmitted=0;
INSERT INTO event_attendance SET event_id=3, user_id=2, participation=1, nonparticipation=0, notsubmitted=0;