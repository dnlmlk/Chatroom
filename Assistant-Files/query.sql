create database chatProject;

create table users(
    userName varchar(255) not null primary key ,
    name varchar(255),
    profile varchar(255),
    proimg varchar(255),
    email varchar(255) not null,
    password varchar(255) not null
);

create table messages(
    id int primary key not null auto_increment,
    username varchar(255),
    type enum('image', 'text') not null,
    message varchar(255),
    foreign key (username) references users(userName)
);

create table blockusers(
    username varchar(255) not null primary key
);