create table generateFaultyMaterialRequest(
    id int(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    siteid int(10),
    atmid varchar(30),
    requestBy int(6),
    requestByPortal varchar(20),
    requestFor int(10),
    requestForPortal varchar(30),
    materialRequestLevel int(6),
    description text,
    created_at datetime,
    created_by int(6),
    status boolean,
    ticketId varchar(30)
);

create table generateFaultyMaterialRequestDetails(
id int(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
requestId int(6),
MaterialID varchar(10),
MaterialName varchar(40),
MaterialSerialNumber varchar(40),
materialImage varchar(200),
created_at datetime,
created_by int(6),
status boolean
)