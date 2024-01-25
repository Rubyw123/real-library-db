use real3;


ALTER TABLE customer
	-- 'P' for passport, 'S' for SSN and 'D' for driver license
    ADD CONSTRAINT ch_id_type CHECK ( id_type IN ( 'P', 'S','D' ) );
    

ALTER TABLE copies
	-- 'A' for available and 'N' for not available
    ADD CONSTRAINT ch_c_sta CHECK ( c_status IN ( 'Y', 'N' ) );
    
ALTER TABLE rental
	-- 'B' for borrowed, 'R' for returned and 'L' for late
    ADD CONSTRAINT ch_ren_sta CHECK ( rental_sta IN ( 'B', 'R' ,'L') );

ALTER TABLE cu_st
	-- 'A' for 8am to 10am, 'B' for 11am to 1pm, 'C' for 1pm to 3pm
    -- and 'D' for 4pm to 6pm
    ADD CONSTRAINT ch_t_slot CHECK( r_timeslot IN ('A','B','C','D'));
    
ALTER TABLE study_room
    ADD CONSTRAINT ch_cap CHECK( capacity <= 5);