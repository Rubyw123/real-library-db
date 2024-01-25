use real3;

/*
	Trigger for generating a invoice when a book is returned.
*/
DROP TRIGGER IF EXISTS GENERATE_INVOICE;
DELIMITER \\
CREATE TRIGGER GENERATE_INVOICE BEFORE UPDATE ON rental FOR EACH ROW
BEGIN
	DECLARE Expense DECIMAL(5,2);

	IF NEW.act_return_date <=> OLD.act_return_date THEN
		
		IF NEW.rental_sta = 'R' THEN
			SET Expense = 0.2*datediff(NEW.act_return_date,NEW.borrow_date);
		ELSEIF NEW.rental_sta = 'L' THEN
			SET Expense = 0.2*datediff(NEW.exp_return_date,NEW.borrow_date) + 0.4*datediff(NEW.act_return_date,NEW.exp_return_date);
		END IF;
        
		INSERT invoice VALUES(CONCAT(NEW.ren_id,'-','233'),NEW.act_return_date,Expense,NEW.ren_id);

	END IF;

END \\
DELIMITER ;

/*
	Procedure for rent a copy
    @para isbn, borrow date, expected returndate, customer id
		
*/
DROP PROCEDURE IF EXISTS RENT_A_COPY;
DELIMITER \\
CREATE PROCEDURE RENT_A_COPY(IN in_isbn bigint,IN in_borrow_date DATE,IN in_exp_return_date DATE,IN in_cid INT)

BEGIN
	DECLARE V_ren_id VARCHAR(30);
	DECLARE V_copy_id bigint;    
  
	SELECT copy_id FROM copies WHERE isbn = in_isbn AND c_status = 'Y' LIMIT 1 INTO V_copy_id;
    
    IF in_exp_return_date <= in_borrow_date THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = "WARNING: Expected return date should be greater than borrow date!";
	END IF;
		
	IF V_copy_id is NULL THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = "WARNING: This book is not available now!";
	ELSE
		SET V_ren_id = CONCAT(DATE_FORMAT(in_borrow_date,"%Y%m%d"),'-',V_copy_id);
		INSERT rental VALUES(V_ren_id,'B',in_borrow_date,in_exp_return_date,NULL,in_cid,V_copy_id);
		UPDATE copies SET c_status = 'N' WHERE copy_id = V_copy_id;
	END IF;
        
END
\\
DELIMITER ;


/*
	Procedure of returning a copy
    @para rental id, actual return date
*/
DROP PROCEDURE IF EXISTS RETURN_A_COPY;
DELIMITER \\
CREATE PROCEDURE RETURN_A_COPY(IN in_ren_id VARCHAR(30),IN in_act_return_date DATE)
BEGIN
	DECLARE V_status CHAR(1);
	DECLARE V_ren_id VARCHAR(30);
	DECLARE V_borrow_date DATE;
	DECLARE V_exp_date DATE;
	DECLARE V_copy_id INT(11);
    DECLARE V_ren_sta CHAR(1);
        
	SELECT copy_id FROM rental WHERE ren_id = in_ren_id INTO V_copy_id;
	SELECT c_status FROM copies WHERE copy_ID = V_copy_ID INTO V_status;
	SELECT borrow_date FROM rental WHERE ren_id = in_ren_id INTO V_borrow_date;
	SELECT exp_return_date FROM rental WHERE ren_id = in_ren_id INTO V_exp_date;
    SELECT rental_sta INTO V_ren_sta FROM rental WhERE ren_id = in_ren_id;
    
		IF V_ren_sta = "R" OR V_ren_sta = "L" THEN
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = "Book has been returned!";
		ELSE
			IF date(V_borrow_date) >= in_act_return_date THEN
				SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = "Invalid Return Date";
			ELSEIF date(V_exp_date) >= in_act_return_date THEN
				UPDATE rental SET act_return_date = in_act_return_date WHERE ren_id = in_ren_id;
                UPDATE rental SET rental_sta = 'R' WHERE ren_id = in_ren_id;
				UPDATE copies SET c_status = "Y" WHERE copy_id = V_copy_id;
			
            ELSEIF date(V_exp_date) < in_act_return_date  THEN
				UPDATE rental SET act_return_date = in_act_return_date WHERE ren_id = in_ren_id;
                UPDATE rental SET rental_sta = 'L' WHERE ren_id = in_ren_id;
				UPDATE copies SET c_status = "Y" WHERE copy_id = V_copy_id;
			END IF;
			
		END IF;
       
    
    		
            
END
\\
DELIMITER ;

/*
	Procedure for reserving a room.
    @para customer id, reserve date, room #, timeslot
*/

DROP PROCEDURE IF EXISTS RESERVE_ROOM;
DELIMITER \\
CREATE PROCEDURE RESERVE_ROOM(IN in_cid INT,IN in_r_date DATE,IN in_r_no decimal(20,0),IN in_r_timeslot CHAR(1))
BEGIN
	DECLARE V_exist INT;
    SELECT COUNT(*) FROM cu_st WHERE r_no = in_r_no AND r_date = in_r_date AND r_timeslot = in_r_timeslot INTO V_exist;
    IF V_exist > 0 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = "The room has been reserved at that time";
	ELSE
		SELECT COUNT(*) FROM cu_st WHERE cid = in_cid AND r_date = in_r_date AND r_timeslot = in_r_timeslot INTO V_exist;
        IF V_exist > 0 THEN
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = "You have reserved a room at that time";
		ELSE
			INSERT INTO cu_st VALUES(in_r_no,in_cid,in_r_date,in_r_timeslot);
		END IF;
	END IF;
END
\\
DELIMITER ;
