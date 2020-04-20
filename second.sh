#!/bin/sh

cd /var/www/html/chosei_kun


#SEリナックスに邪魔されないようにする
sudo setsebool -P httpd_can_network_connect_db=1

#アカウントを作成する
sudo mysql -u root -pteamA << EOF
USE mysql;
SET PASSWORD FOR root@localhost =PASSWORD('teamA') ;
GRANT ALL ON *.*  TO  chosei_kun@'%' IDENTIFIED BY 'teamA';
EOF

cat /etc/redhat-release
php --version
httpd -v
sudo mysql -u root -pteamA << EOF
SELECT version();
EOF



sudo mysql -u  chosei_kun  -pteamA << EOF
DROP DATABASE chosei_kun;

#DBを作る
CREATE  DATABASE chosei_kun
    DEFAULT CHARACTER SET utf8
    COLLATE utf8_general_ci;

#DBを選択
USE chosei_kun;

#各テーブルを作成
CREATE TABLE event(
    event_id	     BIGINT      PRIMARY KEY     AUTO_INCREMENT,
    event_name	     CHAR(200)   NOT NULL,
    event_memo	     TEXT        NOT NULL       DEFAULT '', 
    url_rand     	 CHAR(60)    NOT NULL       UNIQUE          DEFAULT '123456789abcdefghij',
    host_cookie	     CHAR(50)    NOT NULL       DEFAULT '12345',
    created_at       DATETIME    NOT NULL    
)ENGINE = InnoDB;
CREATE TABLE event_date(
    event_date_id    BIGINT      PRIMARY KEY     AUTO_INCREMENT,
    event_date	     CHAR(50)    NOT NULL,
    event_id	     BIGINT      NOT NULL,
    FOREIGN KEY(event_id) REFERENCES event (event_id) ON DELETE CASCADE
)ENGINE = InnoDB;
CREATE TABLE member(
    member_id	     BIGINT      PRIMARY KEY     AUTO_INCREMENT,
    member_name	     CHAR(50)    NOT NULL,
    member_comment	 CHAR(200)   NOT NULL        DEFAULT ''
)ENGINE = InnoDB;
CREATE TABLE attendance(
    event_date_id    BIGINT,
    member_id	     BIGINT,     
    attendance	 INT         NOT NULL        DEFAULT 0,
    PRIMARY KEY(event_date_id, member_id),
    FOREIGN KEY(member_id) REFERENCES member (member_id) ON DELETE CASCADE,
    FOREIGN KEY(event_date_id) REFERENCES event_date (event_date_id) ON DELETE CASCADE
)ENGINE = InnoDB;




INSERT INTO event(
        event_name,
        event_memo,
        created_at,
        url_rand
    )VALUE(
        '新年会','飲みに行きましょう',NOW(),'afdsjsaldjlkdfjsal'
);
INSERT INTO event_date (
        event_date,
        event_id
    )VALUE(
        '2020年4月10日17:00～',
        1
);
INSERT INTO event_date (
        event_date,
        event_id
    )VALUE(
        '2020年4月12日17:00～',
        1
);
INSERT INTO event_date (
        event_date,
        event_id
    )VALUE(
        '2020年4月13日17:00～',
        1
);




INSERT INTO member (
        member_name,
        member_comment
    )VALUE(
        'yamada',
        'ありがとう！'
);
#参加可否の登録
#イベント日程IDは分かっている前提
INSERT INTO attendance(
        event_date_id,
        member_id,
        attendance
    )VALUE(
        1,
        1,
        0
);
INSERT INTO attendance(
        event_date_id,
        member_id,
        attendance
    )VALUE(
        2,
        1,
        0
);
INSERT INTO attendance(
        event_date_id,
        member_id,
        attendance
    )VALUE(
        3,
        1,
        2
);





INSERT INTO member (
        member_name,
        member_comment
    )VALUE(
        '佐藤',
        'おつかれ'
);
#参加可否の登録
#イベント日程IDは分かっている前提
INSERT INTO attendance(
        event_date_id,
        member_id,
        attendance
    )VALUE(
        1,
        2,
        0
);
INSERT INTO attendance(
        event_date_id,
        member_id,
        attendance
    )VALUE(
        2,
        2,
        1
);
INSERT INTO attendance(
        event_date_id,
        member_id,
        attendance
    )VALUE(
        3,
        2,
        2
);






INSERT INTO event(
    event_name,
    event_memo,
    created_at,
    url_rand
)VALUE(
    '飲み会','今週どうでしょう',NOW(),'daskjjkljl'
);
INSERT INTO event_date (
    event_date,
    event_id
)VALUE(
    '2020年4月15日19:00～',
    2
);



EOF

gio open http:127.0.0.1/chosei_kun/test.php








