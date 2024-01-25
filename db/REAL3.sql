DROP DATABASE real3;
CREATE DATABASE real3;
use real3;

CREATE TABLE users(
	user_id BIGINT(20) NOT NULL COMMENT 'Id of user',
    user_name VARCHAR(100) NOT NULL COMMENT 'User name for login',
    password VARCHAR(100) NOT NULL COMMENT 'PW of user',
    user_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE users ADD CONSTRAINT users_pk PRIMARY KEY(user_id);
ALTER TABLE users CHANGE user_id user_id BIGINT(20) NOT NULL auto_increment;

CREATE TABLE au_se (
    author_id INT NOT NULL COMMENT 'Invitation ID of seminar',
    inv_id    INT NOT NULL,
    eid       INT NOT NULL
);


ALTER TABLE au_se ADD CONSTRAINT au_se_pk PRIMARY KEY ( inv_id );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE author_book (
    author_id INT NOT NULL,
    isbn      BIGINT NOT NULL
);

ALTER TABLE author_book ADD CONSTRAINT author_book_pk PRIMARY KEY ( author_id,
                                                                    isbn );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE authors (
    author_id  INT NOT NULL COMMENT 'ID of author',
    afname     VARCHAR(30) NOT NULL COMMENT 'First name of author',
    alname     VARCHAR(30) NOT NULL COMMENT 'Last name of author',
    st_addr    VARCHAR(30) NOT NULL COMMENT 'Street address of author',
    city       VARCHAR(30) NOT NULL COMMENT 'City',
    state      VARCHAR(30) NOT NULL COMMENT 'State',
    country    VARCHAR(30) NOT NULL COMMENT 'Country',
    zipcode    VARCHAR(12) NOT NULL COMMENT 'zipcode',
    email_addr VARCHAR(50) NOT NULL COMMENT 'Email address of author'
);


ALTER TABLE authors ADD CONSTRAINT authors_pk PRIMARY KEY ( author_id );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE books (
    isbn   BIGINT NOT NULL COMMENT 'ISBN of book',
    b_name VARCHAR(50) NOT NULL COMMENT 'Name of book',
    topic  VARCHAR(30) NOT NULL COMMENT 'Topic of book'
);


ALTER TABLE books ADD CONSTRAINT books_pk PRIMARY KEY ( isbn );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE c_ex (
    reg_id INT NOT NULL COMMENT 'Registration ID of event for customer',
    eid    INT NOT NULL,
    cid    INT NOT NULL
);


ALTER TABLE c_ex ADD CONSTRAINT c_ex_pk PRIMARY KEY ( reg_id );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE copies (
    copy_id  INT NOT NULL COMMENT 'ID of copy',
    c_status CHAR(1) NOT NULL COMMENT 'Status of copy',
    isbn     BIGINT NOT NULL
);


ALTER TABLE copies ADD CONSTRAINT copies_pk PRIMARY KEY ( copy_id );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE cu_st (
    r_no DECIMAL(20) NOT NULL,
    cid  INT NOT NULL,
    r_date DATE NOT NULL,
    r_timeslot CHAR(1) NOT NULL
);

ALTER TABLE cu_st ADD CONSTRAINT cu_st_pk PRIMARY KEY ( cid,
                                                        r_no,
                                                        r_date,
                                                        r_timeslot);

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE customer (
    cid     INT NOT NULL COMMENT 'ID of customer',
    c_fname VARCHAR(20) NOT NULL COMMENT 'First name of customer',
    c_lname VARCHAR(20) NOT NULL COMMENT 'Last  name of customer',
    p_no    BIGINT NOT NULL COMMENT 'Phone# of customer',
    email   VARCHAR(50) NOT NULL COMMENT 'Email address of customer',
    id_type CHAR(1) NOT NULL COMMENT 'Type of ID the customer is using',
    id_no   VARCHAR(30) NOT NULL COMMENT 'ID # of customer'
);


ALTER TABLE customer ADD CONSTRAINT customer_pk PRIMARY KEY ( cid );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE events (
    eid     INT NOT NULL COMMENT 'ID of event',
    e_name  VARCHAR(100) NOT NULL COMMENT 'Event name',
    e_type  CHAR(1) NOT NULL COMMENT 'Event type',
    st_date DATETIME NOT NULL COMMENT 'Start date of event',
    ed_date DATETIME NOT NULL COMMENT 'End date of event'
);

ALTER TABLE events
    ADD CONSTRAINT ch_inh_events CHECK ( e_type IN ( 'E', 'S' ) );


ALTER TABLE events ADD CONSTRAINT events_pk PRIMARY KEY ( eid );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE exhibition (
    eid INT NOT NULL COMMENT 'ID of event',
    exp DECIMAL(20) NOT NULL COMMENT 'Exhibition expenses'
);

ALTER TABLE exhibition ADD CONSTRAINT exhibition_pk PRIMARY KEY ( eid );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE invoice (
    invoice_id   VARCHAR(30) NOT NULL COMMENT 'ID of invoice',
    invoice_date DATETIME NOT NULL COMMENT 'Date of invoice',
    invoice_amt  DECIMAL(5, 2) NOT NULL,
    ren_id       VARCHAR(30) NOT NULL
);


-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE UNIQUE INDEX invoice__idx ON
    invoice (
        ren_id
    ASC );

ALTER TABLE invoice ADD CONSTRAINT invoice_pk PRIMARY KEY ( invoice_id );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE payment (
    p_no       DECIMAL(20) NOT NULL COMMENT 'Payment#',
    p_date     DATETIME NOT NULL COMMENT 'Date of payment',
    p_amt      DECIMAL(20,2) NOT NULL COMMENT 'Payment amount',
    ch_fname   VARCHAR(30) NOT NULL COMMENT 'Card holder first name',
    ch_lname   VARCHAR(30) NOT NULL COMMENT 'Card holder last name',
    p_method   VARCHAR(30) NOT NULL COMMENT 'Payment method',
    inst_no    VARCHAR(15) COMMENT 'Instrument #, null if cash',
    invoice_id VARCHAR(30) NOT NULL
);

ALTER TABLE payment ADD CONSTRAINT payment_pk PRIMARY KEY ( p_no );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE rental (
    ren_id          VARCHAR(30) NOT NULL COMMENT 'ID of rental',
    rental_sta      CHAR(1) NOT NULL COMMENT 'Status of rental',
    borrow_date     DATETIME NOT NULL COMMENT 'Borrow date of rental',
    exp_return_date DATETIME NOT NULL COMMENT 'Expected return date of rental',
    act_return_date DATETIME COMMENT 'Actual return dated of rental',
    cid             INT NOT NULL,
    copy_id         INT NOT NULL
);

ALTER TABLE rental ADD CONSTRAINT rental_pk PRIMARY KEY ( ren_id );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE seminar (
    eid INT NOT NULL COMMENT 'ID of event'
);

ALTER TABLE seminar ADD CONSTRAINT seminar_pk PRIMARY KEY ( eid );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE sp_se (
    sid    INT NOT NULL,
    eid    INT NOT NULL,
    amount DECIMAL(20) NOT NULL COMMENT 'The amount sponsored'
);


ALTER TABLE sp_se ADD CONSTRAINT sp_se_pk PRIMARY KEY ( sid );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE sponsor (
    sid     INT NOT NULL COMMENT 'ID of sponsor',
    s_fname VARCHAR(50) NOT NULL COMMENT 'First name of Sponso. Type full name if organization.',
    s_lname VARCHAR(50) COMMENT 'Last name of sponsor. Leave null if organizaiton'
);


ALTER TABLE sponsor ADD CONSTRAINT sponsor_pk PRIMARY KEY ( sid );

-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE study_room (
    r_no       DECIMAL(20) NOT NULL COMMENT 'Room # of study room',
    capacity   SMALLINT NOT NULL COMMENT 'Capacity of study room'
);


ALTER TABLE study_room ADD CONSTRAINT study_room_pk PRIMARY KEY ( r_no );

ALTER TABLE au_se
    ADD CONSTRAINT au_se_authors_fk FOREIGN KEY ( author_id )
        REFERENCES authors ( author_id );

ALTER TABLE au_se
    ADD CONSTRAINT au_se_seminar_fk FOREIGN KEY ( eid )
        REFERENCES seminar ( eid );

ALTER TABLE author_book
    ADD CONSTRAINT author_book_authors_fk FOREIGN KEY ( author_id )
        REFERENCES authors ( author_id );

ALTER TABLE author_book
    ADD CONSTRAINT author_book_books_fk FOREIGN KEY ( isbn )
        REFERENCES books ( isbn );

ALTER TABLE c_ex
    ADD CONSTRAINT c_ex_customer_fk FOREIGN KEY ( cid )
        REFERENCES customer ( cid );

ALTER TABLE c_ex
    ADD CONSTRAINT c_ex_exhibition_fk FOREIGN KEY ( eid )
        REFERENCES exhibition ( eid );

ALTER TABLE copies
    ADD CONSTRAINT copies_books_fk FOREIGN KEY ( isbn )
        REFERENCES books ( isbn );

ALTER TABLE cu_st
    ADD CONSTRAINT cu_st_customer_fk FOREIGN KEY ( cid )
        REFERENCES customer ( cid );

ALTER TABLE cu_st
    ADD CONSTRAINT cu_st_study_room_fk FOREIGN KEY ( r_no )
        REFERENCES study_room ( r_no );

ALTER TABLE exhibition
    ADD CONSTRAINT exhibition_events_fk FOREIGN KEY ( eid )
        REFERENCES events ( eid );

ALTER TABLE invoice
    ADD CONSTRAINT invoice_rental_fk FOREIGN KEY ( ren_id )
        REFERENCES rental ( ren_id );

ALTER TABLE payment
    ADD CONSTRAINT payment_invoice_fk FOREIGN KEY ( invoice_id )
        REFERENCES invoice ( invoice_id );

ALTER TABLE rental
    ADD CONSTRAINT rental_copies_fk FOREIGN KEY ( copy_id )
        REFERENCES copies ( copy_id );

ALTER TABLE rental
    ADD CONSTRAINT rental_customer_fk FOREIGN KEY ( cid )
        REFERENCES customer ( cid );

ALTER TABLE seminar
    ADD CONSTRAINT seminar_events_fk FOREIGN KEY ( eid )
        REFERENCES events ( eid );

ALTER TABLE sp_se
    ADD CONSTRAINT sp_se_seminar_fk FOREIGN KEY ( eid )
        REFERENCES seminar ( eid );

ALTER TABLE sp_se
    ADD CONSTRAINT sp_se_sponsor_fk FOREIGN KEY ( sid )
        REFERENCES sponsor ( sid );
        
/*
FOR ORACLE AUTO TRIGGERS ON SUBTYPES
*/
DROP TRIGGER IF EXISTS arc_fkarc_1_seminar;

DELIMITER \\

CREATE TRIGGER arc_fkarc_1_seminar BEFORE
    INSERT ON seminar
    FOR EACH ROW
BEGIN
    DECLARE d CHAR(1);
    DECLARE EXIT HANDLER FOR not found
		BEGIN
        
		END;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
		BEGIN
			RESIGNAL;
		END;
    
    -- SQLINES LICENSE FOR EVALUATION USE ONLY
    SELECT
        a.e_type
    INTO d
    FROM
        events a
    WHERE
        a.eid = new.eid;

    IF ( d IS NULL OR d <> 'S' ) THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'FK SEMINAR_EVENTS_FK in Table SEMINAR violates Arc constraint on Table EVENTS - discriminator column E_TYPE doesn''t have value ''S''';
    END IF;
    
END\\
DELIMITER ;

DROP TRIGGER IF EXISTS arc_fkarc_2_seminar;

DELIMITER \\

CREATE TRIGGER arc_fkarc_2_seminar BEFORE
    UPDATE ON seminar
    FOR EACH ROW
BEGIN
    DECLARE d CHAR(1);
    DECLARE EXIT HANDLER FOR not found
		BEGIN
        
		END;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
		BEGIN
			RESIGNAL;
		END;
    
    -- SQLINES LICENSE FOR EVALUATION USE ONLY
    SELECT
        a.e_type
    INTO d
    FROM
        events a
    WHERE
        a.eid = new.eid;

    IF ( d IS NULL OR d <> 'S' ) THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'FK SEMINAR_EVENTS_FK in Table SEMINAR violates Arc constraint on Table EVENTS - discriminator column E_TYPE doesn''t have value ''S''';
    END IF;
    
END\\
DELIMITER ;


DROP TRIGGER IF EXISTS arc_fkarc_1_exhibition;

DELIMITER \\

CREATE TRIGGER arc_fkarc_1_exhibition BEFORE
    INSERT ON exhibition
    FOR EACH ROW
BEGIN
    DECLARE d CHAR(1);
    DECLARE EXIT HANDLER FOR not found
		BEGIN
        
		END;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
		BEGIN
			RESIGNAL;
		END;
    
    -- SQLINES LICENSE FOR EVALUATION USE ONLY
    SELECT
        a.e_type
    INTO d
    FROM
        events a
    WHERE
        a.eid = new.eid;

    IF ( d IS NULL OR d <> 'E' ) THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'FK EXHIBITION_EVENTS_FK in Table EXHIBITION violates Arc constraint on Table EVENTS - discriminator column E_TYPE doesn''t have value ''E''';
    END IF;
    
END\\
DELIMITER ;

DROP TRIGGER IF EXISTS arc_fkarc_2_exhibition;

DELIMITER \\

CREATE TRIGGER arc_fkarc_2_exhibition BEFORE
    UPDATE ON exhibition
    FOR EACH ROW
BEGIN
    DECLARE d CHAR(1);
    DECLARE EXIT HANDLER FOR not found
		BEGIN
        
		END;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
		BEGIN
			RESIGNAL;
		END;
    
    -- SQLINES LICENSE FOR EVALUATION USE ONLY
    SELECT
        a.e_type
    INTO d
    FROM
        events a
    WHERE
        a.eid = new.eid;

    IF ( d IS NULL OR d <> 'E' ) THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'FK EXHIBITION_EVENTS_FK in Table EXHIBITION violates Arc constraint on Table EVENTS - discriminator column E_TYPE doesn''t have value ''E''';
    END IF;
    
END\\
DELIMITER ;