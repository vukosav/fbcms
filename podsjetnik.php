Iz view brisati news
Iz models brisati news_model


Za sve redove ukoliko je null rezultat upita da ne vrati gresku na stranici

checkbox da se implementira kod search

chackbox all post ne treba. To je kad nista nije cekirano.
chackbox scheduled post da vidimo koja je ta situacija 
chackbox post with error da vidimo kako te postove vratiti
chackbox paused i in progres treba jedan drugog da iskuljucuju





////------------UPDATE BAZE -----------------/////
ALTER TABLE `users` ADD `IsActive` INT(1) NULL DEFAULT '1' AFTER `createdBy`;
ALTER TABLE `users` ADD COLUMN `salt` VARCHAR(250) NOT NULL AFTER `password`;
ALTER TABLE `users` ADD COLUMN `last_login` datetime DEFAULT NULL;

---------------- AAAAA
CREATE TABLE `users_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `hash` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_session_ibfk_1` (`user_id`),
  CONSTRAINT `users_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
----------------AAAAAA

////----------END UPDATE BAZE ---------------/////

PROBLEMI
Ako se dva puta klikne na dugme dok vrti insertova dva reda.


///-------------------PREDLOG ZA MULTIPLE SUBMIT -------/////////////////
PRVI NACIN
if($_SESSION && isset($_SESSION['already_submitted'])) {

  # If already submitted just redirect to thank you page

} else {

    # If first submit then assign session value and process the form
    $_SESSION['already_submitted'] = true;

    # Process form

}


DRUGI NACIN
<?php
session_start();

/**
 * Creates a token usable in a form
 * @return string
 */
function getToken(){
  $token = sha1(mt_rand());
  if(!isset($_SESSION['tokens'])){
    $_SESSION['tokens'] = array($token => 1);
  }
  else{
    $_SESSION['tokens'][$token] = 1;
  }
  return $token;
}

/**
 * Check if a token is valid. Removes it from the valid tokens list
 * @param string $token The token
 * @return bool
 */
function isTokenValid($token){
  if(!empty($_SESSION['tokens'][$token])){
    unset($_SESSION['tokens'][$token]);
    return true;
  }
  return false;
}

// Check if a form has been sent
$postedToken = filter_input(INPUT_POST, 'token');
if(!empty($postedToken)){
  if(isTokenValid($postedToken)){
    // Process form
  }
  else{
    // Do something about the error
  }
}

// Get a token for the form we're displaying
$token = getToken();
?>
<form method="post">
  <fieldset>
    <input type="hidden" name="token" value="<?php echo $token;?>"/>
    <!-- Add form content -->
  </fieldset>
</form>
///-------------------END PREDLOG ZA MULTIPLE SUBMIT -------/////////////////



///-----------------za postove--------////////
**upit
SELECT `posts`.id, `posts`.title, posts.content 
, PagesForPost(posts.id) AS pages, `users`.`username` as `addedby`
 FROM `posts` 
 JOIN `users` ON posts.created_by = users.id
  LEFT JOIN `posts_pages` ON `posts`.`id` = `posts_pages`.`postId`
  WHERE (`PostStatus` = 2 or `PostStatus` = 3) AND `posts`.`IsActive` = 1
  GROUP BY `posts`.id, `posts`.title, posts.content , `users`.`username` 


**funkcija
CREATE OR replace FUNCTION PagesForPost (postId INT)
RETURNS text DETERMINISTIC
RETURN (SELECT  REPLACE(GROUP_CONCAT(ifNull(pages.fbPageName,'<br>'),'<br>'),',','') AS pages
FROM posts
left JOIN posts_pages ON posts.id = posts_pages.postId
left JOIN pages ON pages.id = posts_pages.pageId
WHERE posts.id = postId
GROUP BY posts.id
 );
 



 **
 SELECT PagesForPost(5) AS postspages;