-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2019 at 12:31 AM
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

DROP PROCEDURE IF EXISTS `GenerateGlobalStatistics`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GenerateGlobalStatistics` ()  BEGIN




UPDATE  global_statistic
SET control_flag = 1;


INSERT INTO global_statistic(user_id,current_pLast72,current_rLast72,current_cLast72,current_sLast72
,prev_pLast72,prev_rLast72,prev_cLast72,prev_sLast72,control_flag)
SELECT  global_statistic.user_id
,postings72h.p72 current_pLast72
,diffReactions current_rLast72
, diffComments current_cLast72
, diffShares current_sLast72
,ifNull(current_pLast72, 0) AS prev_pLast72
,ifNull(current_cLast72, 0) AS prev_cLast72
,ifNull(current_rLast72, 0)  AS prev_rLast72
,ifNull(current_sLast72, 0)  AS prev_sLast72
,0
FROM global_statistic
JOIN 
(        SELECT users.id user_id,
					sum(s72h.diffReactions) diffReactions
					,sum(s72h.diffComments) diffComments
					,sum(s72h.diffShares)  diffShares
			FROM posts_pages
			LEFT JOIN 
			(
				SELECT users.id user_id
							,(cur.reactions - prev.reactions) diffReactions
							,(cur.comments - prev.comments) diffComments
							,(cur.shares - prev.shares) diffShares
					from statistics72h cur
						   JOIN statistics72h prev ON cur.fbPostId = prev.fbPostId
							WHERE cur.stats_id = 0  AND prev.stats_id = 72
			) s72h 	ON posts_pages.fbPostId = s72h.fbPostId
			JOIN pages ON posts_pages.pageId = pages.id
			JOIN users ON users.id = pages.userId
		   GROUP BY users.id
) statistics72 
ON global_statistic.user_id = statistics72.user_id
JOIN (
SELECT users.id user_id, COUNT(*) p72
FROM posts_pages
JOIN pages ON posts_pages.pageId = pages.id
JOIN users ON pages.userId = users.id
WHERE datePublishedFB > (NOW() - INTERVAL 72 HOUR)
GROUP BY users.id
) postings72h ON global_statistic.user_id = postings72h.user_id;


DELETE FROM global_statistic
WHERE control_flag  = 1;

END$$

DROP PROCEDURE IF EXISTS `GeneratePageDashboardStatistic`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GeneratePageDashboardStatistic` ()  BEGIN 
DELETE FROM  page_dashboard_statistic;
INSERT INTO page_dashboard_statistic (page_id,pageLikes,pageLikes72,current_posts24,current_posts72)

SELECT ifnull(LAST72.page_id, postings72.page_id) page_id
,IFNULL(l.CURRENT_LIKES, 0) CURRENT_LIKES
,IFNULL(l.BEFORE72, 0) BEFORE72
,IFNULL(r.Num_postings24, 0) Num_postings24
,IFNULL(r.Num_postings72, 0) Num_postings72
FROM
(SELECT LAST72.page_id, p72.pageLikes BEFORE72, pCurrent.pageLikes CURRENT_LIKES
FROM 
(SELECT page_id, MAX(lastUpdateLikes) LAST_72
FROM page_statistic  JOIN pages ON page_statistic.page_id = pages.id
WHERE pages.isActive = 1  and lastUpdateLikes  < (NOW() - INTERVAL 72 HOUR)
GROUP BY page_id) LAST72
LEFT JOIN 
(SELECT page_id, MAX(lastUpdateLikes) current_last
FROM page_statistic JOIN pages ON page_statistic.page_id = pages.id
WHERE pages.isActive = 1 
GROUP BY page_id) CURRENT_LAST ON LAST72.page_id = CURRENT_LAST.page_id
JOIN page_statistic p72 ON (p72.page_id = LAST72.page_id AND p72.lastUpdateLikes = LAST72.LAST_72)
JOIN page_statistic pCurrent ON (pCurrent.page_id = CURRENT_LAST.page_id AND pCurrent.lastUpdateLikes = CURRENT_LAST.current_last)
) as l
 cross JOIN
(
 SELECT postings72.page_id, postings72.Num_postings Num_postings72, postings24.Num_postings Num_postings24
 FROM 
(SELECT page_id, COUNT(*) Num_postings
FROM posts_pages
WHERE datePublishedFB > (NOW() - INTERVAL 72 HOUR)
GROUP BY page_id) postings72
LEFT JOIN 
(SELECT page_id, COUNT(*) Num_postings
FROM posts_pages
WHERE datePublishedFB > (NOW() - INTERVAL 24 HOUR)
GROUP BY page_id) postings24 ON postings72.page_id = postings24.page_id
) as r
WHERE l.page_id = r.page_id;
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
	AND PS.postingStatus = 1
    and P.IsActive = 1;
#--	AND PS.job_action = 1;


	UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
SET PS.job_id = new_job_id
WHERE PS.job_id is NULL
   AND P.PostStatus = 3
	AND P.ActionStatus = 1
	AND PS.postingStatus = 1
    and P.IsActive = 1;
										  
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
		
INSERT INTO task_to_finish(job_id, task_end_status, queue_id, active) 
SELECT PS.job_id, 'i-o-ns-2', PS.id, 1
FROM posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
WHERE PS.postId = p_post_id
   AND JT.post_id_owner = p_post_id
   AND JT.user_id_owner = p_user_id
   AND JT.cron_job_id_owner is NULL
	AND P.PostStatus = 3        # QInProgres
	#AND P.ActionStatus = 1      # Ongoing
	AND PS.postingStatus = 2    # In progres
	AND (PS.job_action = 1 OR PS.job_action = 2);		
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
	
       
       
       
       
	
										  
END$$

DROP PROCEDURE IF EXISTS `PreEdit`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PreEdit` (`p_post_id` INT, `p_user_id` INT)  BEGIN

declare v_job_id int;
INSERT INTO  jobs_thread(last_action_time, post_id_owner, user_id_owner) VALUES (NOW(),p_post_id , p_user_id);
SET v_job_id = LAST_INSERT_ID();




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
	
#1 - Draft, 2 - Qwaiting, 3 - QInProgres, 4 - Sent 
#1 - Ongoing, 2 - Paused
#1 - Not started, 2 - In progres, 3 - Finished Success, 4 - Error 
# ------------I-O-I-1/2 -> I-O-I-1/2  -----------------------------------------
UPDATE posts_pages  PS 
JOIN posts P ON PS.postId = P.id 
JOIN jobs_thread JT ON PS.job_id = JT.job_id
SET    JT.post_id_owner  = p_post_id,
      JT.user_id_owner  = p_user_id,
      JT.cron_job_id_owner  = null
WHERE PS.postId = p_post_id 
	AND P.PostStatus = 3        # QInProgres
	AND PS.postingStatus = 2        # QInProgres
	AND (PS.job_action = 1 OR PS.job_action = 2);									  
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
 SET  PostStatus = 1,
 isScheduled = false,
 scheduledTime = null
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
		AND ((posts.PostStatus = 3 or posts.PostStatus = 4) OR posts.ActionStatus is not null OR posts_pages.job_action>1);
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
    DECLARE num_rows_for_update_delete INT;
	
    SELECT COUNT(*) INTO num_rows_for_update_delete
	FROM posts_pages JOIN posts ON posts_pages.postId = posts.id
	WHERE posts_pages.job_action <>1 and posts.id = p_post_id;
    
    
	SELECT COUNT(*) INTO num_rows_on_going
	FROM posts_pages JOIN posts ON posts_pages.postId = posts.id
	WHERE posts.ActionStatus = 1 and posts.id = p_post_id;
	
	SELECT COUNT(*) INTO num_rows_paused
	FROM posts_pages JOIN posts ON posts_pages.postId = posts.id
	WHERE posts.ActionStatus = 2 and posts.id = p_post_id;
	
	SELECT COUNT(*) INTO num_rows_in_progress_sent_error
	FROM posts_pages  JOIN posts ON posts_pages.postId = posts.id
	WHERE (posts_pages.postingStatus = 2 OR posts_pages.postingStatus = 3  OR posts_pages.postingStatus = 4 )
	AND (posts.PostStatus = 3 OR posts.PostStatus = 4)
	and posts_pages.postId = p_post_id;
	 
	if (num_rows_on_going + num_rows_paused + num_rows_in_progress_sent_error + num_rows_for_update_delete) > 0 then
	 RETURN FALSE;
	 else
	 RETURN TRUE;
	 END if;
END$$

DROP FUNCTION IF EXISTS `CountPages`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `CountPages` (`p_postId` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT COUNT(*) AS pages
FROM posts_pages
WHERE posts_pages.postId = p_postId
)$$

DROP FUNCTION IF EXISTS `CountPagesArchive`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `CountPagesArchive` (`p_postId` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT COUNT(*) AS pages
FROM posts_pages_archive
WHERE posts_pages_archive.postId = p_postId
)$$

DROP FUNCTION IF EXISTS `ErrorsForPost`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ErrorsForPost` (`postId` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT  REPLACE(GROUP_CONCAT(ifNull(posts_pages.job_errors,'<br>'),'<br>'),',','') AS job_errors
FROM posts
left JOIN posts_pages ON posts.id = posts_pages.postId
WHERE posts.id = postId
GROUP BY posts.id
 )$$

DROP FUNCTION IF EXISTS `ErrorsForPost_Archive`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ErrorsForPost_Archive` (`postId` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT  REPLACE(GROUP_CONCAT(ifNull(posts_pages_archive.job_errors,'<br>'),'<br>'),',','') AS job_errors
FROM posts_archive
left JOIN posts_pages_archive ON posts_archive.id = posts_pages_archive.postId
WHERE posts_archive.id = postId
GROUP BY posts_archive.id
 )$$

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
CREATE DEFINER=`root`@`localhost` FUNCTION `GroupsForPost` (`p_postId` INT) RETURNS TEXT CHARSET latin1 RETURN (
SELECT  REPLACE(GROUP_CONCAT(ifNull(group_name,'<br>'),'<br>'),',','') AS groups
FROM (SELECT DISTINCT groups.NAME group_name
from  groups_in_post  
 JOIN groups ON groups.id = groups_in_post.groupId
WHERE groups_in_post.postId = p_postId
) a
 )$$

DROP FUNCTION IF EXISTS `PagesForPost`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `PagesForPost` (`p_postId` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT  REPLACE(GROUP_CONCAT(ifNull(pages.fbPageName,'<br>'),'<br>'),',','') AS pages
FROM 
page_by_hand_in_post  
join posts ON posts.id = page_by_hand_in_post.postId
JOIN pages ON pages.id = page_by_hand_in_post.pageId
WHERE page_by_hand_in_post.postId = p_postId
GROUP BY posts.id
 )$$

DROP FUNCTION IF EXISTS `PagesForPostArchive`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `PagesForPostArchive` (`postId` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT  REPLACE(GROUP_CONCAT(ifNull(pages.fbPageName,'<br>'),'<br>'),',','') AS pages
FROM posts_archive
left JOIN posts_pages_archive ON posts_archive.id = posts_pages_archive.postId
left JOIN pages ON pages.id = posts_pages_archive.pageId
WHERE posts_archive.id = postId
GROUP BY posts_archive.id
 )$$

DROP FUNCTION IF EXISTS `PostPagesArchStatCount`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `PostPagesArchStatCount` (`p_postId` INT, `p_status_id` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT COUNT(*) as error
FROM posts_pages_archive
WHERE posts_pages_archive.postId = p_postId AND posts_pages_archive.postingStatus=p_status_id
)$$

DROP FUNCTION IF EXISTS `PostPagesStatCount`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `PostPagesStatCount` (`p_postId` INT, `p_status_id` INT) RETURNS TEXT CHARSET latin1 RETURN (SELECT COUNT(*) as error
FROM posts_pages
WHERE posts_pages.postId = p_postId AND posts_pages.postingStatus=p_status_id
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
(3221, 1, '2019-03-26 22:16:26', '2019-03-26 22:16:29', 1, '_ '),
(3222, 1, '2019-03-26 22:16:50', '2019-03-26 22:16:50', 1, '_ '),
(3223, 1, '2019-03-26 22:17:35', '2019-03-26 22:17:37', 1, '_ '),
(3224, 1, '2019-03-26 22:17:50', '2019-03-26 22:17:51', 1, '_ '),
(3225, 1, '2019-03-26 22:18:50', '2019-03-26 22:18:51', 1, '_ '),
(3226, 1, '2019-03-26 22:19:50', '2019-03-26 22:19:51', 1, '_ '),
(3227, 1, '2019-03-26 22:20:50', '2019-03-26 22:20:51', 1, '_ '),
(3228, 1, '2019-03-26 22:21:50', '2019-03-26 22:21:51', 1, '_ '),
(3229, 1, '2019-03-26 22:22:50', '2019-03-26 22:22:51', 1, '_ '),
(3230, 1, '2019-03-26 22:23:50', '2019-03-26 22:23:50', 1, '_ '),
(3231, 1, '2019-03-26 22:24:50', '2019-03-26 22:24:51', 1, '_ '),
(3232, 1, '2019-03-26 22:25:50', '2019-03-26 22:25:51', 1, '_ '),
(3233, 1, '2019-03-26 22:26:50', '2019-03-26 22:26:51', 1, '_ '),
(3234, 1, '2019-03-26 22:27:50', '2019-03-26 22:27:51', 1, '_ '),
(3235, 1, '2019-03-26 22:28:50', '2019-03-26 22:28:51', 1, '_ '),
(3236, 1, '2019-03-26 22:29:50', '2019-03-26 22:29:51', 1, '_ '),
(3237, 1, '2019-03-26 22:30:50', '2019-03-26 22:30:51', 1, '_ '),
(3238, 1, '2019-03-26 22:31:50', '2019-03-26 22:31:51', 1, '_ '),
(3239, 1, '2019-03-26 22:32:50', '2019-03-26 22:32:51', 1, '_ '),
(3240, 1, '2019-03-26 22:33:50', '2019-03-26 22:33:51', 1, '_ '),
(3241, 1, '2019-03-26 22:34:50', '2019-03-26 22:34:51', 1, '_ '),
(3242, 1, '2019-03-26 22:35:50', '2019-03-26 22:35:51', 1, '_ '),
(3243, 1, '2019-03-26 22:36:50', '2019-03-26 22:36:51', 1, '_ '),
(3244, 1, '2019-03-26 22:37:50', '2019-03-26 22:37:51', 1, '_ '),
(3245, 1, '2019-03-26 22:38:50', '2019-03-26 22:38:51', 1, '_ '),
(3246, 1, '2019-03-26 22:39:50', '2019-03-26 22:39:51', 1, '_ '),
(3247, 1, '2019-03-26 22:40:50', '2019-03-26 22:40:51', 1, '_ '),
(3248, 1, '2019-03-26 22:41:50', '2019-03-26 22:41:51', 1, '_ '),
(3249, 1, '2019-03-26 22:42:50', '2019-03-26 22:42:51', 1, '_ '),
(3250, 1, '2019-03-26 22:43:50', '2019-03-26 22:43:51', 1, '_ '),
(3251, 1, '2019-03-26 22:44:50', '2019-03-26 22:44:50', 1, '_ '),
(3252, 1, '2019-03-26 22:45:50', '2019-03-26 22:45:51', 1, '_ '),
(3253, 1, '2019-03-26 22:46:50', '2019-03-26 22:46:50', 1, '_ '),
(3254, 1, '2019-03-26 22:47:50', '2019-03-26 22:47:51', 1, '_ '),
(3255, 1, '2019-03-26 22:48:50', '2019-03-26 22:48:51', 1, '_ '),
(3256, 1, '2019-03-26 22:49:50', '2019-03-26 22:49:51', 1, '_ '),
(3257, 1, '2019-03-26 22:50:50', '2019-03-26 22:50:51', 1, '_ '),
(3258, 1, '2019-03-26 22:51:50', '2019-03-26 22:51:51', 1, '_ '),
(3259, 1, '2019-03-26 22:52:51', '2019-03-26 22:52:51', 1, '_ '),
(3260, 1, '2019-03-26 22:53:50', '2019-03-26 22:53:51', 1, '_ '),
(3261, 1, '2019-03-26 22:54:50', '2019-03-26 22:54:51', 1, '_ '),
(3262, 1, '2019-03-26 22:55:50', '2019-03-26 22:55:51', 1, '_ '),
(3263, 1, '2019-03-26 22:56:50', '2019-03-26 22:56:50', 1, '_ '),
(3264, 1, '2019-03-26 22:57:50', '2019-03-26 22:57:51', 1, '_ '),
(3265, 1, '2019-03-26 22:58:50', '2019-03-26 22:58:51', 1, '_ '),
(3266, 1, '2019-03-26 22:59:50', '2019-03-26 22:59:51', 1, '_ '),
(3267, 1, '2019-03-26 23:00:50', '2019-03-26 23:00:51', 1, '_ '),
(3268, 1, '2019-03-26 23:01:50', '2019-03-26 23:01:50', 1, '_ '),
(3269, 1, '2019-03-26 23:02:50', '2019-03-26 23:02:51', 1, '_ '),
(3270, 1, '2019-03-26 23:03:50', '2019-03-26 23:03:50', 1, '_ '),
(3271, 1, '2019-03-26 23:04:50', '2019-03-26 23:04:51', 1, '_ '),
(3272, 1, '2019-03-26 23:05:50', '2019-03-26 23:05:51', 1, '_ '),
(3273, 1, '2019-03-26 23:06:50', '2019-03-26 23:06:51', 1, '_ '),
(3274, 1, '2019-03-26 23:07:50', '2019-03-26 23:07:50', 1, '_ '),
(3275, 1, '2019-03-26 23:08:50', '2019-03-26 23:08:51', 1, '_ '),
(3276, 1, '2019-03-26 23:09:50', '2019-03-26 23:09:51', 1, '_ '),
(3277, 1, '2019-03-26 23:10:50', '2019-03-26 23:10:51', 1, '_ '),
(3278, 1, '2019-03-26 23:11:50', '2019-03-26 23:11:51', 1, '_ '),
(3279, 1, '2019-03-26 23:12:50', '2019-03-26 23:12:51', 1, '_ '),
(3280, 1, '2019-03-26 23:13:50', '2019-03-26 23:13:51', 1, '_ '),
(3281, 1, '2019-03-26 23:14:50', '2019-03-26 23:14:51', 1, '_ '),
(3282, 1, '2019-03-26 23:15:50', '2019-03-26 23:15:51', 1, '_ '),
(3283, 1, '2019-03-26 23:16:50', '2019-03-26 23:16:51', 1, '_ '),
(3284, 1, '2019-03-26 23:17:50', '2019-03-26 23:17:51', 1, '_ '),
(3285, 1, '2019-03-26 23:18:50', '2019-03-26 23:18:51', 1, '_ '),
(3286, 1, '2019-03-26 23:19:50', '2019-03-26 23:19:50', 1, '_ '),
(3287, 1, '2019-03-26 23:20:50', '2019-03-26 23:20:51', 1, '_ '),
(3288, 1, '2019-03-26 23:21:50', '2019-03-26 23:21:51', 1, '_ '),
(3289, 1, '2019-03-26 23:22:50', '2019-03-26 23:22:51', 1, '_ '),
(3290, 1, '2019-03-26 23:23:50', '2019-03-26 23:23:51', 1, '_ '),
(3291, 1, '2019-03-26 23:24:50', '2019-03-26 23:24:51', 1, '_ '),
(3292, 1, '2019-03-26 23:25:51', '2019-03-26 23:25:51', 1, '_ '),
(3293, 1, '2019-03-26 23:26:50', '2019-03-26 23:26:50', 1, '_ '),
(3294, 1, '2019-03-26 23:27:50', '2019-03-26 23:27:51', 1, '_ '),
(3295, 1, '2019-03-26 23:28:50', '2019-03-26 23:28:51', 1, '_ '),
(3296, 1, '2019-03-26 23:29:50', '2019-03-26 23:29:51', 1, '_ '),
(3297, 1, '2019-03-26 23:30:50', '2019-03-26 23:30:51', 1, '_ '),
(3298, 1, '2019-03-26 23:31:50', '2019-03-26 23:31:51', 1, '_ '),
(3299, 1, '2019-03-26 23:32:50', '2019-03-26 23:32:51', 1, '_ '),
(3300, 1, '2019-03-26 23:33:50', '2019-03-26 23:33:51', 1, '_ '),
(3301, 1, '2019-03-26 23:34:50', '2019-03-26 23:34:52', 1, '_ '),
(3302, 1, '2019-03-26 23:35:50', '2019-03-26 23:35:51', 1, '_ '),
(3303, 1, '2019-03-26 23:36:50', '2019-03-26 23:36:51', 1, '_ '),
(3304, 1, '2019-03-26 23:37:50', '2019-03-26 23:37:51', 1, '_ '),
(3305, 1, '2019-03-26 23:38:50', '2019-03-26 23:38:51', 1, '_ '),
(3306, 1, '2019-03-26 23:39:50', '2019-03-26 23:39:51', 1, '_ '),
(3307, 1, '2019-03-26 23:40:50', '2019-03-26 23:40:51', 1, '_ '),
(3308, 1, '2019-03-26 23:41:50', '2019-03-26 23:41:51', 1, '_ '),
(3309, 1, '2019-03-26 23:42:50', '2019-03-26 23:42:51', 1, '_ '),
(3310, 1, '2019-03-26 23:43:50', '2019-03-26 23:43:51', 1, '_ '),
(3311, 1, '2019-03-26 23:44:50', '2019-03-26 23:44:51', 1, '_ '),
(3312, 1, '2019-03-26 23:45:50', '2019-03-26 23:45:51', 1, '_ '),
(3313, 1, '2019-03-26 23:46:50', '2019-03-26 23:46:51', 1, '_ '),
(3314, 1, '2019-03-26 23:47:50', '2019-03-26 23:47:51', 1, '_ '),
(3315, 1, '2019-03-26 23:48:50', '2019-03-26 23:48:51', 1, '_ '),
(3316, 1, '2019-03-26 23:49:50', '2019-03-26 23:49:51', 1, '_ '),
(3317, 1, '2019-03-26 23:50:50', '2019-03-26 23:50:51', 1, '_ '),
(3318, 1, '2019-03-26 23:51:50', '2019-03-26 23:51:51', 1, '_ '),
(3319, 1, '2019-03-26 23:52:50', '2019-03-26 23:52:51', 1, '_ '),
(3320, 1, '2019-03-26 23:54:50', '2019-03-26 23:54:51', 1, '_ '),
(3321, 1, '2019-03-26 23:55:50', '2019-03-26 23:55:51', 1, '_ '),
(3322, 1, '2019-03-26 23:56:50', '2019-03-26 23:56:51', 1, '_ '),
(3323, 1, '2019-03-26 23:57:50', '2019-03-26 23:57:53', 1, '_ '),
(3324, 1, '2019-03-26 23:58:50', '2019-03-26 23:58:52', 1, '_ '),
(3325, 1, '2019-03-26 23:59:50', '2019-03-26 23:59:51', 1, '_ '),
(3326, 1, '2019-03-27 00:00:50', '2019-03-27 00:00:51', 1, '_ '),
(3327, 1, '2019-03-27 00:01:50', '2019-03-27 00:01:51', 1, '_ '),
(3328, 1, '2019-03-27 00:02:50', '2019-03-27 00:02:51', 1, '_ '),
(3329, 1, '2019-03-27 00:03:50', '2019-03-27 00:03:53', 1, '_ '),
(3330, 1, '2019-03-27 00:04:50', '2019-03-27 00:04:51', 1, '_ '),
(3331, 1, '2019-03-27 00:05:50', '2019-03-27 00:05:51', 1, '_ '),
(3332, 1, '2019-03-27 00:06:50', '2019-03-27 00:06:51', 1, '_ '),
(3333, 1, '2019-03-27 00:07:50', '2019-03-27 00:07:51', 1, '_ '),
(3334, 1, '2019-03-27 00:08:50', '2019-03-27 00:08:52', 1, '_ '),
(3335, 1, '2019-03-27 00:09:50', '2019-03-27 00:09:51', 1, '_ '),
(3336, 1, '2019-03-27 00:10:50', '2019-03-27 00:10:51', 1, '_ '),
(3337, 1, '2019-03-27 00:11:50', '2019-03-27 00:11:51', 1, '_ '),
(3338, 1, '2019-03-27 00:12:50', '2019-03-27 00:12:51', 1, '_ '),
(3339, 1, '2019-03-27 00:13:50', '2019-03-27 00:13:58', 1, '_ '),
(3340, 1, '2019-03-27 00:14:51', '2019-03-27 00:14:51', 1, '_ '),
(3341, 1, '2019-03-27 00:15:50', '2019-03-27 00:15:51', 1, '_ '),
(3342, 1, '2019-03-27 00:16:50', '2019-03-27 00:16:51', 1, '_ '),
(3343, 1, '2019-03-27 00:17:50', '2019-03-27 00:17:51', 1, '_ '),
(3344, 1, '2019-03-27 00:18:50', '2019-03-27 00:18:51', 1, '_ '),
(3345, 1, '2019-03-27 00:19:50', '2019-03-27 00:19:51', 1, '_ '),
(3346, 1, '2019-03-27 00:20:50', '2019-03-27 00:20:51', 1, '_ '),
(3347, 1, '2019-03-27 00:21:50', '2019-03-27 00:21:51', 1, '_ '),
(3348, 1, '2019-03-27 00:22:50', '2019-03-27 00:22:51', 1, '_ '),
(3349, 1, '2019-03-27 00:23:50', '2019-03-27 00:23:52', 1, '_ '),
(3350, 1, '2019-03-27 00:24:50', '2019-03-27 00:24:51', 1, '_ '),
(3351, 1, '2019-03-27 00:25:50', '2019-03-27 00:25:51', 1, '_ '),
(3352, 1, '2019-03-27 00:26:50', '2019-03-27 00:26:51', 1, '_ '),
(3353, 1, '2019-03-27 00:27:50', '2019-03-27 00:27:51', 1, '_ '),
(3354, 1, '2019-03-27 00:28:51', '2019-03-27 00:28:51', 1, '_ '),
(3355, 1, '2019-03-27 00:29:50', '2019-03-27 00:29:51', 1, '_ '),
(3356, 1, '2019-03-27 00:30:50', '2019-03-27 00:30:51', 1, '_ ');

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
  `user_id` int(11) NOT NULL,
  `last_fbupdate` datetime DEFAULT NULL,
  `fbat_valid` int(11) DEFAULT '1',
  `fbat_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fb_users`
--

INSERT INTO `fb_users` (`id`, `fb_user_id`, `fb_name`, `fb_access_token`, `user_id`, `last_fbupdate`, `fbat_valid`, `fbat_expires`) VALUES
(8, '104788047350548', 'Carol Alcdehjehhdie Rosenthalsky', 'EAAHKRllr1hkBABywNNwS3T8w3z4z6v7ZAFYPQe90ZCf69IeYYAuJnR655fdld9ck5tlxOHAPHzNPCiMnMr7KR5Nb3bDjK9zskEq4mrGQlNniu0cT2ndgllgduwFQQ0MyhCmWSNgIFr9OXyke3glsoJZCczlAPZCj8szdw8iky9ozWMF4O2ZC3', 17, NULL, 1, NULL),
(9, '106975337129264', 'Sophia Alcdejcidbibi Sadanson', 'EAAHKRllr1hkBAOQurHCeooZAKC0oKWPsH7RZBySvQJW4jTadZBDrlJ8vM8ew6ILbCaTN85gtR5PBhZA6ZCbs4OYM5CfEboH3IEYgtc4BIyBU24mGpNxnxZCf7ZBE6gZBffff95rKZCm3dQzRYw2l0IkbvHDeeUe8G1RY7tvbH87l9PmGonIIHYANE', 18, NULL, 1, NULL),
(10, '100962211045487', 'Dave Alccieabdbcjd Carrieroson', 'EAAHKRllr1hkBALKRWveru1KgNW9ZAYX0MT0queuZBU2hef9VR16C2odefJZCvD8BFhrZAUZBb3fdHeTNtJgvVeFxmsGC5LPSTM9ko3ZC4FkG5AGJRKGBLj1xJH5aRecQvsi8ZAdKMv926HL4DHp4xNbZBQv27pvrXAWoiCUCG5nN40tyiyYTP728', 19, NULL, 1, NULL),
(11, '104189817385560', 'Olivia Olivia', 'EAAHKRllr1hkBABPIBAj00JzsB29ZAqZBSrjRiTuwiOTvm7f9T7hgGmkVOqRsuepPEJQTUbbiC4TRGfZC4cPrFLsbjDTdZB7nSXuu0NhbDZAm5ecBqj2OPTZAzZCtIxPznfZAFqT7lfGMx9mx79fpcsXB7NABx1yRX61vODmVYIQHhA97yPLQAFZA2', 20, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `global_parameters`
--

DROP TABLE IF EXISTS `global_parameters`;
CREATE TABLE `global_parameters` (
  `id` int(10) UNSIGNED NOT NULL,
  `period_in_sec_fb` int(11) NOT NULL,
  `App_time_zone` varchar(128) NOT NULL,
  `user_or_page` int(11) NOT NULL,
  `FB_periods` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `global_parameters`
--

INSERT INTO `global_parameters` (`id`, `period_in_sec_fb`, `App_time_zone`, `user_or_page`, `FB_periods`) VALUES
(1, 20, 'America/Detroit', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `global_statistic`
--

DROP TABLE IF EXISTS `global_statistic`;
CREATE TABLE `global_statistic` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_pLast72` int(11) DEFAULT NULL COMMENT 'postovi u zadnjih 71',
  `current_rLast72` int(11) DEFAULT NULL COMMENT 'reakcije  u zadnjih 71',
  `control_flag` int(11) NOT NULL DEFAULT '0',
  `current_cLast72` int(11) DEFAULT NULL COMMENT 'komentari  u zadnjih 71',
  `current_sLast72` int(11) DEFAULT NULL COMMENT 'share  u zadnjih 71',
  `prev_pLast72` int(11) NOT NULL DEFAULT '0',
  `prev_rLast72` int(11) NOT NULL DEFAULT '0',
  `prev_cLast72` int(11) NOT NULL DEFAULT '0',
  `prev_sLast72` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `global_statistic`
--

INSERT INTO `global_statistic` (`id`, `user_id`, `current_pLast72`, `current_rLast72`, `control_flag`, `current_cLast72`, `current_sLast72`, `prev_pLast72`, `prev_rLast72`, `prev_cLast72`, `prev_sLast72`) VALUES
(1, 0, 1233432432, 45, 0, 56, 654, 0, 0, 0, 0);

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
(76, 'marko2', '2019-03-13 09:20:03', 17, 1),
(86, 'DAVEGROUP1', '2019-03-21 09:37:26', 19, 1),
(87, 'DAVEGROUP2', '2019-03-21 09:37:38', 19, 1),
(88, 'Prva', '2019-03-21 11:59:58', 18, 1);

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
(1, 860, 74, 40),
(2, 860, 74, 39);

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
(3715, 3221, '2019-03-26 22:16:29', NULL, NULL, NULL),
(3716, 3222, '2019-03-26 22:16:50', NULL, NULL, NULL),
(3717, 3223, '2019-03-26 22:17:37', NULL, NULL, NULL),
(3718, 3224, '2019-03-26 22:17:51', NULL, NULL, NULL),
(3719, 3225, '2019-03-26 22:18:51', NULL, NULL, NULL),
(3720, 3226, '2019-03-26 22:19:51', NULL, NULL, NULL),
(3721, 3227, '2019-03-26 22:20:51', NULL, NULL, NULL),
(3722, 3228, '2019-03-26 22:21:51', NULL, NULL, NULL),
(3723, 3229, '2019-03-26 22:22:50', NULL, NULL, NULL),
(3724, 3230, '2019-03-26 22:23:50', NULL, NULL, NULL),
(3725, 3231, '2019-03-26 22:24:51', NULL, NULL, NULL),
(3726, 3232, '2019-03-26 22:25:50', NULL, NULL, NULL),
(3727, 3233, '2019-03-26 22:26:51', NULL, NULL, NULL),
(3728, 3234, '2019-03-26 22:27:50', NULL, NULL, NULL),
(3729, 3235, '2019-03-26 22:28:50', NULL, NULL, NULL),
(3730, 3236, '2019-03-26 22:29:50', NULL, NULL, NULL),
(3731, 3237, '2019-03-26 22:30:50', NULL, NULL, NULL),
(3732, 3238, '2019-03-26 22:31:50', NULL, NULL, NULL),
(3733, 3239, '2019-03-26 22:32:50', NULL, NULL, NULL),
(3734, 3240, '2019-03-26 22:33:51', NULL, NULL, NULL),
(3735, 3241, '2019-03-26 22:34:51', NULL, NULL, NULL),
(3736, 3242, '2019-03-26 22:35:50', NULL, NULL, NULL),
(3737, 3243, '2019-03-26 22:36:50', NULL, NULL, NULL),
(3738, 3244, '2019-03-26 22:37:51', NULL, NULL, NULL),
(3739, 3245, '2019-03-26 22:38:51', NULL, NULL, NULL),
(3740, 3246, '2019-03-26 22:39:50', NULL, NULL, NULL),
(3741, 3247, '2019-03-26 22:40:50', NULL, NULL, NULL),
(3742, 3248, '2019-03-26 22:41:51', NULL, NULL, NULL),
(3743, 3249, '2019-03-26 22:42:50', NULL, NULL, NULL),
(3744, 3250, '2019-03-26 22:43:50', NULL, NULL, NULL),
(3745, 3251, '2019-03-26 22:44:50', NULL, NULL, NULL),
(3746, 3252, '2019-03-26 22:45:51', NULL, NULL, NULL),
(3747, 3253, '2019-03-26 22:46:50', NULL, NULL, NULL),
(3748, 3254, '2019-03-26 22:47:50', NULL, NULL, NULL),
(3749, 3255, '2019-03-26 22:48:50', NULL, NULL, NULL),
(3750, 3256, '2019-03-26 22:49:51', NULL, NULL, NULL),
(3751, 3257, '2019-03-26 22:50:50', NULL, NULL, NULL),
(3752, 3258, '2019-03-26 22:51:51', NULL, NULL, NULL),
(3753, 3259, '2019-03-26 22:52:51', NULL, NULL, NULL),
(3754, 3260, '2019-03-26 22:53:51', NULL, NULL, NULL),
(3755, 3261, '2019-03-26 22:54:50', NULL, NULL, NULL),
(3756, 3262, '2019-03-26 22:55:50', NULL, NULL, NULL),
(3757, 3263, '2019-03-26 22:56:50', NULL, NULL, NULL),
(3758, 3264, '2019-03-26 22:57:51', NULL, NULL, NULL),
(3759, 3265, '2019-03-26 22:58:51', NULL, NULL, NULL),
(3760, 3266, '2019-03-26 22:59:51', NULL, NULL, NULL),
(3761, 3267, '2019-03-26 23:00:50', NULL, NULL, NULL),
(3762, 3268, '2019-03-26 23:01:50', NULL, NULL, NULL),
(3763, 3269, '2019-03-26 23:02:50', NULL, NULL, NULL),
(3764, 3270, '2019-03-26 23:03:50', NULL, NULL, NULL),
(3765, 3271, '2019-03-26 23:04:50', NULL, NULL, NULL),
(3766, 3272, '2019-03-26 23:05:51', NULL, NULL, NULL),
(3767, 3273, '2019-03-26 23:06:50', NULL, NULL, NULL),
(3768, 3274, '2019-03-26 23:07:50', NULL, NULL, NULL),
(3769, 3275, '2019-03-26 23:08:51', NULL, NULL, NULL),
(3770, 3276, '2019-03-26 23:09:51', NULL, NULL, NULL),
(3771, 3277, '2019-03-26 23:10:50', NULL, NULL, NULL),
(3772, 3278, '2019-03-26 23:11:51', NULL, NULL, NULL),
(3773, 3279, '2019-03-26 23:12:50', NULL, NULL, NULL),
(3774, 3280, '2019-03-26 23:13:51', NULL, NULL, NULL),
(3775, 3281, '2019-03-26 23:14:50', NULL, NULL, NULL),
(3776, 3282, '2019-03-26 23:15:51', NULL, NULL, NULL),
(3777, 3283, '2019-03-26 23:16:51', NULL, NULL, NULL),
(3778, 3284, '2019-03-26 23:17:51', NULL, NULL, NULL),
(3779, 3285, '2019-03-26 23:18:50', NULL, NULL, NULL),
(3780, 3286, '2019-03-26 23:19:50', NULL, NULL, NULL),
(3781, 3287, '2019-03-26 23:20:50', NULL, NULL, NULL),
(3782, 3288, '2019-03-26 23:21:51', NULL, NULL, NULL),
(3783, 3289, '2019-03-26 23:22:51', NULL, NULL, NULL),
(3784, 3290, '2019-03-26 23:23:50', NULL, NULL, NULL),
(3785, 3291, '2019-03-26 23:24:50', NULL, NULL, NULL),
(3786, 3292, '2019-03-26 23:25:51', NULL, NULL, NULL),
(3787, 3293, '2019-03-26 23:26:50', NULL, NULL, NULL),
(3788, 3294, '2019-03-26 23:27:50', NULL, NULL, NULL),
(3789, 3295, '2019-03-26 23:28:51', NULL, NULL, NULL),
(3790, 3296, '2019-03-26 23:29:50', NULL, NULL, NULL),
(3791, 3297, '2019-03-26 23:30:51', NULL, NULL, NULL),
(3792, 3298, '2019-03-26 23:31:50', NULL, NULL, NULL),
(3793, 3299, '2019-03-26 23:32:51', NULL, NULL, NULL),
(3794, 3300, '2019-03-26 23:33:50', NULL, NULL, NULL),
(3795, 3301, '2019-03-26 23:34:52', NULL, NULL, NULL),
(3796, 3302, '2019-03-26 23:35:50', NULL, NULL, NULL),
(3797, 3303, '2019-03-26 23:36:51', NULL, NULL, NULL),
(3798, 3304, '2019-03-26 23:37:51', NULL, NULL, NULL),
(3799, 3305, '2019-03-26 23:38:51', NULL, NULL, NULL),
(3800, 3306, '2019-03-26 23:39:51', NULL, NULL, NULL),
(3801, 3307, '2019-03-26 23:40:50', NULL, NULL, NULL),
(3802, 3308, '2019-03-26 23:41:51', NULL, NULL, NULL),
(3803, 3309, '2019-03-26 23:42:50', NULL, NULL, NULL),
(3804, 3310, '2019-03-26 23:43:51', NULL, NULL, NULL),
(3805, 3311, '2019-03-26 23:44:51', NULL, NULL, NULL),
(3806, 3312, '2019-03-26 23:45:51', NULL, NULL, NULL),
(3807, 3313, '2019-03-26 23:46:51', NULL, NULL, NULL),
(3808, 3314, '2019-03-26 23:47:51', NULL, NULL, NULL),
(3809, 3315, '2019-03-26 23:48:50', NULL, NULL, NULL),
(3810, 3316, '2019-03-26 23:49:51', NULL, NULL, NULL),
(3811, 3317, '2019-03-26 23:50:50', NULL, NULL, NULL),
(3812, 3318, '2019-03-26 23:51:51', NULL, NULL, NULL),
(3813, 3319, '2019-03-26 23:52:51', NULL, NULL, NULL),
(3814, 3320, '2019-03-26 23:54:51', NULL, NULL, NULL),
(3815, 3321, '2019-03-26 23:55:50', NULL, NULL, NULL),
(3816, 3322, '2019-03-26 23:56:51', NULL, NULL, NULL),
(3817, 3323, '2019-03-26 23:57:53', NULL, NULL, NULL),
(3818, 3324, '2019-03-26 23:58:52', NULL, NULL, NULL),
(3819, 3325, '2019-03-26 23:59:51', NULL, NULL, NULL),
(3820, 3326, '2019-03-27 00:00:51', NULL, NULL, NULL),
(3821, 3327, '2019-03-27 00:01:51', NULL, NULL, NULL),
(3822, 3328, '2019-03-27 00:02:50', NULL, NULL, NULL),
(3823, 3329, '2019-03-27 00:03:52', NULL, NULL, NULL),
(3824, 3330, '2019-03-27 00:04:50', NULL, NULL, NULL),
(3825, 3331, '2019-03-27 00:05:51', NULL, NULL, NULL),
(3826, 3332, '2019-03-27 00:06:50', NULL, NULL, NULL),
(3827, 3333, '2019-03-27 00:07:51', NULL, NULL, NULL),
(3828, 3334, '2019-03-27 00:08:52', NULL, NULL, NULL),
(3829, 3335, '2019-03-27 00:09:50', NULL, NULL, NULL),
(3830, 3336, '2019-03-27 00:10:51', NULL, NULL, NULL),
(3831, 3337, '2019-03-27 00:11:51', NULL, NULL, NULL),
(3832, 3338, '2019-03-27 00:12:51', NULL, NULL, NULL),
(3833, 3339, '2019-03-27 00:13:58', NULL, NULL, NULL),
(3834, 3340, '2019-03-27 00:14:51', NULL, NULL, NULL),
(3835, 3341, '2019-03-27 00:15:50', NULL, NULL, NULL),
(3836, 3342, '2019-03-27 00:16:50', NULL, NULL, NULL),
(3837, 3343, '2019-03-27 00:17:51', NULL, NULL, NULL),
(3838, 3344, '2019-03-27 00:18:51', NULL, NULL, NULL),
(3839, 3345, '2019-03-27 00:19:50', NULL, NULL, NULL),
(3840, 3346, '2019-03-27 00:20:51', NULL, NULL, NULL),
(3841, 3347, '2019-03-27 00:21:51', NULL, NULL, NULL),
(3842, 3348, '2019-03-27 00:22:51', NULL, NULL, NULL),
(3843, 3349, '2019-03-27 00:23:52', NULL, NULL, NULL),
(3844, 3350, '2019-03-27 00:24:51', NULL, NULL, NULL),
(3845, 3351, '2019-03-27 00:25:51', NULL, NULL, NULL),
(3846, 3352, '2019-03-27 00:26:50', NULL, NULL, NULL),
(3847, 3353, '2019-03-27 00:27:51', NULL, NULL, NULL),
(3848, 3354, '2019-03-27 00:28:51', NULL, NULL, NULL),
(3849, 3355, '2019-03-27 00:29:51', NULL, NULL, NULL),
(3850, 3356, '2019-03-27 00:30:51', NULL, NULL, NULL);

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
(1, '777736072599375', '2019-03-26 22:17:37'),
(2, 'page1', '2019-03-13 19:39:13'),
(3, '541140996398061', '2019-03-27 00:13:52'),
(4, '971438483243979', '2019-03-27 00:13:54'),
(5, '246671336217871', '2019-03-27 00:08:52'),
(6, '264447761139100', '2019-03-27 00:03:52'),
(7, '364324417746132', '2019-03-27 00:23:52'),
(8, '2259650144248017', '2019-03-27 00:13:56'),
(9, '2201075073542677', '2019-03-27 00:13:58'),
(10, '344756762805314', '2019-03-26 14:04:29'),
(11, '640299693073413', '2019-03-26 14:06:08'),
(12, '643579096105954', '2019-03-26 14:08:08'),
(13, '303069253739492', '2019-03-26 22:16:28'),
(14, '387076882081892', '2019-03-26 22:16:29'),
(15, '2291514561060121', '2019-03-24 01:50:08'),
(16, '2311412742471909', '2019-03-24 01:50:31');

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
(1, '104189817385560', '2019-03-27 00:23:52'),
(2, '104788047350548', '2019-03-23 16:42:56'),
(3, '106975337129264', '2019-03-26 14:08:08'),
(4, '100962211045487', '2019-03-26 22:16:29');

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
  `fbPageAT` text NOT NULL,
  `timezone` varchar(128) DEFAULT NULL,
  `last_fbupdate` datetime DEFAULT NULL,
  `fbat_valid` int(11) DEFAULT '1',
  `fbat_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `fbPageId`, `fbPageName`, `dateAdded`, `userId`, `isActive`, `fbPageAT`, `timezone`, `last_fbupdate`, `fbat_valid`, `fbat_expires`) VALUES
(26, '246671336217871', 'Datadattest1', '2019-03-13 21:07:35', 17, 1, 'EAAHKRllr1hkBAOS8PA6ow4EdkvJij4gOKl17NWNDPhmZBiCW2HKxpWrEePYtQ1oPeLOITbsHEmNvg4JTF7jlBjjXBzJNEmiSsxRSiheuhBnq9CdTpZBEghnRaeAOypWBWRuPDr17EZBZASBLU2nwCzmxxyXnfuw16rsdndj9aLtRKxH2U62GRZAACa3BeW1EZD', NULL, NULL, 1, NULL),
(27, '264447761139100', 'Datadattest2', '2019-03-13 21:07:35', 17, 1, 'EAAHKRllr1hkBALHagtK1pyFTFAOi0V7SftWrgwsshvrPkfZCW4fLoC82N0maZB7K4s1xuwwXbgsIO9HMVjyOBbrFCtulQtpbTRdyKZCnQQe6KuqoEKnMZA3ZCU1CZCrMf64j5yOmLvpy0luVDH63cHcD9V9LZBfZCMirY8eYJqfSZC63bZBeFPvZCqpUZBTvSRUZAWQQZD', NULL, NULL, 1, NULL),
(28, '364324417746132', 'Datadattest3', '2019-03-13 21:07:35', 17, 1, 'EAAHKRllr1hkBAPf2KiuZBaTUY7exOiVxRxmSq7If6efy1vVdvRM2PQwwBBCO196SF3L8cCGypBANrsXs4V4E4YCR01cyXexW6qSePjXtagAKsZCPIiC5xjkYD17RZB7r9YiuZAWKyeWJC5HBMhQKJoNH66A2GYNK1USJZBv0me9oY9KsUHjFWiiLoI4kLoyUZD', NULL, NULL, 1, NULL),
(29, '344756762805314', 'Datadattest6', '2019-03-13 21:10:26', 18, 1, 'EAAHKRllr1hkBAI4W0B7uwneX5ZCVWMc7iA4fZByp8CYQTbWec5UknHo34sCsBMSTtR2JYoSLL3ZAMJbYTzBR9lmrqfVho7RbabHmtVLTry7NsclGkmsX32INmDrXd6L2tzAPSdG129ZB9XxtPYdptyIAFp5qrba6XXogFcSSEyIOgduyjCoRbz0GKN213tIZD', NULL, NULL, 1, NULL),
(30, '640299693073413', 'Datadattest4', '2019-03-13 21:10:26', 18, 1, 'EAAHKRllr1hkBAOq8PLMJXddC3DjJiXmHsXX7s5n40IFjbk0qJA21eH1dwuNSpLG6Ufn30K6zvmfupp7kbf9iN86VXd8ZB3kW1I87IimDbE5rBbpyYv4ZCCCFbRQHZA95ZCZCr5CwgLZAuK0FeVLLC0hJ4qpiyTzeLLCQvXyjCuVSN1mKdmPQ0iUGfrddWlruEZD', NULL, NULL, 1, NULL),
(31, '643579096105954', 'Datadattest5', '2019-03-13 21:10:26', 18, 1, 'EAAHKRllr1hkBAOtDlvl96whUhf9XEjhFBAGbE90I1w8zqCTi4N1RZBRZBplouHsZC90caXzMLx5kD5dqVhzE7xDL66zKXJnZBWGNKCU3P7m2QQZBvZCs7Oq5f35BiqXspoZAtwAahWyvC5EPGfKo1WjlwkOnFAyNWIJDG96qRzZBrDPRDdakpFclvxcyjrY86G0ZD', NULL, NULL, 1, NULL),
(32, '303069253739492', 'Page Dave One', '2019-03-13 21:13:58', 19, 1, 'EAAHKRllr1hkBAH5c6gtzOPqtjAZCaMe27KVnWqHwGFXp315i671oZB43sDSZAz9EKs5dZBa3tYMZA62SeLwyTZCqpKFIWyHBEuYw1cmZBqgLOMWZBD9UEUi05Sjo9sIBAnXj3ZCcpnlbIkal9Xzt3kZAWCt9Dk4Cl1Iei3c9tY9IsG1cFNxqpFWfZBMflLa8ni3uxIZD', NULL, NULL, 1, NULL),
(33, '387076882081892', 'Datadattest9', '2019-03-13 21:13:58', 19, 1, 'EAAHKRllr1hkBAE19DNSs4XidXG5uWLVIdCTg1ESvJAA4UHB6yZBlfP3cGZCEUsFjeqT1tlcHcvEmZBxjNyT0ZCS4L2CT5ZC5NQ3xGMkX9g5KIWCVXnbLa7K2gApF3TeNRdgfFsTkuSLK3COkdu5JfXPZBxqHhuf98YxyucG1sZA2bMZCZC5IIyPTpRtJV8g5x07IZD', NULL, NULL, 1, NULL),
(34, '2291514561060121', 'Datadattest7', '2019-03-13 21:13:58', 19, 1, 'EAAHKRllr1hkBADNKuJcxTYmMW2DUZCwmKrRdBvLRldwlXe5ZCWZAdQ7mHZBcRQRQy6L3CpXNOIMWrSKGfIxzu92zZAz1E3k0n28XfDLZCTs8B1oBj6nqmxta79J1ULiJyl7YpD9lccMNSFhOuVVZAcMZAZB0GFdQmSDbUA4tZAPZB5n3VkMWumwpfGSbDNKEiWxvSAZD', NULL, NULL, 1, NULL),
(35, '2311412742471909', 'Datdatttest8', '2019-03-13 21:13:58', 19, 1, 'EAAHKRllr1hkBALyOEReaPQUhHwVLybLfjvF4CaYeZBZCMGlf2zhGpM2tyZC6MS6TfZADNGT5RiMwFAqZAcK0ouaDhSG8pPV8qyVprvn6sTEZBLr0X42sFnOEiWOnKeOvBPRKDSr1TM4Vw7yZClrW8FKlSqBhY0TbMaIkq7stPlVwVOquOqy15VjVaCXK55AcaQZD', NULL, NULL, 1, NULL),
(36, '541140996398061', 'Olivia Hobbit', '2019-03-13 21:15:54', 20, 1, 'EAAHKRllr1hkBAGxw7dFZCvTXzeYpkDud1p0wHWw4XqjOerSMijmu7DpTjkpqdhhwgrbImVRR2XEcR3bZAbq4ds67uRG9reffFXLEK8muEEbVK1RBDHFfnpRBHhu7Tj2DPnVW3nQDToTT0zXJR238fqqUo5PKwXzHjlz0hVN3fW35XKWQgCrBlInJDFgScZD', 'Africa/Ceuta', NULL, 1, NULL),
(37, '777736072599375', 'Olivia  Star', '2019-03-13 21:15:54', 20, 1, 'EAAHKRllr1hkBAKv5vJmFrR3K0QI8UHFxGVv1RDmQ8oAsV79Pme2zeG8RfHXoEMAoBQ7uO5otjLwacE0h1N6iCUyHQSNGtyEOfEYphjlg6hlm1tWhkF7bs5VgWfVxaxysFivPk5KorkB0BmRKYmIlOl8uaZB6wwB80HQhtmr3I9DReGGAcQysrC4XdOZCsZD', NULL, NULL, 1, NULL),
(38, '971438483243979', 'Olivia Young', '2019-03-13 21:15:54', 20, 1, 'EAAHKRllr1hkBAB8ZAWcPLN44Y2kmfHlAZClOWSHraaVekTRluCI4XB8pPCwkRoy61EDX6vKI7FZCZC8ksSiWD6MZCPrcTwa60awpMZAJI8RyF5nnTK9PcdrA00eY86p8ZCHOSV4MeDuV4Qwe6T8JqIZAi1rZC7WyyetTfZBecOMlFe2lqjjO3YQzbZAZABSB4DIOFnoZD', NULL, NULL, 1, NULL),
(39, '2201075073542677', 'Olivia One', '2019-03-13 21:15:54', 20, 1, 'EAAHKRllr1hkBAKQuwbodyR6SFcPcduZCd0SUhclgE0DSUyA4Loqv55FA60xWP4mtIpNntvAqzhm8b0QEvxKmdZCW5BCe5WIlyQsZBnNqLZApDxZBNj2Ig575wPNy73rkX1oaQzJ2hwADFChTNRmedF1jRdNPZAZBXpHIioR47GBA2B3xR7yKh8vh5lxcZANQZCSYZD', NULL, NULL, 1, NULL),
(40, '2259650144248017', 'Olivia\'s Community', '2019-03-13 21:15:54', 20, 1, 'EAAHKRllr1hkBALdGYnkR9Tfmwlntc2qDwhsZCXR8jvOVK5pKJg9THX9phAZBZBObAi0VhcA0xLptFG5seE8iaUNFK4ktVmjzeyuYpu5O1LoTOKZBZCeNmRzB5JYqZCgwkf9uyp85YEOPxZAVGxg0MZAPsxrZARtypiDyZCQLKq3jZCpIkGENzZCR7sEFoZAeSVIlZCo4wZD', NULL, NULL, 1, NULL);

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
(33, 27, 76, 17, '2019-03-13 09:20:10'),
(34, 32, 86, 19, '2019-03-21 09:37:58'),
(35, 33, 86, 19, '2019-03-21 09:38:19'),
(36, 34, 87, 19, '2019-03-21 09:38:27'),
(37, 35, 87, 19, '2019-03-21 09:38:35'),
(38, 32, 87, 19, '2019-03-21 09:38:54'),
(39, 30, 88, 18, '2019-03-22 12:00:20'),
(40, 29, 88, 18, '2019-03-22 12:00:33'),
(41, 31, 88, 18, '2019-03-22 12:00:59');

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
(180, 849, 32),
(181, 849, 33),
(182, 850, 36),
(183, 850, 37),
(184, 851, 26),
(185, 852, 28),
(186, 853, 28),
(187, 854, 27),
(188, 855, 26),
(189, 856, 26),
(190, 857, 26),
(191, 858, 27),
(192, 859, 26),
(193, 860, 36),
(194, 860, 38),
(195, 861, 28);

-- --------------------------------------------------------

--
-- Table structure for table `page_dashboard_statistic`
--

DROP TABLE IF EXISTS `page_dashboard_statistic`;
CREATE TABLE `page_dashboard_statistic` (
  `page_id` int(11) NOT NULL,
  `pageLikes` int(11) DEFAULT NULL,
  `pageLikes72` int(11) NOT NULL,
  `current_posts24` int(11) DEFAULT NULL COMMENT 'postovi u zadnja 24h',
  `current_posts72` int(11) DEFAULT NULL COMMENT 'postovi u zadnja 72h'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `page_statistic`
--

DROP TABLE IF EXISTS `page_statistic`;
CREATE TABLE `page_statistic` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `pageLikes` int(11) DEFAULT NULL,
  `lastUpdateLikes` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_statistic`
--

INSERT INTO `page_statistic` (`id`, `page_id`, `pageLikes`, `lastUpdateLikes`) VALUES
(2, 2, 434, '0000-00-00 00:00:00');

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
  `scheduledSame` int(11) NOT NULL DEFAULT '0',
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

INSERT INTO `posts` (`id`, `title`, `content`, `created_by`, `created_date`, `scheduledSame`, `PostStatus`, `ActionStatus`, `IsActive`, `isScheduled`, `post_type`, `scheduledTime`) VALUES
(849, 'ddd', 'dffffff', 19, '2019-03-26 22:16:17', 0, 4, NULL, 1, 0, 'message', NULL),
(850, 'ddf', 'ffffff', 20, '2019-03-26 22:17:30', 0, 4, NULL, 1, 0, 'message', NULL),
(853, 'fdgfdg', 'dfgdfgdf', 20, '2019-03-26 23:34:47', 0, 4, NULL, 1, 0, 'message', NULL),
(854, 'xvxc', 'vcxvcxv', 20, '2019-03-26 23:35:05', 0, 1, NULL, 1, 0, 'message', NULL),
(855, 'fgd', 'dfgfdg', 20, '2019-03-26 23:54:39', 0, 1, NULL, 1, 0, 'message', NULL),
(856, 'single', 'single', 20, '2019-03-26 23:57:37', 0, 4, NULL, 1, 0, 'message', NULL),
(857, 'single 2', 'single 22', 20, '2019-03-26 23:57:52', 0, 4, NULL, 1, 0, 'message', NULL),
(858, 'fdgfdg', 'gffdgfd', 20, '2019-03-27 00:02:59', 0, 4, NULL, 1, 0, 'message', NULL),
(859, 'hggf', 'ghfghfgh', 20, '2019-03-27 00:08:37', 0, 4, NULL, 1, 1, 'message', '1970-01-01 01:00:00'),
(860, 'fgfdgfd', 'ggggggggggggg', 20, '2019-03-27 00:13:33', 0, 4, NULL, 1, 0, 'message', NULL),
(861, 'sada', 'asdasd', 20, '2019-03-27 00:23:18', 0, 4, NULL, 1, 1, 'message', '1970-01-01 01:00:00');

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
  `scheduledTime` datetime DEFAULT NULL,
  `is_deleted_from_fb` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts_archive`
--

INSERT INTO `posts_archive` (`id`, `title`, `content`, `created_by`, `created_date`, `PostStatus`, `ActionStatus`, `IsActive`, `isScheduled`, `post_type`, `scheduledTime`, `is_deleted_from_fb`) VALUES
(851, 'gfhgf', 'fghfghgf', 20, '2019-03-26 23:25:12', 1, NULL, 1, 0, 'message', NULL, b'1'),
(852, 'vcxcxv', 'cxvxcvxcv', 20, '2019-03-26 23:30:42', 1, NULL, 1, 0, 'message', NULL, b'1');

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
(180, 849, 32, 3, '2019-03-26 22:16:17', NULL, '2019-03-26 22:16:28', 3715, 1, NULL, '303069253739492_320471591999258', b'0', NULL),
(181, 849, 33, 3, '2019-03-26 22:16:17', NULL, '2019-03-26 22:16:29', 3715, 1, NULL, '387076882081892_397421611047419', b'0', NULL),
(182, 850, 36, 3, '2019-03-26 22:17:30', NULL, '2019-03-26 22:17:36', 3717, 1, NULL, '541140996398061_560225074489653', b'0', NULL),
(183, 850, 37, 3, '2019-03-26 22:17:30', NULL, '2019-03-26 22:17:37', 3717, 1, NULL, '777736072599375_804068066632842', b'0', NULL),
(186, 853, 28, 3, '2019-03-26 23:34:47', NULL, '2019-03-26 23:34:52', 3795, 1, NULL, '364324417746132_375814103263830', b'0', NULL),
(187, 854, 27, 1, '2019-03-26 23:35:05', NULL, NULL, NULL, 1, NULL, NULL, b'0', NULL),
(188, 855, 26, NULL, '2019-03-26 23:54:40', NULL, NULL, NULL, 1, NULL, NULL, b'0', NULL),
(189, 856, 26, 3, '2019-03-26 23:57:37', NULL, '2019-03-26 23:57:53', 3817, 1, NULL, '246671336217871_256550931896578', b'0', NULL),
(190, 857, 26, 3, '2019-03-26 23:57:52', NULL, '2019-03-26 23:58:52', 3818, 1, NULL, '246671336217871_256551308563207', b'0', NULL),
(191, 858, 27, 3, '2019-03-27 00:02:59', NULL, '2019-03-27 00:03:52', 3823, 1, NULL, '264447761139100_276146513302558', b'0', NULL),
(192, 859, 26, 3, '2019-03-27 00:08:37', NULL, '2019-03-27 00:08:52', 3828, 1, NULL, '246671336217871_256554671896204', b'0', NULL),
(193, 860, 36, 3, '2019-03-27 00:13:33', NULL, '2019-03-27 00:13:52', 3833, 1, NULL, '541140996398061_560262321152595', b'0', NULL),
(194, 860, 38, 3, '2019-03-27 00:13:33', NULL, '2019-03-27 00:13:54', 3833, 1, NULL, '971438483243979_995906837463810', b'0', NULL),
(195, 860, 40, 3, '2019-03-27 00:13:34', NULL, '2019-03-27 00:13:56', 3833, 1, NULL, '2259650144248017_2276975359182162', b'0', NULL),
(196, 860, 39, 3, '2019-03-27 00:13:34', NULL, '2019-03-27 00:13:58', 3833, 1, NULL, '2201075073542677_2230520933931424', b'0', NULL),
(197, 861, 28, 3, '2019-03-27 00:23:18', NULL, '2019-03-27 00:23:52', 3843, 1, NULL, '364324417746132_375829619928945', b'0', NULL);

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

--
-- Dumping data for table `posts_pages_archive`
--

INSERT INTO `posts_pages_archive` (`id`, `postId`, `pageId`, `postingStatus`, `dateCreated`, `dateUpdate`, `datePublishedFB`, `job_id`, `job_action`, `job_errors`, `fbPostId`) VALUES
(184, 851, 26, NULL, '2019-03-26 23:25:12', NULL, NULL, NULL, 1, NULL, NULL),
(185, 852, 28, NULL, '2019-03-26 23:30:42', NULL, NULL, NULL, 1, NULL, NULL);

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
-- Table structure for table `statistics72h`
--

DROP TABLE IF EXISTS `statistics72h`;
CREATE TABLE `statistics72h` (
  `fbPostId` varchar(50) NOT NULL,
  `reactions` int(11) NOT NULL DEFAULT '0',
  `comments` int(11) NOT NULL DEFAULT '0',
  `shares` int(11) NOT NULL DEFAULT '0',
  `stats_id` int(11) NOT NULL,
  `stats_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statistics72h`
--

INSERT INTO `statistics72h` (`fbPostId`, `reactions`, `comments`, `shares`, `stats_id`, `stats_dt`) VALUES
('971438483243979_986173631770464', 0, 0, 0, 38, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 39, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 40, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 41, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 42, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 43, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 44, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 45, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 46, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 47, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 48, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 49, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 50, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 51, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 52, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 53, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 54, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 55, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 56, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 57, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 58, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 59, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 60, '2019-03-23 13:42:20'),
('971438483243979_986173631770464', 0, 0, 0, 61, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 62, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 63, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 64, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 65, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 66, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 67, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 68, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 69, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 70, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 71, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 0, 0, 0, 72, '2019-03-23 13:42:21'),
('971438483243979_986173631770464', 3, 4, 3, 0, '2019-03-23 16:26:14'),
('971438483243979_986173631770464', 3, 4, 3, 1, '2019-03-23 16:25:05'),
('971438483243979_986173631770464', 3, 4, 0, 2, '2019-03-23 16:23:52'),
('971438483243979_986173631770464', 3, 4, 222, 3, '2019-03-23 16:20:42'),
('971438483243979_986173631770464', 3, 4, 0, 4, '2019-03-23 16:19:22'),
('971438483243979_986173631770464', 3, 4, 222, 5, '2019-03-23 16:17:59'),
('971438483243979_986173631770464', 3, 4, 222, 6, '2019-03-23 16:11:27'),
('971438483243979_986173631770464', 3, 4, 222, 7, '2019-03-23 16:10:00'),
('971438483243979_986173631770464', 3, 4, 222, 8, '2019-03-23 16:08:33'),
('971438483243979_986173631770464', 3, 4, 222, 9, '2019-03-23 16:07:58'),
('971438483243979_986173631770464', 3, 4, 222, 10, '2019-03-23 16:06:34'),
('971438483243979_986173631770464', 3, 4, 222, 11, '2019-03-23 16:03:47'),
('971438483243979_986173631770464', 3, 4, 222, 12, '2019-03-23 15:57:53'),
('971438483243979_986173631770464', 3, 4, 222, 13, '2019-03-23 15:56:05'),
('971438483243979_986173631770464', 3, 4, 3, 14, '2019-03-23 15:52:22'),
('971438483243979_986173631770464', 3, 4, 3, 15, '2019-03-23 15:50:59'),
('971438483243979_986173631770464', 3, 4, 3, 16, '2019-03-23 15:46:04'),
('971438483243979_986173631770464', 3, 4, 3, 17, '2019-03-23 15:45:14'),
('971438483243979_986173631770464', 3, 4, 3, 18, '2019-03-23 15:44:32'),
('971438483243979_986173631770464', 3, 4, 3, 19, '2019-03-23 15:43:36'),
('971438483243979_986173631770464', 3, 4, 3, 20, '2019-03-23 15:42:35'),
('971438483243979_986173631770464', 3, 4, 3, 21, '2019-03-23 15:41:15'),
('971438483243979_986173631770464', 3, 4, 3, 22, '2019-03-23 15:36:56'),
('971438483243979_986173631770464', 3, 4, 333, 23, '2019-03-23 15:34:24'),
('971438483243979_986173631770464', 3, 4, 333, 24, '2019-03-23 15:27:04'),
('971438483243979_986173631770464', 3, 4, 333, 25, '2019-03-23 15:22:03'),
('971438483243979_986173631770464', 3, 4, 333, 26, '2019-03-23 15:00:30'),
('971438483243979_986173631770464', 3, 4, 333, 27, '2019-03-23 14:02:26'),
('971438483243979_986173631770464', 3, 4, 33, 28, '2019-03-23 14:01:29'),
('971438483243979_986173631770464', 3, 4, 127, 29, '2019-03-23 13:59:14'),
('971438483243979_986173631770464', 3, 4, 127, 30, '2019-03-23 13:58:15'),
('971438483243979_986173631770464', 3, 4, 0, 31, '2019-03-23 13:56:51'),
('971438483243979_986173631770464', 3, 4, 3, 32, '2019-03-23 13:53:01'),
('971438483243979_986173631770464', 3, 4, 3, 33, '2019-03-23 13:51:06'),
('971438483243979_986173631770464', 3, 4, 3, 34, '2019-03-23 13:49:22'),
('971438483243979_986173631770464', 3, 4, 3, 35, '2019-03-23 13:47:08'),
('971438483243979_986173631770464', 3, 4, 3, 36, '2019-03-23 13:46:51'),
('971438483243979_986173631770464', 3, 4, 3, 37, '2019-03-23 13:45:37'),
('246671336217871_254535038764834', 0, 0, 0, 31, '2019-03-23 13:53:01'),
('246671336217871_254535038764834', 0, 0, 0, 32, '2019-03-23 13:53:01'),
('246671336217871_254535038764834', 0, 0, 0, 33, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 34, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 35, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 36, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 37, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 38, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 39, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 40, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 41, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 42, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 43, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 44, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 45, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 46, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 47, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 48, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 49, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 50, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 51, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 52, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 53, '2019-03-23 13:53:02'),
('246671336217871_254535038764834', 0, 0, 0, 54, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 55, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 56, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 57, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 58, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 59, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 60, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 61, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 62, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 63, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 64, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 65, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 66, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 67, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 68, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 69, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 70, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 71, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 0, 72, '2019-03-23 13:53:03'),
('246671336217871_254535038764834', 0, 0, 222, 0, '2019-03-23 16:26:18'),
('246671336217871_254535038764834', 0, 0, 222, 1, '2019-03-23 16:25:09'),
('246671336217871_254535038764834', 0, 0, 222, 2, '2019-03-23 16:23:55'),
('246671336217871_254535038764834', 0, 0, 222, 3, '2019-03-23 16:20:45'),
('246671336217871_254535038764834', 0, 0, 0, 4, '2019-03-23 16:19:26'),
('246671336217871_254535038764834', 0, 0, 222, 5, '2019-03-23 16:18:03'),
('246671336217871_254535038764834', 0, 0, 222, 6, '2019-03-23 16:11:30'),
('246671336217871_254535038764834', 0, 0, 222, 7, '2019-03-23 16:10:04'),
('246671336217871_254535038764834', 0, 0, 222, 8, '2019-03-23 16:08:37'),
('246671336217871_254535038764834', 0, 0, 222, 9, '2019-03-23 16:08:02'),
('246671336217871_254535038764834', 0, 0, 222, 10, '2019-03-23 16:06:38'),
('246671336217871_254535038764834', 0, 0, 222, 11, '2019-03-23 16:03:51'),
('246671336217871_254535038764834', 0, 0, 222, 12, '2019-03-23 15:57:57'),
('246671336217871_254535038764834', 0, 0, 222, 13, '2019-03-23 15:56:09'),
('246671336217871_254535038764834', 0, 0, 0, 14, '2019-03-23 15:52:27'),
('246671336217871_254535038764834', 0, 0, 0, 15, '2019-03-23 15:51:03'),
('246671336217871_254535038764834', 0, 0, 0, 16, '2019-03-23 15:46:08'),
('246671336217871_254535038764834', 0, 0, 0, 17, '2019-03-23 15:45:18'),
('246671336217871_254535038764834', 0, 0, 0, 18, '2019-03-23 15:44:36'),
('246671336217871_254535038764834', 0, 0, 0, 19, '2019-03-23 15:43:39'),
('246671336217871_254535038764834', 0, 0, 0, 20, '2019-03-23 15:42:38'),
('246671336217871_254535038764834', 0, 0, 0, 21, '2019-03-23 15:41:19'),
('246671336217871_254535038764834', 0, 0, 333, 22, '2019-03-23 15:34:25'),
('246671336217871_254535038764834', 0, 0, 333, 23, '2019-03-23 15:27:06'),
('246671336217871_254535038764834', 0, 0, 333, 24, '2019-03-23 15:22:06'),
('246671336217871_254535038764834', 0, 0, 333, 25, '2019-03-23 15:00:32'),
('246671336217871_254535038764834', 0, 0, 333, 26, '2019-03-23 14:02:28'),
('246671336217871_254535038764834', 0, 0, 33, 27, '2019-03-23 14:01:31'),
('246671336217871_254535038764834', 0, 0, 127, 28, '2019-03-23 13:58:16'),
('246671336217871_254535038764834', 0, 0, 0, 29, '2019-03-23 13:56:52'),
('246671336217871_254535038764834', 0, 0, 0, 30, '2019-03-23 13:53:07'),
('303792553630526', 0, 0, 0, 22, '2019-03-23 15:36:56'),
('303792553630526', 0, 0, 0, 23, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 24, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 25, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 26, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 27, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 28, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 29, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 30, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 31, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 32, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 33, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 34, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 35, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 36, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 37, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 38, '2019-03-23 15:36:57'),
('303792553630526', 0, 0, 0, 39, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 40, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 41, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 42, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 43, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 44, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 45, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 46, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 47, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 48, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 49, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 50, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 51, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 52, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 53, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 54, '2019-03-23 15:36:58'),
('303792553630526', 0, 0, 0, 55, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 56, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 57, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 58, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 59, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 60, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 61, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 62, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 63, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 64, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 65, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 66, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 67, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 68, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 69, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 70, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 71, '2019-03-23 15:36:59'),
('303792553630526', 0, 0, 0, 72, '2019-03-23 15:36:59'),
('303792553630526', 1, 2, 0, 0, '2019-03-23 16:26:16'),
('303792553630526', 1, 2, 0, 1, '2019-03-23 16:25:07'),
('303792553630526', 1, 2, 0, 2, '2019-03-23 16:23:54'),
('303792553630526', 1, 2, 0, 3, '2019-03-23 16:20:44'),
('303792553630526', 1, 2, 0, 4, '2019-03-23 16:19:24'),
('303792553630526', 1, 2, 0, 5, '2019-03-23 16:18:01'),
('303792553630526', 1, 2, 0, 6, '2019-03-23 16:11:29'),
('303792553630526', 1, 2, 0, 7, '2019-03-23 16:10:02'),
('303792553630526', 1, 2, 0, 8, '2019-03-23 16:08:35'),
('303792553630526', 1, 2, 0, 9, '2019-03-23 16:08:00'),
('303792553630526', 1, 2, 0, 10, '2019-03-23 16:06:36'),
('303792553630526', 1, 2, 0, 11, '2019-03-23 16:03:49'),
('303792553630526', 1, 2, 0, 12, '2019-03-23 15:57:55'),
('303792553630526', 1, 2, 0, 13, '2019-03-23 15:56:07'),
('303792553630526', 1, 2, 0, 14, '2019-03-23 15:52:25'),
('303792553630526', 1, 2, 0, 15, '2019-03-23 15:51:01'),
('303792553630526', 1, 2, 0, 16, '2019-03-23 15:46:06'),
('303792553630526', 1, 2, 0, 17, '2019-03-23 15:45:16'),
('303792553630526', 1, 2, 0, 18, '2019-03-23 15:44:34'),
('303792553630526', 1, 2, 0, 19, '2019-03-23 15:43:37'),
('303792553630526', 1, 2, 0, 20, '2019-03-23 15:42:36'),
('303792553630526', 1, 2, 0, 21, '2019-03-23 15:41:17');

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
(10, 'vuko', 'vukosav.cabarkapa@gmail.com', '2019-02-20 05:52:14', 'vukoc', '31b4c745d89c7c8b47b8857397133f3a5834b9e14249a2de1fa756e62b7ce066', 'f0c0635f16f3cdb42b1c9328a40e6fce', 1, 1, 1, '2019-03-20 11:04:33'),
(17, 'Marko Markovic', 'blnetmlnyp_1551804032@tfbnw.net', '2019-03-13 09:04:36', 'marko', 'cf885f38068e0b39f1a9db9c2ba2372c121473ce38e0c8c97c06c1646a025f9c', 'e8c8d2ccb6afb8d401c19b585546eee4', 2, 1, 1, '2019-03-24 11:27:35'),
(18, 'Janko Jankovic', 'swdaodaigk_1551779965@tfbnw.net', '2019-03-13 09:05:03', 'janko', '34680f28d7f6c44f73bb597967d7696d9ec65665f23781b86b32a4339db99225', 'd0b8bc3f5139c9de8bacfcce34d091d3', 2, 1, 1, '2019-03-26 02:02:37'),
(19, 'Petar Petrovic', 'fzcehmscjs_1549719264@tfbnw.net', '2019-03-13 09:05:27', 'petar', '934c61e8d2efee8df90fd2bed0db5550247f6a1555bb3bde83cc95c7910d2d18', 'e32686ba0d30d3d644fbe3bf2e25ffc3', 2, 1, 1, '2019-03-26 09:44:11'),
(20, 'jelena cabarkapa', 'cabarkapa.jelena@gmail.com', '2019-03-13 09:05:55', 'jelena', 'f9d730aed354757bfd9084494fb56c3fe074d95c2a6d8c8038f7e6abfea8ba4b', '09cdabe7d6ccd6bfb09a12cbd1fdd532', 1, 1, 1, '2019-03-26 10:17:11'),
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
-- Indexes for table `global_statistic`
--
ALTER TABLE `global_statistic`
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
-- Indexes for table `page_dashboard_statistic`
--
ALTER TABLE `page_dashboard_statistic`
  ADD UNIQUE KEY `Index 1` (`page_id`);

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3357;

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
-- AUTO_INCREMENT for table `global_statistic`
--
ALTER TABLE `global_statistic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `groups_in_post`
--
ALTER TABLE `groups_in_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs_thread`
--
ALTER TABLE `jobs_thread`
  MODIFY `job_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3851;

--
-- AUTO_INCREMENT for table `last_upload_fb_page`
--
ALTER TABLE `last_upload_fb_page`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `last_upload_fb_user`
--
ALTER TABLE `last_upload_fb_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `pages_groups`
--
ALTER TABLE `pages_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `page_by_hand_in_post`
--
ALTER TABLE `page_by_hand_in_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=862;

--
-- AUTO_INCREMENT for table `posts_pages`
--
ALTER TABLE `posts_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `post_attachments`
--
ALTER TABLE `post_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `task_to_finish`
--
ALTER TABLE `task_to_finish`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1046;

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
