create database dbmiami
use dbmiami

create table Users(
	userid int auto_increment,
    username varchar(20) unique,
    password varchar(20),
    role varchar(15),
    primary key (userid))
    
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

alter table students modify country varchar(30);

alter table students auto_increment = 101;
alter table students modify gender char(1);
alter table students modify d_month char(3);
    
insert into Users(username,password,role) values('admin','admin','admin')
    
select * from Users
select * from students


delete from students
truncate table students

delete from students where student_id=101

INSERT INTO students(first_name,last_name,email,street_name,city,country,phone,d_day,d_month,d_year,gender) VALUES('Redon','Osmanollaj','redon_osmanollaj@gmail.com','Hasan Prishtina','Obiliq','Kosove','045257900',03,12,1999,'M')

select * from users
where username='admin' and password='admin'


create table Messages(
	messageid int auto_increment,
    name varchar(20) not null,
    email varchar(20) not null,
    content varchar(1024),
    primary key(messageid))
    
    
select * from Messages
    
    

