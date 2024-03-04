CREATE TABLE nguoidung(
    id int AUTO_INCREMENT PRIMARY KEY,
    tendangnhap varchar(50),
    hoten varchar(50),
    matkhau varchar(50),
    email varchar(50),
    sodienthoai varchar(50),
    role varchar(50),
    Image varchar(100)
);

INSERT INTO nguoidung(tendangnhap,hoten,matkhau,email,sodienthoai,role) VALUES ('hvt','Hoang Van Thai','hvt','hvt@gmail.com','0879102003','sinhvien'),
('student1','Hoang Van Thai','123456a@A','student1@gmail.com','0123456789','sinhvien'),
('student2','Le Duc Anh','123456a@A','student2@gmail.com','0123456789','sinhvien'),
('teacher1','Nguyen Van A','123456a@A','teacher1@gmail.com','0123456789','giaovien'),
('teacher2','Nguyen Van B','123456a@A','teacher2@gmail.com','0123456789','giaovien');

create table tinnhan(
receiver_id int,
sender_id int,
msg text,
primary key(receiver_id,sender_id),
foreign key(receiver_id) references nguoidung(id),
foreign key(sender_id) references nguoidung(id)
);

create table baitap(
task_id int auto_increment,
filename varchar(50),
primary key(task_id)
);

create table bailam(
solve_id int AUTO_INCREMENT,
task_id int,
student_id int,
filename varchar(50),
primary key(solve_id),
foreign key(task_id) references baitap(task_id),
foreign key(student_id) references nguoidung(id)
);

create table challenge(
cid int AUTO_INCREMENT,
cname varchar(50),
hint text,
primary key (cid)
);
