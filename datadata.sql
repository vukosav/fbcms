-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2019 at 11:19 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datadata`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `ArchivePost`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ArchivePost` (`p_post_id` INT, `p_user_id` INT)  BEGIN

DECLARE p_role INT;
declare user_creator int; 
SELECT roleId into p_role FROM users WHERE id = p_user_id;
SELECT created_by into user_creator FROM posts  WHERE id = p_post_id;

if(user_creator <> p_user_id and p_role <> 1) then
   set p_role = 0;
 ELSEIF (CanArchive(p_post_id) = 1) then 
		 INSERT INTO datadata.posts_pages_archive
		(id,postId,pageId,postingStatus,dateCreated,dateUpdate,datePublishedFB,job_id,job_action,job_errors,fbPostId)
		 SELECT id,postId,pageId,postingStatus,dateCreated,dateUpdate,datePublishedFB,job_id,job_action,job_errors,fbPostId
		  FROM datadata.posts_pages
		  where  posts_pages.postId = p_post_id;
		delete from posts_pages where postId = p_post_id;

		INSERT INTO posts_archive
		(id, title, content, created_by, created_date, PostStatus, ActionStatus, IsActive, isScheduled, post_type, scheduledTime)
		SELECT id,  title, content, created_by,created_date,PostStatus, ActionStatus, IsActive,isScheduled, post_type,scheduledTime
		FROM datadata.posts
        where id = p_post_id;
		delete from posts where id = p_post_id;
 else
   set p_role = 0;
end if;

	
										  
END$$

DROP PROCEDURE IF EXISTS `CancelEdit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CancelEdit` (`p_post_id` INT, `p_user_id` INT)  BEGIN



#declare v_job_id int;
#INSERT INTO  jobs_thread(last_action_time) VALUES (NOW());
#SET v_job_id = LAST_INSERT_ID();
	
# ------------Q-P-NS-1 -> Q-NS-1 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.PostStatus = 2,   # 2 Qwaiting
P.ActionStatus = NULL,
PS.postingStatus = 1,   # 2  Not started
    PS.job_id = null	
WHERE PS.postId = p_post_id
   AND JT.post_id_owner = p_post_id
   AND JT.user_id_owner = p_user_id
   AND JT.cron_job_id_owner is NULL
   #and JT.active = 1
	AND P.PostStatus = 2        # Q
	AND P.ActionStatus = 2      # P
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 1;		

# ------------Q-P-NS-2 -> Q-NS-2 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.PostStatus = 2,   # 2 Qwaiting
P.ActionStatus = NULL,
PS.postingStatus = 1,   # 2  Not started
    PS.job_id = null	
WHERE PS.postId = p_post_id
   AND JT.post_id_owner = p_post_id
   AND JT.user_id_owner = p_user_id
   AND JT.cron_job_id_owner is NULL
  # and JT.active = 1
	AND P.PostStatus = 2        # Q
	AND P.ActionStatus = 2      # P
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 2;	
		
	
	
	
	
	
	
	
#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
	
		

UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.PostStatus = 2,   # 2 Qwaiting
P.ActionStatus = NULL,
    PS.job_id = null	
WHERE PS.postId = p_post_id
   AND JT.post_id_owner = p_post_id
   AND JT.user_id_owner = p_user_id
   AND JT.cron_job_id_owner is NULL
   #and JT.active = 1
	AND P.PostStatus = 3        # QInProgres
	AND P.ActionStatus = 2      # P
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 1;		


UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.PostStatus = 2,   # 2 Qwaiting
P.ActionStatus = NULL,
    PS.job_id = null	
WHERE PS.postId = p_post_id
   AND JT.post_id_owner = p_post_id
   AND JT.user_id_owner = p_user_id
   AND JT.cron_job_id_owner is NULL
   #and JT.active = 1
	AND P.PostStatus = 3        # QInProgres
	AND P.ActionStatus = 2      # P
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 2;		
	
	
										  
END$$

DROP PROCEDURE IF EXISTS `CleanForTest`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CleanForTest` ()  begin
delete from posts_pages;
delete from page_by_hand_in_post;
delete FROM groups_in_post;
 delete from post_attachments;
 delete from posts;

delete from cron_jobs;
delete from task_to_finish;
delete from jobs_thread;


delete from posts_pages_archive;
 delete from posts_archive;
END$$

DROP PROCEDURE IF EXISTS `CroneJobFinish`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CroneJobFinish` (`p_crone_job_id` INT, `p_cron_job_errors` TEXT, `p_finish_stats` INT)  BEGIN

 UPDATE  cron_jobs
 SET cron_job_END = NOW(),
 finish_status = p_finish_stats,
 cron_job_errors = p_cron_job_errors
 #cron_job_status = 
 WHERE  id = p_crone_job_id;


END$$

DROP PROCEDURE IF EXISTS `GetFromTaskToFinish`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetFromTaskToFinish` (`cron_job_id` INT)  BEGIN

UPDATE jobs_thread
SET cron_job_id_owner = 	cron_job_id
WHERE post_id_owner IS NULL AND user_id_owner IS NULL		
AND  job_id IN (
                SELECT job_id 
                FROM  task_to_finish 
					 WHERE fb_valid_queue_id(queue_id) AND active = 1
					 );
#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN task_to_finish TF ON TF.queue_id = PS.id 
JOIN jobs_thread JT ON TF.job_id = JT.job_id
SET P.PostStatus = 3,
P.ActionStatus = 1,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 1
WHERE JT.cron_job_id_owner = cron_job_id
	AND TF.task_end_status = 'i-o-i-1'
	AND TF.active = 1
    AND P.IsActive = 1;
	
UPDATE posts_pages AS PS JOIN posts P ON PS.postId = P.id JOIN task_to_finish TF ON TF.queue_id = PS.id JOIN jobs_thread JT ON TF.job_id = JT.job_id
SET P.PostStatus = 3,
P.ActionStatus = 1,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 2
WHERE JT.cron_job_id_owner = cron_job_id
	AND TF.task_end_status = 'i-o-i-2'
	AND TF.active = 1
    AND P.IsActive = 1;		
	
UPDATE posts_pages AS PS JOIN posts P ON PS.postId = P.id JOIN task_to_finish TF ON TF.queue_id = PS.id JOIN jobs_thread JT ON TF.job_id = JT.job_id
SET P.PostStatus = 3,
P.ActionStatus = 1,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 3
WHERE JT.cron_job_id_owner = cron_job_id
	AND TF.task_end_status = 'i-o-i-3'
	AND TF.active = 1
    AND P.IsActive = 1;										  








UPDATE posts_pages AS PS JOIN posts P ON PS.postId = P.id JOIN task_to_finish TF ON TF.queue_id = PS.id JOIN jobs_thread JT ON TF.job_id = JT.job_id
SET P.PostStatus = 2,
P.ActionStatus = null,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 1
WHERE JT.cron_job_id_owner = cron_job_id
	AND TF.task_end_status = 'q-ns-1'
	AND TF.active = 1
    AND P.IsActive = 1;		
    
    
    
UPDATE posts_pages AS PS JOIN posts P ON PS.postId = P.id JOIN task_to_finish TF ON TF.queue_id = PS.id JOIN jobs_thread JT ON TF.job_id = JT.job_id
SET P.PostStatus = 2,
P.ActionStatus = null,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 2
WHERE JT.cron_job_id_owner = cron_job_id
	AND TF.task_end_status = 'q-ns-2'
	AND TF.active = 1
    AND P.IsActive = 1;	
    
    
    
UPDATE posts_pages AS PS JOIN posts P ON PS.postId = P.id JOIN task_to_finish TF ON TF.queue_id = PS.id JOIN jobs_thread JT ON TF.job_id = JT.job_id
SET P.PostStatus = 2,
P.ActionStatus = null,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 3
WHERE JT.cron_job_id_owner = cron_job_id
	AND TF.task_end_status = 'q-ns-3'
	AND TF.active = 1
    AND P.IsActive = 1;		




UPDATE posts_pages AS PS JOIN posts P ON PS.postId = P.id JOIN task_to_finish TF ON TF.queue_id = PS.id JOIN jobs_thread JT ON TF.job_id = JT.job_id
SET P.PostStatus = 3,
P.ActionStatus = 1,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 1
WHERE JT.cron_job_id_owner = cron_job_id
	AND TF.task_end_status = 'i-o-ns-1'
	AND TF.active = 1
    AND P.IsActive = 1;		
    
    
    
UPDATE posts_pages AS PS JOIN posts P ON PS.postId = P.id JOIN task_to_finish TF ON TF.queue_id = PS.id JOIN jobs_thread JT ON TF.job_id = JT.job_id
SET P.PostStatus = 3,
P.ActionStatus = 1,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 2
WHERE JT.cron_job_id_owner = cron_job_id
	AND TF.task_end_status = 'i-o-ns-2'
	AND TF.active = 1
    AND P.IsActive = 1;		
    
    
    
UPDATE posts_pages AS PS JOIN posts P ON PS.postId = P.id JOIN task_to_finish TF ON TF.queue_id = PS.id JOIN jobs_thread JT ON TF.job_id = JT.job_id
SET P.PostStatus = 3,
P.ActionStatus = 1,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 3
WHERE JT.cron_job_id_owner = cron_job_id
	AND TF.task_end_status = 'i-o-ns-3'
	AND TF.active = 1
    AND P.IsActive = 1;		















UPDATE   task_to_finish TF  
JOIN jobs_thread JT ON TF.job_id = JT.job_id
SET  TF.active = 0
WHERE JT.cron_job_id_owner = cron_job_id;
 END$$

DROP PROCEDURE IF EXISTS `NewCroneJob`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `NewCroneJob` (OUT `cr_job_id` INT)  BEGIN
 
INSERT INTO cron_jobs (cron_job_status, cron_job_START) VALUES (1, NOW());
SET cr_job_id = LAST_INSERT_ID();

CALL GetFromTaskToFinish(cr_job_id);
CALL SetCronJobForPaused(cr_job_id);
CALL SetCronJobAsOwner(cr_job_id);
CALL NewThreadJob(cr_job_id);
								  
END$$

DROP PROCEDURE IF EXISTS `NewThreadJob`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `NewThreadJob` (`cr_job_id` INT)  BEGIN
DECLARE new_job_id INT;
INSERT INTO jobs_thread (cron_job_id,cron_job_id_owner) VALUES (cr_job_id,cr_job_id);
SET new_job_id = LAST_INSERT_ID();



#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
SET 
P.PostStatus = 3,
P.ActionStatus = 1,
P.IsActive = 1,
PS.postingStatus = 1,
PS.job_id = new_job_id
WHERE PS.job_id is NULL
   AND P.PostStatus = 2
	AND P.ActionStatus is NULL
	AND PS.postingStatus = 1;
#--	AND PS.job_action = 1;


	
										  
END$$

DROP PROCEDURE IF EXISTS `OnGoing`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `OnGoing` (`p_queue_id` INT, `crone_job_id` INT, `thread_job_id` INT)  BEGIN

 
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
join jobs_thread JT on JT.job_id = PS.job_id and JT.cron_job_id_owner = crone_job_id
SET  
P.ActionStatus = 1,   #OnGoing
P.PostStatus = 3, #InProgress
PS.postingStatus = 2 #InProgress
WHERE PS.id = p_queue_id 
and PS.job_id = thread_job_id
and P.IsActive = 1;
#and JT.cron_job_id_owner = crone_job_id;
END$$

DROP PROCEDURE IF EXISTS `pHalt`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pHalt` (`p_post_id` INT, `p_user_id` INT)  BEGIN
declare v_job_id int;
INSERT INTO  jobs_thread(last_action_time, user_id_owner) VALUES (NOW() , p_user_id);
SET v_job_id = LAST_INSERT_ID();
#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
# ------------Q-NS-1 -> Q-P-NS-1 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.ActionStatus = 2,   # 2 Paused
PS.job_id = v_job_id
#JT.cron_job_id_owner = NULL,
#JT.post_id_owner = NULL,
#JT.user_id_owner = p_user_id 
WHERE PS.postId = p_post_id
   AND JT.post_id_owner is NULL
   AND  JT.user_id_owner is NULL
	AND P.PostStatus = 2        # Q
	AND P.ActionStatus = NULL      #
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 1
    and P.IsActive=1;		

	
# ------------Q-NS-2 -> Q-P-NS-2 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.ActionStatus = 2,   # 2 Paused
PS.job_id = v_job_id
#JT.cron_job_id_owner = NULL,
#JT.post_id_owner = NULL ,
#JT.user_id_owner = p_user_id 
WHERE PS.postId = p_post_id
   AND JT.post_id_owner is NULL
   AND  JT.user_id_owner is NULL
	AND P.PostStatus = 2        # Q
	AND P.ActionStatus = NULL      #
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 2
    and P.IsActive=1;	
	
	
#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 	
# ------------I-O-NS-1 -> I-P-N-1 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.ActionStatus = 2,   # 2 Paused
PS.job_id = v_job_id
#JT.cron_job_id_owner = NULL,
#JT.post_id_owner = NULL,
#JT.user_id_owner = p_user_id 
WHERE PS.postId = p_post_id
   AND JT.post_id_owner is NULL
   AND  JT.user_id_owner is NULL
	AND P.PostStatus = 3        # QInProgres
	AND P.ActionStatus = 1      # Ongoing
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 1
	and P.IsActive=1;	
# ------------I-O-NS-2 -> I-P-N-2 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.ActionStatus = 2,   # 2 Paused
PS.job_id = v_job_id
#JT.cron_job_id_owner = NULL,
#JT.post_id_owner = NULL,
#JT.user_id_owner = p_user_id 
WHERE PS.postId = p_post_id
   AND JT.post_id_owner is NULL
   AND  JT.user_id_owner is NULL
	AND P.PostStatus = 3        # QInProgres
	AND P.ActionStatus = 1      # Ongoing
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 2
    and P.IsActive=1;			
	
	update 	task_to_finish 
    join posts_pages on  task_to_finish.queue_id = posts_pages.id
    set task_to_finish.active = -1
    where posts_pages.job_id =v_job_id;
END$$

DROP PROCEDURE IF EXISTS `PostEdit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PostEdit` (`p_post_id` INT, `p_user_id` INT)  BEGIN


#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
# ------------S-N-FS-1/2 -> Q-NS-2 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
SET  
 PS.postingStatus = 1 ,
    PS.job_id = NULL,
    PS.job_action = 2
WHERE PS.postId = p_post_id
  and P.IsActive = 1
	AND PS.postingStatus = 3;     

# ------------Q-P-NS-1/2 : I-P-N-1/2-> Q-NS-1 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
SET  PS.postingStatus = 1 ,
    PS.job_id = NULL
WHERE PS.postId = p_post_id
and P.IsActive = 1
	AND ( P.PostStatus = 2 or P.PostStatus = 3 )      # Q
	AND P.ActionStatus = 2      # P
	AND PS.postingStatus = 1;    # NS



UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id  
SET   
    PS.job_id = NULL 
WHERE PS.postId = p_post_id 
and P.IsActive = 1
	AND P.PostStatus = 2        # Qwaiting
	AND P.ActionStatus  is null 
	AND PS.postingStatus = 1;    # NS
 
 
    
    
      update posts
      set PostStatus = 2,    
	   ActionStatus = NULL
       where id = p_post_id and PostStatus <> 1;
	
       
       
       
       
       
#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
		
INSERT INTO task_to_finish(job_id, task_end_status, queue_id, active) 
SELECT PS.job_id, 'q-ns-2', PS.id, 1
FROM posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
WHERE PS.postId = p_post_id
   AND JT.post_id_owner = p_post_id
   AND JT.user_id_owner = p_user_id
   AND JT.cron_job_id_owner is NULL
	AND P.PostStatus = 3        # QInProgres
	AND P.ActionStatus = 1      # Ongoing
	AND PS.postingStatus = 2    # In progres
	AND (PS.job_action = 1 OR PS.job_action = 2);			
										  
END$$

DROP PROCEDURE IF EXISTS `PreEdit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PreEdit` (`p_post_id` INT, `p_user_id` INT)  BEGIN

declare v_job_id int;
INSERT INTO  jobs_thread(last_action_time, post_id_owner, user_id_owner) VALUES (NOW(),p_post_id , p_user_id);
SET v_job_id = LAST_INSERT_ID();
#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
# ------------Q-NS-1 -> Q-P-NS-1 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.ActionStatus = 2,   # 2 Paused
PS.job_id = v_job_id
WHERE PS.postId = p_post_id
   AND JT.post_id_owner is NULL
   AND  JT.user_id_owner is NULL
	AND P.PostStatus = 2        # Q
	AND P.ActionStatus = NULL      #
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 1;		

	
# ------------Q-NS-2 -> Q-P-NS-2 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.ActionStatus = 2,   # 2 Paused
PS.job_id = v_job_id
WHERE PS.postId = p_post_id
   AND JT.post_id_owner is NULL
   AND  JT.user_id_owner is NULL
	AND P.PostStatus = 2        # Q
	AND P.ActionStatus = NULL      #
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 2;		
	
	
#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 	
# ------------I-O-NS-1 -> I-P-N-1 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.ActionStatus = 2,   # 2 Paused
PS.job_id = v_job_id
WHERE PS.postId = p_post_id
   AND JT.post_id_owner is NULL
   AND  JT.user_id_owner is NULL
	AND P.PostStatus = 3        # QInProgres
	AND P.ActionStatus = 1      # Ongoing
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 1;		
	
# ------------I-O-NS-2 -> I-P-N-2 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.ActionStatus = 2,   # 2 Paused
PS.job_id = v_job_id
WHERE PS.postId = p_post_id
   AND JT.post_id_owner is NULL
   AND  JT.user_id_owner is NULL
	AND P.PostStatus = 3        # QInProgres
	AND P.ActionStatus = 1      # Ongoing
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 2;		
	
	update 	task_to_finish 
    join posts_pages on  task_to_finish.queue_id = posts_pages.id
    set task_to_finish.active = -1
    where posts_pages.job_id =v_job_id;										  
END$$

DROP PROCEDURE IF EXISTS `pResume`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pResume` (`p_post_id` INT, `p_user_id` INT)  BEGIN


DECLARE p_role INT;

SELECT roleId into p_role FROM users WHERE id = p_user_id;
# ------------Q-P-NS-1 -> Q-NS-1 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.PostStatus = 2,   # 2 Qwaiting
P.ActionStatus = NULL,
PS.postingStatus = 1,   # 2  Not started
PS.job_id = null
WHERE PS.postId = p_post_id
   #AND JT.post_id_owner = p_post_id
   AND (JT.user_id_owner = p_user_id OR p_role = 1)
   AND JT.cron_job_id_owner is NULL
	AND P.PostStatus = 2        # Q
	AND P.ActionStatus = 2      # P
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 1;		

# ------------Q-P-NS-2 -> Q-NS-2 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.PostStatus = 2,   # 2 Qwaiting
P.ActionStatus = NULL,
PS.postingStatus = 1,   # 2  Not started
JT.job_id = null
WHERE PS.postId = p_post_id
   #AND JT.post_id_owner = p_post_id
   AND (JT.user_id_owner = p_user_id OR p_role = 1)
   AND JT.cron_job_id_owner is NULL
	AND P.PostStatus = 2        # Q
	AND P.ActionStatus = 2      # P
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 2;	
		
	
	
	
	
	
	
	
#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
	
		
# ------------I-P-N-1 -> I-O-NS-1 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.ActionStatus = 1,
JT.cron_job_id_owner = null,
JT.post_id_owner = null,
JT.user_id_owner = null
WHERE PS.postId = p_post_id
   #AND JT.post_id_owner = p_post_id
   AND (JT.user_id_owner = p_user_id OR p_role = 1)
   AND JT.cron_job_id_owner is NULL
	AND P.PostStatus = 3        # QInProgres
	AND P.ActionStatus = 2      # P
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 1;		

# ------------I-P-N-2 -> I-O-NS-2 -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET  
P.ActionStatus = 1,
JT.cron_job_id_owner = null,
JT.post_id_owner = null,
JT.user_id_owner = null
WHERE PS.postId = p_post_id
   #AND JT.post_id_owner = p_post_id
   AND (JT.user_id_owner = p_user_id OR p_role = 1)
   AND JT.cron_job_id_owner is NULL
	AND P.PostStatus = 3        # QInProgres
	AND P.ActionStatus = 2      # P
	AND PS.postingStatus = 1    # NS
	AND PS.job_action = 2;		
	
	
			
										  
END$$

DROP PROCEDURE IF EXISTS `PutIntoTaskToFinish_FBPolicy`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PutIntoTaskToFinish_FBPolicy` (`p_queue_id` INT, `p_crone_job_id` INT, `p_thread_job_id` INT)  BEGIN
DECLARE job_action_queue INT;
DECLARE end_status varchar(8);
if exists(select * from  posts_pages WHERE id = p_queue_id and job_id = p_thread_job_id) then
SELECT job_action INTO job_action_queue FROM posts_pages WHERE id = p_queue_id and job_id = p_thread_job_id;
SET end_status = CONCAT('i-o-ns-',job_action_queue);

INSERT INTO task_to_finish (job_id,task_end_status,queue_id,active)
VALUES(p_thread_job_id,end_status,p_queue_id,1);
end if;
END$$

DROP PROCEDURE IF EXISTS `SetAsDraft`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SetAsDraft` (`p_post_id` INT)  BEGIN
 
 if(CanSetAsDraft(p_post_id) = TRUE) then
 UPDATE posts
 SET  PostStatus = 1
 WHERE id = p_post_id AND IsActive = 1;
END if;

END$$

DROP PROCEDURE IF EXISTS `SetCronJobAsOwner`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SetCronJobAsOwner` (`crone_job_id` INT)  BEGIN
UPDATE jobs_thread 
JOIN posts_pages ON jobs_thread.job_id = posts_pages.job_id
JOIN posts ON posts.id = posts_pages.postId
SET cron_job_id_owner = crone_job_id
WHERE posts.PostStatus = 3
AND posts.ActionStatus = 1
AND posts_pages.postingStatus = 1
AND posts.IsActive = 1
AND jobs_thread.post_id_owner IS NULL
AND jobs_thread.user_id_owner IS NULL
AND jobs_thread.cron_job_id_owner IS NULL ;


END$$

DROP PROCEDURE IF EXISTS `SetCronJobForPaused`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SetCronJobForPaused` (`cron_job_id` INT)  BEGIN


#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET JT.cron_job_id_owner = cron_job_id,
JT.post_id_owner = NULL,
JT.user_id_owner = NULL,
P.PostStatus = 3,
P.ActionStatus = 1,
P.IsActive = 1,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 1
WHERE JT.cron_job_id_owner is null
    AND JT.user_id_owner is NULL 
	AND P.PostStatus = 2
	AND P.ActionStatus = 2
	AND PS.postingStatus = 1
	AND PS.job_action = 1
	AND  fb_valid_queue_id(PS.id);		
	
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET JT.cron_job_id_owner = cron_job_id,
JT.post_id_owner = NULL,
JT.user_id_owner = NULL,
P.PostStatus = 3,
P.ActionStatus = 1,
P.IsActive = 1,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 2
WHERE JT.cron_job_id_owner is null
AND JT.user_id_owner is NULL 
	AND P.PostStatus = 2
	AND P.ActionStatus = 2
	AND PS.postingStatus = 1
	AND PS.job_action = 2
	AND  fb_valid_queue_id(PS.id);		
	
#------------------I-P-N-1
#PostStatus 1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#ActionStatus 1 - Ongoing, 2 - Paused
#PostingStatus 1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET JT.cron_job_id_owner = cron_job_id,
JT.post_id_owner = NULL,
JT.user_id_owner = NULL,
P.PostStatus = 3,
P.ActionStatus = 1,
P.IsActive = 1,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 1
WHERE JT.cron_job_id_owner is NULL
AND JT.user_id_owner is NULL 
	AND P.PostStatus = 3
	AND P.ActionStatus = 2
	AND PS.postingStatus = 1
	AND PS.job_action = 1
	AND  fb_valid_queue_id(PS.id);		


#------------------I-P-N-2	
#PostStatus 1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#ActionStatus 1 - Ongoing, 2 - Paused
#PostingStatus 1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET JT.cron_job_id_owner = cron_job_id,
JT.post_id_owner = NULL,
JT.user_id_owner = NULL,
P.PostStatus = 3,
P.ActionStatus = 1,
P.IsActive = 1,
PS.postingStatus = 1,
PS.job_id = JT.job_id,
PS.job_action = 2
WHERE JT.cron_job_id_owner is NULL
AND JT.user_id_owner is NULL 
	AND P.PostStatus = 3
	AND P.ActionStatus = 2
	AND PS.postingStatus = 1
	AND PS.job_action = 2
	AND  fb_valid_queue_id(PS.id);


	
	
										  
END$$

DROP PROCEDURE IF EXISTS `SetErrorStatuse`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SetErrorStatuse` (`p_queue_id` INT, `p_errors` TEXT)  BEGIN

DECLARE p_post_id INT;
DECLARE p_count INT;
DECLARE post_postStatus INT;
SET  post_postStatus = 4;
SELECT postId into p_post_id from posts_pages WHERE id = p_queue_id;


SELECT COUNT(id) INTO p_count
FROM posts_pages 
WHERE postId = p_post_id
AND id <> p_queue_id
AND postingStatus NOT IN (3,4);# not in (finishSuccess, error)

if(p_count = 0) then
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
SET  
P.ActionStatus = NULL,   
P.PostStatus = 4, #Sent
PS.postingStatus = 4, 
PS.job_errors = p_errors
WHERE PS.id = p_queue_id ;
ELSE
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
SET  
P.ActionStatus = NULL, 
PS.postingStatus = 4, #Error
PS.job_errors = p_errors
WHERE PS.id = p_queue_id ;

 END if;

CALL UpdateLastFBAction(p_queue_id);
END$$

DROP PROCEDURE IF EXISTS `SetFinishedStatuse`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SetFinishedStatuse` (`p_queue_id` INT)  BEGIN

DECLARE p_post_id INT;
DECLARE p_count INT;

DECLARE p_count_del INT;
declare db_job_action int;
SELECT postId, job_action into p_post_id,db_job_action  from posts_pages WHERE posts_pages.id = p_queue_id;

if(db_job_action = 3) then
	UPDATE posts_pages  PS 
	JOIN posts P ON PS.postId = P.id 
	SET  
	P.ActionStatus = NULL,   
	P.PostStatus = null, 
	PS.postingStatus = null
	WHERE PS.id = p_queue_id ;
	SELECT COUNT(posts_pages.id) INTO p_count_del
	FROM posts_pages 
	WHERE postId = p_post_id
	and posts_pages.postingStatus is not null; 
	if(p_count_del = 0) then
		UPDATE  posts  set IsActive = 0
		WHERE id = p_post_id ;
	END if;
else
SELECT COUNT(posts_pages.id) INTO p_count
FROM posts_pages 
WHERE postId = p_post_id
AND posts_pages.id <> p_queue_id
AND postingStatus NOT IN (3,4);# not in (finishSuccess, error)

if(p_count = 0) then
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
SET  
P.ActionStatus = NULL,   
P.PostStatus = 4, #Sent
PS.postingStatus = 3 #FinishSuccess
WHERE PS.id = p_queue_id ;

ELSE
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
SET  
PS.postingStatus = 3 #FinishSuccess
WHERE PS.id = p_queue_id ;

 END if;
 
 
UPDATE posts_pages
SET datePublishedFB = NOW()
WHERE posts_pages.id = p_queue_id;
end if;
CALL UpdateLastFBAction(p_queue_id);
END$$

DROP PROCEDURE IF EXISTS `ThreadJobFinish`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ThreadJobFinish` (`p_thread_job_id` INT)  BEGIN

 UPDATE jobs_thread
 SET last_action_time = NOW(),
 cron_job_id_owner = null,
 post_id_owner = null,
 user_id_owner = null
 WHERE job_id = p_thread_job_id;


END$$

DROP PROCEDURE IF EXISTS `UpdateLastFBAction`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateLastFBAction` (`p_queue_id` INT)  BEGIN

DECLARE v_fb_page_id TEXT ;
DECLARE v_fb_user_id TEXT ;

SELECT pages.fbPageId, fb_users.fb_user_id into v_fb_page_id,  v_fb_user_id
from posts_pages 
JOIN pages ON  posts_pages.pageId = pages.id
JOIN posts ON posts.id = posts_pages.postId
JOIN fb_users ON fb_users.user_id = posts.created_by
WHERE posts_pages.id = p_queue_id;

 

if EXISTS (SELECT * FROM last_upload_fb_page WHERE last_upload_fb_page.fb_page_id = v_fb_page_id) then
 UPDATE last_upload_fb_page
 SET last_upload_time = NOW()
 WHERE fb_page_id = v_fb_page_id;
 
 ELSE 
  INSERT INTO last_upload_fb_page (fb_page_id, last_upload_time) VALUES (v_fb_page_id, NOW());
 END if;

if EXISTS (SELECT * FROM last_upload_fb_user WHERE last_upload_fb_user.fb_user_id = v_fb_user_id) then
 UPDATE last_upload_fb_user
 SET last_upload_time = NOW()
 WHERE fb_user_id = v_fb_user_id;
 
 ELSE 
  INSERT INTO last_upload_fb_user (fb_user_id, last_upload_time) VALUES (v_fb_user_id, NOW());
 END if;


END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `CanArchive`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `CanArchive` (`p_post_id` INT) RETURNS TINYINT(1) BEGIN
	DECLARE num_rows_paused INT;
		DECLARE num_rows_in_progress INT;
	
	SELECT COUNT(*) INTO num_rows_paused
	FROM posts_pages JOIN posts ON posts_pages.postId = posts.id
	WHERE posts.ActionStatus = 2 and posts.id = p_post_id;
	SELECT COUNT(*) INTO num_rows_in_progress
	FROM posts_pages 
	WHERE posts_pages.postingStatus = 2 and posts_pages.postId = p_post_id;
	 
	if (num_rows_paused + num_rows_in_progress) > 0 then
	 RETURN FALSE;
	 else
	 RETURN TRUE;
	 END if;
END$$

DROP FUNCTION IF EXISTS `CanEditPageAndGroups`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `CanEditPageAndGroups` (`p_post_id` INT) RETURNS TINYINT(4) BEGIN
	 
	DECLARE c_num INT;
    declare is_draft int;
    select PostStatus into is_draft from posts where id = p_post_id;
	
	if(is_draft = 1 ) then
       RETURN true;
     else 
		SELECT count(*) INTO  c_num
		FROM posts JOIN posts_pages ON posts.id = posts_pages.postId 
		WHERE posts_pages.postId = p_post_id
		AND posts.PostStatus <> 2
		OR posts.ActionStatus is not null;
	end if;
 
	
	 
	if  c_num = 0 then 
	 RETURN true;
	 else
	 RETURN false;
	 END if;
END$$

DROP FUNCTION IF EXISTS `CanSetAsDraft`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `CanSetAsDraft` (`p_post_id` INT) RETURNS TINYINT(1) BEGIN
	DECLARE num_rows_paused INT;
	DECLARE num_rows_on_going INT;
	DECLARE num_rows_in_progress_sent_error INT;
		
	SELECT COUNT(*) INTO num_rows_on_going
	FROM posts_pages JOIN posts ON posts_pages.postId = posts.id
	WHERE posts.ActionStatus = 2 and posts.id = p_post_id;
	
	SELECT COUNT(*) INTO num_rows_paused
	FROM posts_pages JOIN posts ON posts_pages.postId = posts.id
	WHERE posts.ActionStatus = 1 and posts.id = p_post_id;
	
	SELECT COUNT(*) INTO num_rows_in_progress_sent_error
	FROM posts_pages  JOIN posts ON posts_pages.postId = posts.id
	WHERE (posts_pages.postingStatus = 2 OR posts_pages.postingStatus = 3  OR posts_pages.postingStatus = 4 )
	AND (posts.PostStatus = 3 OR posts.PostStatus = 4)
	and posts_pages.postId = p_post_id;
	 
	if (num_rows_on_going + num_rows_paused + num_rows_in_progress_sent_error) > 0 then
	 RETURN FALSE;
	 else
	 RETURN TRUE;
	 END if;
END$$

DROP FUNCTION IF EXISTS `fb_valid_queue_id`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fb_valid_queue_id` (`queue_id` INT) RETURNS TINYINT(1) BEGIN
	DECLARE last_date DATETIME;
	DECLARE fb_user_page_param INT;
	DECLARE fb_sec_period INT;
	DECLARE user_id text;
	DECLARE page_id text;
	
	
	SELECT pages.fbPageId, fb_users.fb_user_id INTO page_id, user_id
	FROM pages JOIN posts_pages ON pages.id = posts_pages.pageId
	JOIN fb_users ON pages.userId = fb_users.user_id
	WHERE posts_pages.id = queue_id;
	
	SELECT user_or_page, period_in_sec_fb INTO fb_user_page_param, fb_sec_period FROM global_parameters;
	if fb_user_page_param = 1 then
	SELECT ifNull(avg(last_upload_time),'2018-01-01') INTO last_date FROM last_upload_fb_page WHERE fb_page_id = page_id;
	ELSE
	SELECT ifNull(avg(last_upload_time),'2018-01-01') INTO last_date FROM last_upload_fb_user WHERE fb_user_id = user_id;
	END if;
	
	 
	if TIMESTAMPDIFF(SECOND, last_date, NOW()) > fb_sec_period then
	 RETURN TRUE;
	 else
	 RETURN FALSE;
	 END if;
END$$

DROP FUNCTION IF EXISTS `GroupsForPages`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `GroupsForPages` (`pageId` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT  REPLACE(GROUP_CONCAT(ifNull(groups.name,'<br>'),'<br>'),',','') AS groups
FROM pages
left JOIN pages_groups ON pages.id = pages_groups.pageId
left JOIN groups ON groups.id = pages_groups.groupId
WHERE pages.id = pageId
GROUP BY pages.id
 )$$

DROP FUNCTION IF EXISTS `GroupsForPost`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `GroupsForPost` (`postId` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT  REPLACE(GROUP_CONCAT(ifNull(groups.name,'<br>'),'<br>'),',','') AS groups
FROM posts
left JOIN groups_in_post ON posts.id = groups_in_post.postId
left JOIN groups ON groups.id = groups_in_post.groupId
WHERE posts.id = postId
GROUP BY groups_in_post.groupId, posts.id
 )$$

DROP FUNCTION IF EXISTS `PagesForPost`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `PagesForPost` (`postId` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT  REPLACE(GROUP_CONCAT(ifNull(pages.fbPageName,'<br>'),'<br>'),',','') AS pages
FROM posts
left JOIN posts_pages ON posts.id = posts_pages.postId
left JOIN pages ON pages.id = posts_pages.pageId
WHERE posts.id = postId
GROUP BY posts.id
 )$$

DROP FUNCTION IF EXISTS `StartQueuedItem`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `StartQueuedItem` (`queue_id` INT, `crone_job_id` INT, `thread_job_id` INT) RETURNS TINYINT(1) BEGIN 
if exists(select * from  posts_pages WHERE id = queue_id and job_id = thread_job_id) then
if (SELECT fb_valid_queue_id(queue_id)) = 0 then
    CALL PutIntoTaskToFinish_FBPolicy(queue_id, crone_job_id,thread_job_id);
     RETURN 0;#false
	ELSE
     CALL OnGoing(queue_id, crone_job_id,thread_job_id);
     RETURN (
	          SELECT COUNT(*) 
	          FROM posts_pages JOIN posts ON posts_pages.postId = posts.id
	          WHERE posts_pages.id = queue_id 
			     AND posts.ActionStatus = 1
			     AND posts.PostStatus = 3
			     AND posts_pages.postingStatus = 2
			     AND posts.IsActive = 1
				);
	END if;
else
return 0;
end if;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `automatic_groups`
--

DROP TABLE IF EXISTS `automatic_groups`;
CREATE TABLE `automatic_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `minLikes` int(11) DEFAULT '0',
  `maxLikes` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cron_jobs`
--

DROP TABLE IF EXISTS `cron_jobs`;
CREATE TABLE `cron_jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `cron_job_status` int(11) NOT NULL,
  `cron_job_START` datetime DEFAULT NULL,
  `cron_job_END` datetime DEFAULT NULL,
  `finish_status` int(11) NOT NULL,
  `cron_job_errors` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cron_jobs`
--

INSERT INTO `cron_jobs` (`id`, `cron_job_status`, `cron_job_START`, `cron_job_END`, `finish_status`, `cron_job_errors`) VALUES
(264, 1, '2019-03-19 22:23:19', '2019-03-19 22:24:00', 1, '_ '),
(265, 1, '2019-03-19 22:38:19', '2019-03-19 22:39:20', 1, '_ ');

-- --------------------------------------------------------

--
-- Table structure for table `fb_users`
--

DROP TABLE IF EXISTS `fb_users`;
CREATE TABLE `fb_users` (
  `id` int(11) NOT NULL,
  `fb_user_id` varchar(100) NOT NULL,
  `fb_name` varchar(100) DEFAULT NULL,
  `fb_access_token` text,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fb_users`
--

INSERT INTO `fb_users` (`id`, `fb_user_id`, `fb_name`, `fb_access_token`, `user_id`) VALUES
(8, '104788047350548', 'Carol Alcdehjehhdie Rosenthalsky', 'EAAHKRllr1hkBABywNNwS3T8w3z4z6v7ZAFYPQe90ZCf69IeYYAuJnR655fdld9ck5tlxOHAPHzNPCiMnMr7KR5Nb3bDjK9zskEq4mrGQlNniu0cT2ndgllgduwFQQ0MyhCmWSNgIFr9OXyke3glsoJZCczlAPZCj8szdw8iky9ozWMF4O2ZC3', 17),
(9, '106975337129264', 'Sophia Alcdejcidbibi Sadanson', 'EAAHKRllr1hkBAOQurHCeooZAKC0oKWPsH7RZBySvQJW4jTadZBDrlJ8vM8ew6ILbCaTN85gtR5PBhZA6ZCbs4OYM5CfEboH3IEYgtc4BIyBU24mGpNxnxZCf7ZBE6gZBffff95rKZCm3dQzRYw2l0IkbvHDeeUe8G1RY7tvbH87l9PmGonIIHYANE', 18),
(10, '100962211045487', 'Dave Alccieabdbcjd Carrieroson', 'EAAHKRllr1hkBALKRWveru1KgNW9ZAYX0MT0queuZBU2hef9VR16C2odefJZCvD8BFhrZAUZBb3fdHeTNtJgvVeFxmsGC5LPSTM9ko3ZC4FkG5AGJRKGBLj1xJH5aRecQvsi8ZAdKMv926HL4DHp4xNbZBQv27pvrXAWoiCUCG5nN40tyiyYTP728', 19),
(11, '104189817385560', 'Olivia Olivia', 'EAAHKRllr1hkBABPIBAj00JzsB29ZAqZBSrjRiTuwiOTvm7f9T7hgGmkVOqRsuepPEJQTUbbiC4TRGfZC4cPrFLsbjDTdZB7nSXuu0NhbDZAm5ecBqj2OPTZAzZCtIxPznfZAFqT7lfGMx9mx79fpcsXB7NABx1yRX61vODmVYIQHhA97yPLQAFZA2', 20);

-- --------------------------------------------------------

--
-- Table structure for table `global_parameters`
--

DROP TABLE IF EXISTS `global_parameters`;
CREATE TABLE `global_parameters` (
  `id` int(10) UNSIGNED NOT NULL,
  `period_in_sec_fb` int(11) NOT NULL,
  `user_or_page` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `global_parameters`
--

INSERT INTO `global_parameters` (`id`, `period_in_sec_fb`, `user_or_page`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `global_statistic`
--

DROP TABLE IF EXISTS `global_statistic`;
CREATE TABLE `global_statistic` (
  `pLast72` int(11) DEFAULT NULL COMMENT 'postovi u zadnjih 71',
  `rLast72` int(11) DEFAULT NULL COMMENT 'reakcije  u zadnjih 71',
  `cLast72` int(11) DEFAULT NULL COMMENT 'komentari  u zadnjih 71',
  `sLast72` int(11) DEFAULT NULL COMMENT 'share  u zadnjih 71'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `global_statistic`
--

INSERT INTO `global_statistic` (`pLast72`, `rLast72`, `cLast72`, `sLast72`) VALUES
(1233432432, 45, 56, 654);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `createDate` datetime NOT NULL,
  `userId` int(11) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `createDate`, `userId`, `isActive`) VALUES
(69, 'olivia1', '2019-03-13 08:35:37', 16, 1),
(70, 'olivia2', '2019-03-13 08:35:48', 16, 0),
(71, 'olivia2', '2019-03-13 08:35:48', 16, 1),
(72, 'marko1', '2019-03-13 08:40:02', 12, 1),
(73, 'jelena1', '2019-03-13 09:17:04', 20, 1),
(74, 'jelena2', '2019-03-13 09:18:52', 20, 1),
(75, 'marko1', '2019-03-13 09:19:39', 17, 1),
(76, 'marko2', '2019-03-13 09:20:03', 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups_in_post`
--

DROP TABLE IF EXISTS `groups_in_post`;
CREATE TABLE `groups_in_post` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `groupId` int(11) NOT NULL,
  `pageId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups_in_post`
--

INSERT INTO `groups_in_post` (`id`, `postId`, `groupId`, `pageId`) VALUES
(74, 602, 73, 36),
(75, 602, 73, 38);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_thread`
--

DROP TABLE IF EXISTS `jobs_thread`;
CREATE TABLE `jobs_thread` (
  `job_id` int(10) UNSIGNED NOT NULL,
  `cron_job_id` int(11) NOT NULL,
  `last_action_time` datetime NOT NULL,
  `cron_job_id_owner` int(11) DEFAULT NULL,
  `post_id_owner` int(11) DEFAULT NULL,
  `user_id_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_thread`
--

INSERT INTO `jobs_thread` (`job_id`, `cron_job_id`, `last_action_time`, `cron_job_id_owner`, `post_id_owner`, `user_id_owner`) VALUES
(481, 0, '2019-03-19 22:22:55', NULL, 594, 20),
(482, 264, '2019-03-19 22:24:00', NULL, NULL, NULL),
(483, 0, '2019-03-19 22:29:15', NULL, 594, 20),
(484, 265, '2019-03-19 22:39:20', NULL, NULL, NULL),
(485, 0, '2019-03-19 23:04:11', NULL, 600, 20),
(486, 0, '2019-03-19 23:15:35', NULL, 602, 20),
(487, 0, '2019-03-19 23:16:58', NULL, 602, 20);

-- --------------------------------------------------------

--
-- Table structure for table `last_upload_fb_page`
--

DROP TABLE IF EXISTS `last_upload_fb_page`;
CREATE TABLE `last_upload_fb_page` (
  `id` int(10) UNSIGNED NOT NULL,
  `fb_page_id` text NOT NULL,
  `last_upload_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `last_upload_fb_page`
--

INSERT INTO `last_upload_fb_page` (`id`, `fb_page_id`, `last_upload_time`) VALUES
(1, '777736072599375', '2019-03-19 22:18:43'),
(2, 'page1', '2019-03-13 19:39:13'),
(3, '541140996398061', '2019-03-19 22:39:00'),
(4, '971438483243979', '2019-03-19 21:43:57'),
(5, '246671336217871', '2019-03-18 23:46:50'),
(6, '264447761139100', '2019-03-18 23:59:16'),
(7, '364324417746132', '2019-03-18 23:58:19'),
(8, '2259650144248017', '2019-03-18 23:56:57'),
(9, '2201075073542677', '2019-03-19 22:39:20');

-- --------------------------------------------------------

--
-- Table structure for table `last_upload_fb_user`
--

DROP TABLE IF EXISTS `last_upload_fb_user`;
CREATE TABLE `last_upload_fb_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `fb_user_id` text NOT NULL,
  `last_upload_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `last_upload_fb_user`
--

INSERT INTO `last_upload_fb_user` (`id`, `fb_user_id`, `last_upload_time`) VALUES
(1, '104189817385560', '2019-03-19 22:39:20'),
(2, '104788047350548', '2019-03-18 23:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) NOT NULL,
  `fbPageId` varchar(50) NOT NULL,
  `fbPageName` varchar(255) NOT NULL,
  `dateAdded` datetime NOT NULL,
  `userId` int(11) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT '1',
  `fbPageAT` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `fbPageId`, `fbPageName`, `dateAdded`, `userId`, `isActive`, `fbPageAT`) VALUES
(26, '246671336217871', 'Datadattest1', '2019-03-13 21:07:35', 17, 1, 'EAAHKRllr1hkBAOS8PA6ow4EdkvJij4gOKl17NWNDPhmZBiCW2HKxpWrEePYtQ1oPeLOITbsHEmNvg4JTF7jlBjjXBzJNEmiSsxRSiheuhBnq9CdTpZBEghnRaeAOypWBWRuPDr17EZBZASBLU2nwCzmxxyXnfuw16rsdndj9aLtRKxH2U62GRZAACa3BeW1EZD'),
(27, '264447761139100', 'Datadattest2', '2019-03-13 21:07:35', 17, 1, 'EAAHKRllr1hkBALHagtK1pyFTFAOi0V7SftWrgwsshvrPkfZCW4fLoC82N0maZB7K4s1xuwwXbgsIO9HMVjyOBbrFCtulQtpbTRdyKZCnQQe6KuqoEKnMZA3ZCU1CZCrMf64j5yOmLvpy0luVDH63cHcD9V9LZBfZCMirY8eYJqfSZC63bZBeFPvZCqpUZBTvSRUZAWQQZD'),
(28, '364324417746132', 'Datadattest3', '2019-03-13 21:07:35', 17, 1, 'EAAHKRllr1hkBAPf2KiuZBaTUY7exOiVxRxmSq7If6efy1vVdvRM2PQwwBBCO196SF3L8cCGypBANrsXs4V4E4YCR01cyXexW6qSePjXtagAKsZCPIiC5xjkYD17RZB7r9YiuZAWKyeWJC5HBMhQKJoNH66A2GYNK1USJZBv0me9oY9KsUHjFWiiLoI4kLoyUZD'),
(29, '344756762805314', 'Datadattest6', '2019-03-13 21:10:26', 18, 1, 'EAAHKRllr1hkBAI4W0B7uwneX5ZCVWMc7iA4fZByp8CYQTbWec5UknHo34sCsBMSTtR2JYoSLL3ZAMJbYTzBR9lmrqfVho7RbabHmtVLTry7NsclGkmsX32INmDrXd6L2tzAPSdG129ZB9XxtPYdptyIAFp5qrba6XXogFcSSEyIOgduyjCoRbz0GKN213tIZD'),
(30, '640299693073413', 'Datadattest4', '2019-03-13 21:10:26', 18, 1, 'EAAHKRllr1hkBAOq8PLMJXddC3DjJiXmHsXX7s5n40IFjbk0qJA21eH1dwuNSpLG6Ufn30K6zvmfupp7kbf9iN86VXd8ZB3kW1I87IimDbE5rBbpyYv4ZCCCFbRQHZA95ZCZCr5CwgLZAuK0FeVLLC0hJ4qpiyTzeLLCQvXyjCuVSN1mKdmPQ0iUGfrddWlruEZD'),
(31, '643579096105954', 'Datadattest5', '2019-03-13 21:10:26', 18, 1, 'EAAHKRllr1hkBAOtDlvl96whUhf9XEjhFBAGbE90I1w8zqCTi4N1RZBRZBplouHsZC90caXzMLx5kD5dqVhzE7xDL66zKXJnZBWGNKCU3P7m2QQZBvZCs7Oq5f35BiqXspoZAtwAahWyvC5EPGfKo1WjlwkOnFAyNWIJDG96qRzZBrDPRDdakpFclvxcyjrY86G0ZD'),
(32, '303069253739492', 'Page Dave One', '2019-03-13 21:13:58', 19, 1, 'EAAHKRllr1hkBAH5c6gtzOPqtjAZCaMe27KVnWqHwGFXp315i671oZB43sDSZAz9EKs5dZBa3tYMZA62SeLwyTZCqpKFIWyHBEuYw1cmZBqgLOMWZBD9UEUi05Sjo9sIBAnXj3ZCcpnlbIkal9Xzt3kZAWCt9Dk4Cl1Iei3c9tY9IsG1cFNxqpFWfZBMflLa8ni3uxIZD'),
(33, '387076882081892', 'Datadattest9', '2019-03-13 21:13:58', 19, 1, 'EAAHKRllr1hkBAE19DNSs4XidXG5uWLVIdCTg1ESvJAA4UHB6yZBlfP3cGZCEUsFjeqT1tlcHcvEmZBxjNyT0ZCS4L2CT5ZC5NQ3xGMkX9g5KIWCVXnbLa7K2gApF3TeNRdgfFsTkuSLK3COkdu5JfXPZBxqHhuf98YxyucG1sZA2bMZCZC5IIyPTpRtJV8g5x07IZD'),
(34, '2291514561060121', 'Datadattest7', '2019-03-13 21:13:58', 19, 1, 'EAAHKRllr1hkBADNKuJcxTYmMW2DUZCwmKrRdBvLRldwlXe5ZCWZAdQ7mHZBcRQRQy6L3CpXNOIMWrSKGfIxzu92zZAz1E3k0n28XfDLZCTs8B1oBj6nqmxta79J1ULiJyl7YpD9lccMNSFhOuVVZAcMZAZB0GFdQmSDbUA4tZAPZB5n3VkMWumwpfGSbDNKEiWxvSAZD'),
(35, '2311412742471909', 'Datdatttest8', '2019-03-13 21:13:58', 19, 1, 'EAAHKRllr1hkBALyOEReaPQUhHwVLybLfjvF4CaYeZBZCMGlf2zhGpM2tyZC6MS6TfZADNGT5RiMwFAqZAcK0ouaDhSG8pPV8qyVprvn6sTEZBLr0X42sFnOEiWOnKeOvBPRKDSr1TM4Vw7yZClrW8FKlSqBhY0TbMaIkq7stPlVwVOquOqy15VjVaCXK55AcaQZD'),
(36, '541140996398061', 'Olivia Hobbit', '2019-03-13 21:15:54', 20, 1, 'EAAHKRllr1hkBAGxw7dFZCvTXzeYpkDud1p0wHWw4XqjOerSMijmu7DpTjkpqdhhwgrbImVRR2XEcR3bZAbq4ds67uRG9reffFXLEK8muEEbVK1RBDHFfnpRBHhu7Tj2DPnVW3nQDToTT0zXJR238fqqUo5PKwXzHjlz0hVN3fW35XKWQgCrBlInJDFgScZD'),
(37, '777736072599375', 'Olivia  Star', '2019-03-13 21:15:54', 20, 1, 'EAAHKRllr1hkBAKv5vJmFrR3K0QI8UHFxGVv1RDmQ8oAsV79Pme2zeG8RfHXoEMAoBQ7uO5otjLwacE0h1N6iCUyHQSNGtyEOfEYphjlg6hlm1tWhkF7bs5VgWfVxaxysFivPk5KorkB0BmRKYmIlOl8uaZB6wwB80HQhtmr3I9DReGGAcQysrC4XdOZCsZD'),
(38, '971438483243979', 'Olivia Young', '2019-03-13 21:15:54', 20, 1, 'EAAHKRllr1hkBAB8ZAWcPLN44Y2kmfHlAZClOWSHraaVekTRluCI4XB8pPCwkRoy61EDX6vKI7FZCZC8ksSiWD6MZCPrcTwa60awpMZAJI8RyF5nnTK9PcdrA00eY86p8ZCHOSV4MeDuV4Qwe6T8JqIZAi1rZC7WyyetTfZBecOMlFe2lqjjO3YQzbZAZABSB4DIOFnoZD'),
(39, '2201075073542677', 'Olivia One', '2019-03-13 21:15:54', 20, 1, 'EAAHKRllr1hkBAKQuwbodyR6SFcPcduZCd0SUhclgE0DSUyA4Loqv55FA60xWP4mtIpNntvAqzhm8b0QEvxKmdZCW5BCe5WIlyQsZBnNqLZApDxZBNj2Ig575wPNy73rkX1oaQzJ2hwADFChTNRmedF1jRdNPZAZBXpHIioR47GBA2B3xR7yKh8vh5lxcZANQZCSYZD'),
(40, '2259650144248017', 'Olivia\'s Community', '2019-03-13 21:15:54', 20, 1, 'EAAHKRllr1hkBALdGYnkR9Tfmwlntc2qDwhsZCXR8jvOVK5pKJg9THX9phAZBZBObAi0VhcA0xLptFG5seE8iaUNFK4ktVmjzeyuYpu5O1LoTOKZBZCeNmRzB5JYqZCgwkf9uyp85YEOPxZAVGxg0MZAPsxrZARtypiDyZCQLKq3jZCpIkGENzZCR7sEFoZAeSVIlZCo4wZD');

-- --------------------------------------------------------

--
-- Table structure for table `pages_groups`
--

DROP TABLE IF EXISTS `pages_groups`;
CREATE TABLE `pages_groups` (
  `id` int(11) NOT NULL,
  `pageId` int(11) NOT NULL,
  `groupId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `dateCreate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages_groups`
--

INSERT INTO `pages_groups` (`id`, `pageId`, `groupId`, `userId`, `dateCreate`) VALUES
(26, 36, 73, 20, '2019-03-13 09:18:29'),
(27, 38, 73, 20, '2019-03-13 09:18:35'),
(28, 40, 74, 20, '2019-03-13 09:18:57'),
(29, 39, 74, 20, '2019-03-13 09:19:03'),
(30, 26, 75, 17, '2019-03-13 09:19:44'),
(31, 28, 75, 17, '2019-03-13 09:19:46'),
(32, 28, 76, 17, '2019-03-13 09:20:08'),
(33, 27, 76, 17, '2019-03-13 09:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `page_by_hand_in_post`
--

DROP TABLE IF EXISTS `page_by_hand_in_post`;
CREATE TABLE `page_by_hand_in_post` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `pageId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_by_hand_in_post`
--

INSERT INTO `page_by_hand_in_post` (`id`, `postId`, `pageId`) VALUES
(1075, 595, 36),
(1076, 595, 39),
(1077, 596, 36),
(1078, 596, 39),
(1079, 600, 36),
(1080, 600, 39),
(1081, 601, 36),
(1082, 601, 37),
(1083, 601, 38);

-- --------------------------------------------------------

--
-- Table structure for table `page_statistic`
--

DROP TABLE IF EXISTS `page_statistic`;
CREATE TABLE `page_statistic` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `pageLikes` int(11) DEFAULT NULL,
  `p24` int(11) DEFAULT NULL COMMENT 'postovi u zadnja 24h',
  `p72` int(11) DEFAULT NULL COMMENT 'postovi u zadnja 72h',
  `lastUpdate` datetime DEFAULT NULL,
  `diffLikes` int(11) DEFAULT NULL COMMENT 'Razlika u lajkovima u odnosu na zadnju statistiku'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_statistic`
--

INSERT INTO `page_statistic` (`id`, `page_id`, `pageLikes`, `p24`, `p72`, `lastUpdate`, `diffLikes`) VALUES
(2, 39, 434, 54, 45, '2019-03-12 20:56:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `PostStatus` int(10) NOT NULL COMMENT '1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent ',
  `ActionStatus` int(10) DEFAULT NULL COMMENT '1 - Ongoing, 2 - Paused',
  `IsActive` int(10) NOT NULL DEFAULT '1' COMMENT '0 - Arhived, 1 - Activ',
  `isScheduled` int(10) NOT NULL DEFAULT '0',
  `post_type` varchar(10) CHARACTER SET utf8 NOT NULL,
  `scheduledTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `created_by`, `created_date`, `PostStatus`, `ActionStatus`, `IsActive`, `isScheduled`, `post_type`, `scheduledTime`) VALUES
(594, 'drfat ya copy', 'drfat ya copy', 20, '2019-03-19 22:22:46', 1, NULL, 1, 0, 'message', NULL),
(595, 'dddddd', 'dddddd', 20, '2019-03-19 22:23:11', 4, NULL, 1, 0, 'message', NULL),
(596, 'dddddd qq', 'dddddd qqqqq', 20, '2019-03-19 22:24:30', 4, NULL, 1, 0, 'message', NULL),
(597, 'dfdfd', 'dfdfdfdfd', 20, '2019-03-19 22:25:52', 1, NULL, 1, 0, 'message', NULL),
(598, 'drfat ya copy fffff', 'drfat ya copy ffff', 20, '2019-03-19 22:26:24', 1, NULL, 1, 0, 'message', NULL),
(599, 'dejo', 'jnnnmmn', 20, '2019-03-19 22:30:03', 1, NULL, 1, 0, 'message', NULL),
(600, 'dddddd copy', 'dddddd copy', 20, '2019-03-19 22:39:52', 2, NULL, 1, 0, 'message', NULL),
(601, 'ddfs,fklsdf', 'ffdsfsd fsd fsd ', 20, '2019-03-19 23:07:01', 2, NULL, 1, 0, 'message', NULL),
(602, 'videoooooo2222', 'videooooo 222222', 20, '2019-03-19 23:15:22', 1, NULL, 1, 0, 'video', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts_archive`
--

DROP TABLE IF EXISTS `posts_archive`;
CREATE TABLE `posts_archive` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `PostStatus` int(10) NOT NULL COMMENT '1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent ',
  `ActionStatus` int(10) DEFAULT NULL COMMENT '1 - Ongoing, 2 - Paused',
  `IsActive` int(10) NOT NULL DEFAULT '1' COMMENT '0 - Arhived, 1 - Activ',
  `isScheduled` int(10) NOT NULL DEFAULT '0',
  `post_type` varchar(10) CHARACTER SET utf8 NOT NULL,
  `scheduledTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts_pages`
--

DROP TABLE IF EXISTS `posts_pages`;
CREATE TABLE `posts_pages` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `pageId` int(11) NOT NULL,
  `postingStatus` int(11) DEFAULT NULL COMMENT '1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error ',
  `dateCreated` datetime NOT NULL,
  `dateUpdate` datetime DEFAULT NULL,
  `datePublishedFB` datetime DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `job_action` int(11) DEFAULT NULL,
  `job_errors` text,
  `fbPostId` varchar(50) DEFAULT NULL,
  `is_deleted_from_fb` bit(1) NOT NULL DEFAULT b'0' COMMENT '0- nije izbrisan; 1 - jeste izbrisan',
  `delete_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts_pages`
--

INSERT INTO `posts_pages` (`id`, `postId`, `pageId`, `postingStatus`, `dateCreated`, `dateUpdate`, `datePublishedFB`, `job_id`, `job_action`, `job_errors`, `fbPostId`, `is_deleted_from_fb`, `delete_time`) VALUES
(1211, 595, 36, 3, '2019-03-19 22:23:11', NULL, '2019-03-19 22:38:29', 484, 2, NULL, NULL, b'0', NULL),
(1212, 595, 39, 4, '2019-03-19 22:23:11', NULL, '2019-03-19 22:38:39', 484, 2, NULL, NULL, b'0', NULL),
(1213, 596, 36, 3, '2019-03-19 22:24:30', NULL, '2019-03-19 22:39:00', 484, 1, NULL, NULL, b'0', NULL),
(1214, 596, 39, 3, '2019-03-19 22:24:30', NULL, '2019-03-19 22:39:20', 484, 1, NULL, NULL, b'0', NULL),
(1215, 600, 36, 1, '2019-03-19 22:39:52', NULL, NULL, NULL, 1, NULL, NULL, b'0', NULL),
(1216, 600, 39, 1, '2019-03-19 22:39:52', NULL, NULL, NULL, 1, NULL, NULL, b'0', NULL),
(1217, 601, 36, 1, '2019-03-19 23:07:01', NULL, NULL, NULL, 1, NULL, NULL, b'0', NULL),
(1218, 601, 37, 1, '2019-03-19 23:07:01', NULL, NULL, NULL, 1, NULL, NULL, b'0', NULL),
(1219, 601, 38, 1, '2019-03-19 23:07:01', NULL, NULL, NULL, 1, NULL, NULL, b'0', NULL),
(1220, 602, 36, 1, '2019-03-19 23:15:23', NULL, NULL, NULL, 1, NULL, NULL, b'0', NULL),
(1221, 602, 38, 1, '2019-03-19 23:15:23', NULL, NULL, NULL, 1, NULL, NULL, b'0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts_pages_archive`
--

DROP TABLE IF EXISTS `posts_pages_archive`;
CREATE TABLE `posts_pages_archive` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `pageId` int(11) NOT NULL,
  `postingStatus` int(11) DEFAULT NULL COMMENT '1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error ',
  `dateCreated` datetime NOT NULL,
  `dateUpdate` datetime DEFAULT NULL,
  `datePublishedFB` datetime DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `job_action` int(11) DEFAULT NULL,
  `job_errors` text,
  `fbPostId` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_attachments`
--

DROP TABLE IF EXISTS `post_attachments`;
CREATE TABLE `post_attachments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `attach_type` varchar(50) NOT NULL,
  `attach_location` text NOT NULL,
  `caption` varchar(50) NOT NULL COMMENT 'naziv za video ili sliku',
  `localResources` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_attachments`
--

INSERT INTO `post_attachments` (`id`, `post_id`, `attach_type`, `attach_location`, `caption`, `localResources`) VALUES
(29, 602, 'video', '1551561485480_small.mp4', '', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Editor');

-- --------------------------------------------------------

--
-- Table structure for table `task_to_finish`
--

DROP TABLE IF EXISTS `task_to_finish`;
CREATE TABLE `task_to_finish` (
  `id` int(10) UNSIGNED NOT NULL,
  `job_id` int(11) NOT NULL,
  `task_end_status` varchar(30) NOT NULL,
  `queue_id` int(11) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `dateCreated` datetime NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `salt` varchar(250) NOT NULL,
  `roleId` int(11) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `IsActive` int(1) DEFAULT '1',
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `dateCreated`, `username`, `password`, `salt`, `roleId`, `createdBy`, `IsActive`, `last_login`) VALUES
(10, 'vuko', 'vukosav.cabarkapa@gmail.com', '2019-02-20 05:52:14', 'vukoc', '31b4c745d89c7c8b47b8857397133f3a5834b9e14249a2de1fa756e62b7ce066', 'f0c0635f16f3cdb42b1c9328a40e6fce', 1, 1, 1, '2019-03-18 08:26:58'),
(17, 'Marko Markovic', 'blnetmlnyp_1551804032@tfbnw.net', '2019-03-13 09:04:36', 'marko', 'cf885f38068e0b39f1a9db9c2ba2372c121473ce38e0c8c97c06c1646a025f9c', 'e8c8d2ccb6afb8d401c19b585546eee4', 2, 1, 1, '2019-03-18 08:30:08'),
(18, 'Janko Jankovic', 'swdaodaigk_1551779965@tfbnw.net', '2019-03-13 09:05:03', 'janko', '34680f28d7f6c44f73bb597967d7696d9ec65665f23781b86b32a4339db99225', 'd0b8bc3f5139c9de8bacfcce34d091d3', 2, 1, 1, '2019-03-13 09:08:49'),
(19, 'Petar Petrovic', 'fzcehmscjs_1549719264@tfbnw.net', '2019-03-13 09:05:27', 'petar', '934c61e8d2efee8df90fd2bed0db5550247f6a1555bb3bde83cc95c7910d2d18', 'e32686ba0d30d3d644fbe3bf2e25ffc3', 2, 1, 1, '2019-03-13 09:11:14'),
(20, 'jelena cabarkapa', 'cabarkapa.jelena@gmail.com', '2019-03-13 09:05:55', 'jelena', 'f9d730aed354757bfd9084494fb56c3fe074d95c2a6d8c8038f7e6abfea8ba4b', '09cdabe7d6ccd6bfb09a12cbd1fdd532', 1, 1, 1, '2019-03-19 10:12:12'),
(21, 'hjghjhj', 'dd@dd.dd', '2019-03-19 07:51:53', 'sfs', '3d1e4e9bc75bd213ff5957c72601bb6dd5c3af2e98007c2fac661699a5f4bb1a', '86c36e362353b60067045940fb259185', 1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

DROP TABLE IF EXISTS `users_session`;
CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hash` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `automatic_groups`
--
ALTER TABLE `automatic_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fb_users`
--
ALTER TABLE `fb_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_parameters`
--
ALTER TABLE `global_parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_in_post`
--
ALTER TABLE `groups_in_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_thread`
--
ALTER TABLE `jobs_thread`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `last_upload_fb_page`
--
ALTER TABLE `last_upload_fb_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `last_upload_fb_user`
--
ALTER TABLE `last_upload_fb_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages_groups`
--
ALTER TABLE `pages_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_pages_groups_pages` (`pageId`),
  ADD KEY `FK_pages_groups_groups` (`groupId`);

--
-- Indexes for table `page_by_hand_in_post`
--
ALTER TABLE `page_by_hand_in_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_statistic`
--
ALTER TABLE `page_statistic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_archive`
--
ALTER TABLE `posts_archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_pages`
--
ALTER TABLE `posts_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_posts_pages_posts` (`postId`),
  ADD KEY `FK_posts_pages_pages` (`pageId`);

--
-- Indexes for table `posts_pages_archive`
--
ALTER TABLE `posts_pages_archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_attachments`
--
ALTER TABLE `post_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_post_attachments_posts` (`post_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_to_finish`
--
ALTER TABLE `task_to_finish`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_roles` (`roleId`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_session_ibfk_1` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `automatic_groups`
--
ALTER TABLE `automatic_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT for table `fb_users`
--
ALTER TABLE `fb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `global_parameters`
--
ALTER TABLE `global_parameters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `groups_in_post`
--
ALTER TABLE `groups_in_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `jobs_thread`
--
ALTER TABLE `jobs_thread`
  MODIFY `job_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=488;

--
-- AUTO_INCREMENT for table `last_upload_fb_page`
--
ALTER TABLE `last_upload_fb_page`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `last_upload_fb_user`
--
ALTER TABLE `last_upload_fb_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `pages_groups`
--
ALTER TABLE `pages_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `page_by_hand_in_post`
--
ALTER TABLE `page_by_hand_in_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1084;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=603;

--
-- AUTO_INCREMENT for table `posts_pages`
--
ALTER TABLE `posts_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1222;

--
-- AUTO_INCREMENT for table `post_attachments`
--
ALTER TABLE `post_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `task_to_finish`
--
ALTER TABLE `task_to_finish`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=871;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pages_groups`
--
ALTER TABLE `pages_groups`
  ADD CONSTRAINT `FK_pages_groups_groups` FOREIGN KEY (`groupId`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `FK_pages_groups_pages` FOREIGN KEY (`pageId`) REFERENCES `pages` (`id`);

--
-- Constraints for table `posts_pages`
--
ALTER TABLE `posts_pages`
  ADD CONSTRAINT `FK_posts_pages_pages` FOREIGN KEY (`pageId`) REFERENCES `pages` (`id`),
  ADD CONSTRAINT `FK_posts_pages_posts` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`);

--
-- Constraints for table `post_attachments`
--
ALTER TABLE `post_attachments`
  ADD CONSTRAINT `FK_post_attachments_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_roles` FOREIGN KEY (`roleId`) REFERENCES `roles` (`id`);

--
-- Constraints for table `users_session`
--
ALTER TABLE `users_session`
  ADD CONSTRAINT `users_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
