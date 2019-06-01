create database dbmiami;
use dbmiami;

create table Users(
	userid int auto_increment,
    username varchar(20) unique,
    password varchar(20),
    role varchar(15),
    primary key (userid));
    
DROP TABLE IF EXISTS students
CREATE TABLE IF NOT EXISTS students (
  first_name varchar(30) NOT NULL,
  last_name varchar(30) NOT NULL,
  email varchar(60) DEFAULT NULL,
  street_name varchar(30) NOT NULL,
  city varchar(40) NOT NULL,
  country varchar(2) DEFAULT NULL,
  phone varchar(20) NOT NULL,
  d_day int(11) NOT NULL,
  d_month enum(10) NOT NULL,
  d_year int(11) NOT NULL,
  gender enum('M','F') NOT NULL,
  date_entered timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  student_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (student_id)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
alter table students auto_increment = 100


create table Profesors(
	profesor_id int auto_increment,
    first_name varchar(30) not null,
    last_name varchar(30) not null,
    email varchar(60),
    primary key(profesor_id));
ALTER TABLE Profesors add phone varchar(20);
alter table Profesors auto_increment = 10;
    
INSERT INTO Profesors(first_name,last_name,email) values('Ruzhdi','Sefa','ruzhdi.sefa@uni-pr.edu');

create table Subjects(
	subject_id int,
    subject_name varchar(30) not null,
    ects int,
    primary key(subject_id));
    
alter table Subjects modify subject_name varchar(50);
    
INSERT INTO Subjects(subject_id,subject_name,ects) VALUES (001,'Mathematics 1',7);
INSERT INTO Subjects(subject_id,subject_name,ects) VALUES (002,'Physics 1',6);
INSERT INTO Subjects(subject_id,subject_name,ects) VALUES (003,'Foundamentals of Electrothechnics',7);
INSERT INTO Subjects(subject_id,subject_name,ects) VALUES (004,'Programming Language',5);
INSERT INTO Subjects(subject_id,subject_name,ects) VALUES (005,'English',5);
INSERT INTO Subjects(subject_id,subject_name,ects) VALUES (006,'Electric Circuits',7);
INSERT INTO Subjects(subject_id,subject_name,ects) VALUES (007,'Physiscs 2',6);
INSERT INTO Subjects(subject_id,subject_name,ects) VALUES (008,'Mathematics 2',7);
INSERT INTO Subjects(subject_id,subject_name,ects) VALUES (009,'Digital Circuits',5);
INSERT INTO Subjects(subject_id,subject_name,ects) VALUES (010,'Algorithms',5);

select * from subjects
    
drop table if exists Teachs
create table Teachs(
	profesor_id int,
    subject_id int,
    primary key(profesor_id,subject_id),
    foreign key(profesor_id) references Profesors(profesor_id) on delete cascade,
    foreign key(subject_id) references Subjects(subject_id) on delete cascade)
INSERT INTO Teachs(profesor_id,subject_id) VALUES(1,003);

drop table if exists Grades
create table Grades(
	student_id int(10) unsigned,
    subject_id int,
    grade int,
    primary key(student_id,subject_id),
    foreign key(student_id) references Students(student_id) on delete cascade,
    foreign key(subject_id) references Subjects(subject_id) on delete cascade);
    

INSERT INTO Grades(student_id,subject_id,grade) values(19,003,9);
INSERT INTO Grades(student_id,subject_id,grade) values(19,006,6);
INSERT INTO Grades(student_id,subject_id,grade) values(14,003,6);
INSERT INTO Grades(student_id,subject_id,grade) values(18,003,10);

INSERT INTO Grades(student_id,subject_id,grade) values(21,003,10);




        

create table Messages(
	messageid int auto_increment,
    name varchar(20) not null,
    email varchar(20) not null,
    content varchar(1024),
    primary key(messageid))
    
    
    
    
alter table students modify country varchar(30);

alter table students auto_increment = 101;
alter table students modify gender char(1);
alter table students modify d_month char(3);
alter table users modify password varchar(255);
    
insert into Users(username,password,role) values('admin','admin','admin')
    
select * from Users
select * from students
SELECT student_id FROM students where student_id = (select max(student_id) from students)


delete from students
truncate table students

delete from students where student_id=101

INSERT INTO students(first_name,last_name,email,street_name,city,country,phone,d_day,d_month,d_year,gender) VALUES('Redon','Osmanollaj','redon_osmanollaj@gmail.com','Hasan Prishtina','Obiliq','Kosove','045257900',03,12,1999,'M')

select * from users
where username='admin' and password='admin'    
    

select * from Messages
alter table messages modify email varchar(50);
delete from messages

    
SELECT S.subject_id, S.subject_name, P.first_name,P.last_name, S.ects, G.grade
FROM Subjects S, Profesors P, Grades G, Students St, Teachs T
where S.subject_id=G.subject_id and St.student_id = G.student_id and P.profesor_id=T.profesor_id and T.subject_id=S.subject_id
and St.student_id = 19
    
    
select * from profesors

select *
from Teachs T, Subjects S, Profesors P
where T.profesor_id = P.profesor_id and T.subject_id = S.subject_id;

select * from subjects
select * from teachs
select * from grades
REPLACE INTO Grades(student_id,subject_id,grade) VALUES(8,3,10);

-- lendet te cilat i jep profesori
select S.subject_id,S.subject_name
from Profesors P, Subjects S, Teachs T
where P.profesor_id=T.profesor_id and S.subject_id = T.subject_id and P.profesor_id=7

-- notat e studentit per e lendet e profesorit ne fjale
select *
from Grades
where student_id = 19 and subject_id = 003;


SELECT S.subject_id, S.subject_name 
                  FROM Teachs T, Subjects S 
                  WHERE S.subject_id=T.subject_id and T.profesor_id=7


delete from Students
delete from Messages
delete from Profesors
select * from teachs
select * from grades
select * from users

delete from users where userid>1



