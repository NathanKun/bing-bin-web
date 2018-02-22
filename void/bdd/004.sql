alter table Users add id_usagi int;
alter table Users add id_leaf int;

alter table Users add sun_point int;


create table Sun_Historiques(
    id varchar(50),
    id_sending_user varchar(50),
    id_receiver_user varchar(50),
    sending_date int,
    constraint sunhistoriques_primary primary key(id),
    constraint sunhistoriques_user_send foreign key(id_sending_user) references Users(id),
    constraint sunhistoriques_user_receive foreign key(id_receiver_user) references Users(id)
);