use real3;

-- dml
insert into users(user_id,user_name,password) values(100000, 'az','1234567');













insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10000, 'Tymofiyeva', 'Olga', '2167 Prospect Street', 'Vineland', 'NJ', 'United States', '08360','TOlga21@gmail.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10001, 'Wendi', 'Silvano', '384 Rose Avenue', 'Harahan', 'LA', 'United States','70123','WSilva@hotmail.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10002, 'Nita', 'Prose', '2516 John Daniel Drive', 'Jefferson City', 'MO', 'United States','65109','NProse@yahoo.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10003, 'Sabaa', 'Tahir', '105 Ocello Street', 'San Diego', 'CA', 'United States','92121','stahir0312@foxmail.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10004, 'Colleen', 'Hoover', '3691 Raccoon Run', 'Seattle', 'WA', 'United States','98109','cohov11@gmail.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10005, 'Quentin', 'Tarantino', '4172 Progress Way', 'Saint Cloud', 'MN', 'United States','56303','quentinta@foxmail.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10006, 'Robin', 'Muir', '1005 Clay Street', 'Indianapolis', 'IN','United States', '46219','robinmuir642@outlook.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10007, 'Robert', 'Greene', '2920 Cinnamon Lane', 'San Antonio', 'TX', 'United States','78218','robgreene8792@outlook.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10008, 'Daniel', 'Kahneman', '322 Polk Street', 'Sacramento', 'CA', 'United States','95814','dankahzz@gmail.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10009, 'Scott', 'Galloway', '2871 Round Table Drive', 'Cincinnati', 'OH', 'United States','45223','Scottgalloway1@yahoo.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10010, 'Ken', 'Burns', '4111 Walkers Ridge Way', 'West Chicago', 'IL', 'United States','60185','kenburns@gmail.com');
insert into authors (author_id, afname, alname, st_addr, city, state, country, zipcode, email_addr)
values (10011, 'Sam', 'Heughan', '349 Benedum Drive', 'Purdys', 'NY','United States', '10578','SHeughan77@outlook.com');
COMMIT;

insert into events (eid, e_name, e_type, st_date, ed_date)
values (100000, 'Magic Time', 'S', '2022-02-12', '2022-02-14'); -- exhibition is 'E', seminar is 'S'
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100001, 'Share the Vision', 'S', '2022-03-22', '2022-03-23');
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100002, 'Whither Dreams: Deconstructing Damage', 'E', '2022-04-10', '2022-04-13');
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100003, 'Relational Illusion: Media Art and Interactivity', 'E', '2022-05-23', '2022-05-26');
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100004, 'Innovation Integration', 'S', '2022-06-01', '2022-06-03');
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100005, 'Focus on Success', 'S', '2022-06-15', '2022-06-16');
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100006, 'Collective History: A Remix of Misfortune', 'E', '2022-07-03', '2022-07-06');
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100007, 'Make Up Our Mind', 'S', '2022-07-22', '2022-07-24');
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100008, 'Prism of Possibilities', 'S', '2022-08-10', '2022-08-12');
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100009, 'Postcolonial Ground: Media Art and Change', 'E', '2022-09-05', '2022-09-09');
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100010, 'Making a Difference', 'S', '2022-10-21', '2022-10-23');
insert into events (eid, e_name, e_type, st_date, ed_date)
values (100011, 'Mind Meld', 'S', '2022-11-02', '2022-11-04');
COMMIT;

insert into seminar (eid) values (100000);
insert into seminar (eid) values (100001);
insert into seminar (eid) values (100004);
insert into seminar (eid) values (100005);
insert into seminar (eid) values (100007);
insert into seminar (eid) values (100008);
insert into seminar (eid) values (100010);
insert into seminar (eid) values (100011);

COMMIT;

insert into sponsor (sid, s_fname, s_lname)
values (100000, 'Denver','Gonzales');
insert into sponsor (sid, s_fname, s_lname)
values (100001, 'Smith','Henderson');
insert into sponsor (sid, s_fname, s_lname)
values (100002, 'Mercedes', 'Olson');
insert into sponsor (sid, s_fname, s_lname)
values (100003, 'Amitabha', 'Anthony');
insert into sponsor (sid, s_fname, s_lname)
values (100004, 'Tasha', 'Wallace');
insert into sponsor (sid, s_fname, s_lname)
values (100005, 'Juan', 'Carter');
insert into sponsor (sid, s_fname, s_lname)
values (100006, 'Sienna', 'Ortiz');
insert into sponsor (sid, s_fname, s_lname)
values (100007, 'Mahadevi', 'Gade');
insert into sponsor (sid, s_fname, s_lname)
values (100008, 'Tan', 'Song');
insert into sponsor (sid, s_fname, s_lname)
values (100009, 'Dakini', 'Soman');
insert into sponsor (sid, s_fname, s_lname)
values (100010, 'Deng', 'Xue');
insert into sponsor (sid, s_fname, s_lname)
values (100011, 'Barbara', 'Wood');
COMMIT;

insert into sp_se (sid, eid, amount) values (100000,100000,1000000);
insert into sp_se (sid, eid, amount) values (100001,100000,200000);
insert into sp_se (sid, eid, amount) values (100002,100001,250000);
insert into sp_se (sid, eid, amount) values (100003,100001,3000000);
insert into sp_se (sid, eid, amount) values (100004,100004,1200000);
insert into sp_se (sid, eid, amount) values (100005,100005,100000);
insert into sp_se (sid, eid, amount) values (100006,100005,3200000);
insert into sp_se (sid, eid, amount) values (100007,100007,200000);
insert into sp_se (sid, eid, amount) values (100008,100007,430000);
insert into sp_se (sid, eid, amount) values (100009,100008,500000);
insert into sp_se (sid, eid, amount) values (100010,100010,1200000);
insert into sp_se (sid, eid, amount) values (100011,100011,2000000);

COMMIT;

insert into au_se (author_id, inv_id, eid) values (10000,100000, 100000);
insert into au_se (author_id, inv_id, eid) values (10001,100001, 100000);
insert into au_se (author_id, inv_id, eid) values (10002,100002, 100001);
insert into au_se (author_id, inv_id, eid) values (10003,100003, 100001);
insert into au_se (author_id, inv_id, eid) values (10004,100004, 100004);
insert into au_se (author_id, inv_id, eid) values (10005,100005, 100004);
insert into au_se (author_id, inv_id, eid) values (10006,100006, 100005);
insert into au_se (author_id, inv_id, eid) values (10007,100007, 100007);
insert into au_se (author_id, inv_id, eid) values (10008,100008, 100008);
insert into au_se (author_id, inv_id, eid) values (10009,100009, 100008);
insert into au_se (author_id, inv_id, eid) values (10010,100010, 100010);
insert into au_se (author_id, inv_id, eid) values (10011,100011, 100010);
insert into au_se (author_id, inv_id, eid) values (10000,100012, 100011);
insert into au_se (author_id, inv_id, eid) values (10003,100013, 100011);
insert into au_se (author_id, inv_id, eid) values (10005,100014, 100011);
COMMIT;

insert into books (isbn, b_name, topic) values (9798350701784, 'JUST CITY', 'children');
insert into books (isbn, b_name, topic) values (9780761455295, 'Turkey Trouble', 'children');
insert into books (isbn, b_name, topic) values (9780593356159, 'The Maid: A Novel', 'fiction');
insert into books (isbn, b_name, topic) values (9780593202340, 'All My Rage: A Novel', 'fiction');
insert into books (isbn, b_name, topic) values (9781538739723, 'Verity', 'children');
insert into books (isbn, b_name, topic) values (9780063112582, 'Cinema Speculation', 'arts');
insert into books (isbn, b_name, topic) values (9781667200484, 'The Crown in Vogue', 'arts');
insert into books (isbn, b_name, topic) values (9780140280197, 'The 48 Laws of Power', 'science');
insert into books (isbn, b_name, topic) values (9780374533557, 'Thinking, Fast and Slow', 'science');
insert into books (isbn, b_name, topic) values (9780593542408, 'Adrift: America in 100 Charts', 'history');
insert into books (isbn, b_name, topic) values (9780385353014, 'Our America: A Photographic History', 'history');
insert into books (isbn, b_name, topic) values (9780316495530, 'Waypoints: My Scottish Journey', 'travel');

COMMIT;

insert into author_book (author_id, isbn) values (10000, 9798350701784); 
insert into author_book (author_id, isbn) values (10001, 9780761455295); 
insert into author_book (author_id, isbn) values (10002, 9780593356159); 
insert into author_book (author_id, isbn) values (10003, 9780593202340);
insert into author_book (author_id, isbn) values (10004, 9781538739723);
insert into author_book (author_id, isbn) values (10005, 9780063112582); 
insert into author_book (author_id, isbn) values (10006, 9781667200484); 
insert into author_book (author_id, isbn) values (10007, 9780140280197); 
insert into author_book (author_id, isbn) values (10008, 9780374533557); 
insert into author_book (author_id, isbn) values (10009, 9780593542408); 
insert into author_book (author_id, isbn) values (10010, 9780385353014); 
insert into author_book (author_id, isbn) values (10011, 9780316495530); 

COMMIT;


insert into study_room (r_no, capacity)
values (11543, 3);
insert into study_room (r_no, capacity)
values (11544, 4);
insert into study_room (r_no, capacity)
values (11545, 3);
insert into study_room (r_no, capacity)
values (11546, 5);
insert into study_room (r_no, capacity)
values (11547, 2);
insert into study_room (r_no, capacity)
values (11548, 5);
insert into study_room (r_no, capacity)
values (11549, 3);
insert into study_room (r_no, capacity)
values (11550, 4);
insert into study_room (r_no, capacity)
values (11551, 5);
insert into study_room (r_no, capacity)
values (11552, 2);
insert into study_room (r_no, capacity)
values (11553, 3);
insert into study_room (r_no, capacity)
values (11554, 5);
COMMIT;

insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100000, 'Hanwen', 'Hu', 5102321345,'hhw12@gmail.com', 'S', '040073938'); -- 'S' means ssn, 'P' means passport, 'D' means driver license
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100001, 'Rishita', 'Gopal',3184387278, 'rishigop33@gmail.com', 'D', '232639536');
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100002, 'Liko', 'Watson', 5736732163,'likowat421@outlook.com', 'S', '503156504');
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100003, 'Xiaojian', 'Meng', 2029182132,'xjmeng@gmail.com', 'S', '060022123');
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100004, 'Adrian', 'Cook', 5052637630,'adrianc@yahoo.com', 'S', '409822271');
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100005, 'Damayanti', 'Kuruvilla', 5102321345,'damakuru989@foxmail.com', 'P', '923803997');
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100006, 'Alexis', 'Ferguson', 2837037241,'alexfergu142@hotmail.com', 'S', '525820203');
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100007, 'Jia', 'Lawrence', 5056447206,'jialawrzz@gmail.com', 'S', '430050980');
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100008, 'Samuel', 'Campbell', 2487180496,'samcampbell887@yahoo.com', 'D', '500110199');
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100009, 'Alicia', 'Griffin', 2065022848,'aliciagrin3232@gmail.com', 'D', '431418553');
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100010, 'Katie', 'Hudson', 3079745837,'katiehudson030@foxmail.com', 'P', '921747748');
insert into customer(cid, c_fname, c_lname, p_no, email, id_type, id_no)
values (100011, 'Meilin', 'Cui', 5058786459,'mlcui532@gmail.com', 'P', '880635280');
COMMIT;


insert into exhibition (eid, exp) values (100002, 1231231231); 
insert into exhibition (eid, exp) values (100003, 1231231232);
insert into exhibition (eid, exp) values (100006, 1231231233);
insert into exhibition (eid, exp) values (100009, 1231231234);
COMMIT;

insert into c_ex (reg_id, eid, cid) values (100000, 100002, 100000);
insert into c_ex (reg_id, eid, cid) values (100001, 100002, 100001);
insert into c_ex (reg_id, eid, cid) values (100002, 100002, 100002);
insert into c_ex (reg_id, eid, cid) values (100003, 100002, 100003);
insert into c_ex (reg_id, eid, cid) values (100004, 100003, 100004);
insert into c_ex (reg_id, eid, cid) values (100005, 100003, 100005);
insert into c_ex (reg_id, eid, cid) values (100006, 100003, 100006);
insert into c_ex (reg_id, eid, cid) values (100007, 100006, 100007);
insert into c_ex (reg_id, eid, cid) values (100008, 100006, 100008);
insert into c_ex (reg_id, eid, cid) values (100009, 100006, 100009);
insert into c_ex (reg_id, eid, cid) values (100010, 100006, 100010);
insert into c_ex (reg_id, eid, cid) values (100011, 100009, 100000);
insert into c_ex (reg_id, eid, cid) values (100012, 100009, 100001);
insert into c_ex (reg_id, eid, cid) values (100013, 100009, 100003);
insert into c_ex (reg_id, eid, cid) values (100014, 100009, 100006);
COMMIT;

insert into copies (copy_id, c_status,isbn) values (10000, 'Y',9798350701784);  -- 'Y' means available, 'N' means not avaliable
insert into copies (copy_id, c_status,isbn) values (10001, 'Y',9780761455295);
insert into copies (copy_id, c_status,isbn) values (10002, 'Y',9780593356159);
insert into copies (copy_id, c_status,isbn) values (10003, 'Y',9780593202340);
insert into copies (copy_id, c_status,isbn) values (10004, 'Y',9781538739723);
insert into copies (copy_id, c_status,isbn) values (10005, 'Y',9780063112582);
insert into copies (copy_id, c_status,isbn) values (10006, 'Y',9781667200484);
insert into copies (copy_id, c_status,isbn) values (10007, 'Y',9780140280197);
insert into copies (copy_id, c_status,isbn) values (10008, 'Y',9780374533557);
insert into copies (copy_id, c_status,isbn) values (10009, 'Y',9780593542408);
insert into copies (copy_id, c_status,isbn) values (10010, 'Y',9780385353014);
insert into copies (copy_id, c_status,isbn) values (10011, 'Y',9780316495530);
insert into copies (copy_id, c_status,isbn) values (10012, 'Y',9780316495530);
insert into copies (copy_id, c_status,isbn) values (10013, 'Y',9780063112582);
insert into copies (copy_id, c_status,isbn) values (10014, 'Y',9780593202340);
COMMIT;


