drop database checkapp;
create database checkapp;
use checkapp;
create table users(
    id int(11) primary key auto_increment,
    unique_id varchar(23) not null unique,
    name varchar(255) not null,
    chatuid varchar(255) not null unique,
    email varchar(255) not null unique,
    encrypted_password varchar(255) not null, 
    salt varchar(10) not null,
    created_at datetime,
    updated_at datetime null
);
create table groups(
    id int(11) primary key unique,
    groupName varchar(255) not null,
    groupDescription varchar(2000) not null,
    language varchar(10) not null,
    version int(11)
);

create table groupsByUsers(
    idUser int(11) NOT NULL,
    idGroup int(11) NOT NULL,
    isAdmin int(11) DEFAULT 0,
    description varchar(255) not null,
    CONSTRAINT pk_GroupsByUsers PRIMARY KEY (idUser, idGroup)
);

insert into groupsByUsers (idUser, idGroup) VALUES (1,1); 

CREATE USER 'login_user'@'localhost' IDENTIFIED BY 'FSLe6IOCZy5p';
GRANT ALL PRIVILEGES ON checkapp.users TO 'login_user'@'localhost';
GRANT ALL PRIVILEGES ON checkapp.groups TO 'login_user'@'localhost';
GRANT ALL PRIVILEGES ON checkapp.groupsByUsers TO 'login_user'@'localhost';
FLUSH PRIVILEGES;

