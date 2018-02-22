alter table Users add id_usagi int;
alter table Users add id_leaf int;

alter table Users add sun_point int;

ALTER TABLE `Users` CHANGE `eco_point` `eco_point` INT(11) NULL DEFAULT '0';
ALTER TABLE `Users` CHANGE `sun_point` `sun_point` INT(11) NULL DEFAULT '0';
ALTER TABLE `Users` CHANGE `id_usagi` `id_usagi` INT(11) NULL DEFAULT '1';
ALTER TABLE `Users` CHANGE `id_leaf` `id_leaf` INT(11) NULL DEFAULT '1';

create table Sun_Historiques(
    id varchar(50),
    id_sending_user varchar(50),
    id_receiver_user varchar(50),
    sending_date int,
    constraint sunhistoriques_primary primary key(id),
    constraint sunhistoriques_user_send foreign key(id_sending_user) references Users(id),
    constraint sunhistoriques_user_receive foreign key(id_receiver_user) references Users(id)
);