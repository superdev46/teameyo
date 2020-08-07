<?php

	class Messages
	{
		// Register the id of the logged user
		public $logged_user_id;
	
		// If you want your contacts to be your friends or all users
		public $friends_approach = false;

		public $friends = '';	 
		// Messages Table
		public $messages_table = 'messages';
		
		// Users Table
		public $users_table = 'users';
		
		// Friends Table
		public $friends_table = 'friends';
		
		// Is it chat or contacts tab?
		public $active_tab = 'contacts';
		
		// Limit chars
		private $word_limit = 25;
		
		// Emoticons 
		public $emoticons = array(
  '[angry]' => '<img class="embed-emoticon" src="assets/img/emoticons/Angry.png" />',
 '[angry-devil]' => '<img class="embed-emoticon" src="assets/img/emoticons/Angry-Devil.png" />',
 '[anguished]' => '<img class="embed-emoticon" src="assets/img/emoticons/Anguished.png" />',
 '[astonished]' => '<img class="embed-emoticon" src="assets/img/emoticons/Astonished.png" />',
 '[blow-kiss]' => '<img class="embed-emoticon" src="assets/img/emoticons/Blow-Kiss.png" />',
 '[blushed]' => '<img class="embed-emoticon" src="assets/img/emoticons/Blushed.png" />',
 '[cold-sweat]' => '<img class="embed-emoticon" src="assets/img/emoticons/Cold-Sweat.png" />',
 '[confounded]' => '<img class="embed-emoticon" src="assets/img/emoticons/Confounded.png" />',
 '[confused]' => '<img class="embed-emoticon" src="assets/img/emoticons/Confused.png" />',
 '[crying]' => '<img class="embed-emoticon" src="assets/img/emoticons/Crying.png" />',
 '[disappointed]' => '<img class="embed-emoticon" src="assets/img/emoticons/Disappointed.png" />',
 '[disappointed-relieved]' => '<img class="embed-emoticon" src="assets/img/emoticons/Disappointed-Relieved.png" />',
 '[dizzy]' => '<img class="embed-emoticon" src="assets/img/emoticons/Dizzy.png" />',
 '[emoji]' => '<img class="embed-emoticon" src="assets/img/emoticons/Emoji.png" />',
 '[expressionless]' => '<img class="embed-emoticon" src="assets/img/emoticons/Expressionless.png" />',
 '[eyes]' => '<img class="embed-emoticon" src="assets/img/emoticons/Eyes.png" />',
 '[face-with-cold]' => '<img class="embed-emoticon" src="assets/img/emoticons/Face-with-Cold.png" />',
 '[fearful]' => '<img class="embed-emoticon" src="assets/img/emoticons/Fearful.png" />',
 '[fire]' => '<img class="embed-emoticon" src="assets/img/emoticons/Fire.png" />',
 '[flushed]' => '<img class="embed-emoticon" src="assets/img/emoticons/Flushed.png" />',
 '[frowning]' => '<img class="embed-emoticon" src="assets/img/emoticons/Frowning.png" />',
 '[ghost]' => '<img class="embed-emoticon" src="assets/img/emoticons/Ghost.png" />',
 '[grinmacing]' => '<img class="embed-emoticon" src="assets/img/emoticons/Grinmacing.png" />',
 '[grinning]' => '<img class="embed-emoticon" src="assets/img/emoticons/Grinning.png" />',
 '[halo]' => '<img class="embed-emoticon" src="assets/img/emoticons/Halo.png" />',
 '[head-bandage]' => '<img class="embed-emoticon" src="assets/img/emoticons/Head-Bandage.png" />',
 '[heart-eyes]' => '<img class="embed-emoticon" src="assets/img/emoticons/Heart-Eyes.png" />',
 '[hugging]' => '<img class="embed-emoticon" src="assets/img/emoticons/Hugging.png" />',
 '[hungry]' => '<img class="embed-emoticon" src="assets/img/emoticons/Hungry.png" />',
 '[hushed]' => '<img class="embed-emoticon" src="assets/img/emoticons/Hushed.png" />',
 '[kiss-emoji]' => '<img class="embed-emoticon" src="assets/img/emoticons/Kiss-Emoji.png" />',
 '[kissing]' => '<img class="embed-emoticon" src="assets/img/emoticons/Kissing.png" />',
 '[kissing-face]' => '<img class="embed-emoticon" src="assets/img/emoticons/Kissing-Face.png" />',
 '[loudly-crying]' => '<img class="embed-emoticon" src="assets/img/emoticons/Loudly-Crying.png" />',
 '[money-face]' => '<img class="embed-emoticon" src="assets/img/emoticons/Money-Face.png" />',
 '[nerd]' => '<img class="embed-emoticon" src="assets/img/emoticons/Nerd.png" />',
 '[neutral]' => '<img class="embed-emoticon" src="assets/img/emoticons/Neutral.png" />',
 '[relieved]' => '<img class="embed-emoticon" src="assets/img/emoticons/Relieved.png" />',
 '[rolling-eyes]' => '<img class="embed-emoticon" src="assets/img/emoticons/Rolling-Eyes.png" />',
 '[shyly]' => '<img class="embed-emoticon" src="assets/img/emoticons/Shyly.png" />',
 '[sick]' => '<img class="embed-emoticon" src="assets/img/emoticons/Sick.png" />',
 '[sign]' => '<img class="embed-emoticon" src="assets/img/emoticons/Sign.png" />',
 '[sleeping]' => '<img class="embed-emoticon" src="assets/img/emoticons/Sleeping.png" />',
 '[sleeping-snoring]' => '<img class="embed-emoticon" src="assets/img/emoticons/Sleeping-Snoring.png" />',
 '[slightly]' => '<img class="embed-emoticon" src="assets/img/emoticons/Slightly.png" />',
 '[smiling-devil]' => '<img class="embed-emoticon" src="assets/img/emoticons/Smiling-Devil.png" />',
 '[smiling-eyes]' => '<img class="embed-emoticon" src="assets/img/emoticons/Smiling-Eyes.png" />',
 '[smiling-face]' => '<img class="embed-emoticon" src="assets/img/emoticons/Smiling-Face.png" />',
 '[smiling-smiling]' => '<img class="embed-emoticon" src="assets/img/emoticons/Smiling-Smiling.png" />',
 '[smirk]' => '<img class="embed-emoticon" src="assets/img/emoticons/Smirk.png" />',
 '[sunglasses]' => '<img class="embed-emoticon" src="assets/img/emoticons/Sunglasses.png" />',
 '[surprised]' => '<img class="embed-emoticon" src="assets/img/emoticons/Surprised.png" />',
 '[sweat]' => '<img class="embed-emoticon" src="assets/img/emoticons/Sweat.png" />',
 '[tears]' => '<img class="embed-emoticon" src="assets/img/emoticons/Tears.png" />',
 '[thermometer]' => '<img class="embed-emoticon" src="assets/img/emoticons/Thermometer.png" />',
 '[thinking]' => '<img class="embed-emoticon" src="assets/img/emoticons/Thinking.png" />',
 '[thumbs-up]' => '<img class="embed-emoticon" src="assets/img/emoticons/Thumbs-Up.png" />',
 '[tightly]' => '<img class="embed-emoticon" src="assets/img/emoticons/Tightly.png" />',
 '[tired]' => '<img class="embed-emoticon" src="assets/img/emoticons/Tired.png" />',
 '[tongue]' => '<img class="embed-emoticon" src="assets/img/emoticons/Tongue.png" />',
 '[tongue-out-tightly]' => '<img class="embed-emoticon" src="assets/img/emoticons/Tongue-Out-Tightly.png" />',
 '[tongue-out]' => '<img class="embed-emoticon" src="assets/img/emoticons/Tongue-Out.png" />',
 '[tongue-winking]' => '<img class="embed-emoticon" src="assets/img/emoticons/Tongue-Winking.png" />',
 '[unamused]' => '<img class="embed-emoticon" src="assets/img/emoticons/Unamused.png" />',
 '[up-pointing]' => '<img class="embed-emoticon" src="assets/img/emoticons/Up-Pointing.png" />',
 '[upside]' => '<img class="embed-emoticon" src="assets/img/emoticons/Upside.png" />',
 '[very-angry]' => '<img class="embed-emoticon" src="assets/img/emoticons/Very-Angry.png" />',
 '[very-mad]' => '<img class="embed-emoticon" src="assets/img/emoticons/Very-Mad.png" />',
 '[very-sad]' => '<img class="embed-emoticon" src="assets/img/emoticons/Very-sad.png" />',
 '[victory]' => '<img class="embed-emoticon" src="assets/img/emoticons/Victory.png" />',
 '[weary]' => '<img class="embed-emoticon" src="assets/img/emoticons/Weary.png" />',
 '[wink]' => '<img class="embed-emoticon" src="assets/img/emoticons/Wink.png" />',
 '[worried]' => '<img class="embed-emoticon" src="assets/img/emoticons/Worried.png" />',
 '[zipper]' => '<img class="embed-emoticon" src="assets/img/emoticons/Zipper.png" />'
		);

		// Read Messages
		public function read_messages($msg)
		{
			global $maps, $attach, $embed;
			echo $maps->to_maps($attach->attachments($this->decode_message($embed->oembed($msg))));	
		}
		
		// Formats the message + Emoticons
		public function decode_message($message)
		{
			$dont_need = array('\n', '\r\n', '\r');
			$message = str_replace($dont_need, "<br />", $message);
			
			$message = str_replace(array_keys($this->emoticons), array_values($this->emoticons), $message);
			
			return stripslashes($message);		
		}
		
		// Count
		public function count_($array)
		{
			if(is_null($array) || is_string($array) || $array == false || empty($array) == true)
			{ 
				return 0;
			} else {
				return count($array);
			}
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// User Related
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		// format date
		public function format_date_default($time)
		{
			return date('j/n/Y, h:i a', $time);
		}
		
		// return user display_name
		public function return_display_name($user_id)
		{
			global $db1;
			
			if($db1->sanitize_integer($user_id) !== 0)
			{
				$query = $db1->query(sprintf("SELECT firstName FROM $this->users_table WHERE id = %d", 
							$db1->escape($user_id)
						 ));
						 
				if($db1->num_rows($query) == 1)
				{
					$row = $db1->fetch_row($query);
					return $row['firstName'];
				} else {
					return false;	
				}
			} else {
				return false;	
			}
		}	
		
		// return user profile picture
		public function user_profile_picture($user_id)
		{
			global $db1;
							
			$query = $db1->query(sprintf("SELECT filename FROM 'profile_pics' WHERE fkUserId = '%d'", 
								$db1->escape($user_id)
							));
															
			$row = $db1->fetch_row($query);
			
			$result = $row['filename'];
			
			if(empty($result) || $result == NULL) {
				return 'default.jpg';
			} else {
				return $result;
			}	
		}
		
		// return user status 
		public function user_profile_status($user_id, $option='')
		{
			global $db1;
							
			$query = $db1->query(sprintf("SELECT status FROM $this->users_table WHERE id = %d", 
								$db1->escape($user_id)
							));
															
			$row = $db1->fetch_row($query);
			
			if($db1->num_rows($query) > 0)
			{
				if($option == "TRUNCATE")
				{
					return $this->truncate($row['status'], $this->word_limit);		
				} else {
					return $row['status'];
				}	
			} else {
				return false;	
			}	
		}
		
		// get a list of friends
		private function get_friends_list($user_id, $limit='')
		{
			global $db1;

			if($db1->sanitize_integer($user_id) !== 0)
			{
				$query = $db1->query(sprintf("SELECT id, user_id, friend FROM $this->friends_table WHERE user_id = %d || friend = %d $limit", 
							$db1->escape($user_id), $db1->escape($user_id)
						 ));
						 
				if($db1->num_rows($query) > 0)
				{
					return $db1->results($query);
				} else {
					return false;	
				}
			} else {
				return false;	
			}
		}
		
		// get a list of friends that the user started a chat with
		private function get_chat_friends_list($user_id, $limit='')
		{
			global $db1;

			if($db1->sanitize_integer($user_id) !== 0)
			{

				$query = $db1->query(sprintf("SELECT id, user_id, receiver AS friend FROM $this->messages_table WHERE user_id = %d || receiver = %d GROUP BY friend $limit", 
							$db1->escape($user_id), $db1->escape($user_id)
						 ));
				if($db1->num_rows($query) > 0)
				{
					return $db1->results($query);
				} else {
					return false;	
				}
			} else {
				return false;	
			}
		}
		// get a list of users
		private function get_users($user_id, $limit='')
		{
			global $db1;
			if($db1->sanitize_integer($user_id) !== 0)
			{

				 $query = $db1->query("SELECT id,accountStatus, id AS user_id, Projects_ids AS project_id, id AS friend FROM $this->users_table WHERE id != $this->logged_user_id $limit");

				if($db1->num_rows($query) > 0)
				{
					return $db1->results($query);
				} else {
					return false;	
				}
			} else {
				return false;	
			}
		}
		// Pull a list of contacts, using friends and all users approach
		public function pull_contacts($user_id, $limit='', $counter='')
		{
			if($this->friends_approach == true)
			{
				if($this->active_tab == 'contacts' && $counter !== true)
				{
					return $this->get_chat_friends_list($user_id, $limit);
				} else {
					return $this->get_friends_list($user_id, $limit);
				}
			} else {
				if($this->active_tab == 'chats' && $counter !== true)
				{
					return $this->get_chat_friends_list($user_id, $limit);
				} else {
					return $this->get_users($user_id, $limit);
				}	
			}
		}
		// Count your contacts
		public function count_contacts($user_id, $limit='')
		{
			$count = $this->pull_contacts($user_id, $limit='', true);
						
			if(is_null($count) || is_string($count) || $count == false || empty($count) == true)
			{
				return 0;
			} else {
				return count($count);	
			}
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Messages
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		// Get total messages of the user (since 1.5)
		public function total_unread_messages($format='(%s) ')
		{
			global $db1;
			
			$receiver = $db1->escape($this->logged_user_id);
			
			$query = $db1->query("SELECT COUNT(id) as total_unread_messages FROM $this->messages_table WHERE status = 'unread' AND receiver = $receiver");
			
			if($db1->num_rows($query) == 0)
			{
				return false;
			} else {
				$row = $db1->fetch_row($query);
				$cn = $row['total_unread_messages'];
				if($cn == 0)
				{
					return false;
				} else {
					return sprintf($format, $cn);
				}
			}

		}
		public function get_unread_messages_count_by_user_B($project_id, $id)
		{
			global $db1;
			
			$sender = $db1->escape($this->logged_user_id); // receiver in this case
			$recv = $db1->escape($id); // receiver in this case
			
			$query = $db1->query("SELECT * FROM $this->messages_table WHERE receiver = $sender AND user_id=$recv AND status = 'unread' AND Project_id = $project_id");
		if($db1->num_rows($query) == 0)
			{
				return '';
			} else{
				$num_rows = mysqli_num_rows($query);
				// $countnumb = count($query);
				return $num_rows;
			}
		}
		// Get unread messages and count by user
		public function get_unread_messages_count_by_user($project_id)
		{	
			global $db1;
			
			$sender = $db1->escape($this->logged_user_id); // receiver in this case
						
			$query = $db1->query(sprintf(
			"SELECT id, message, time, user_id, receiver, storage_a, storage_b, Project_id, status, COUNT(user_id) as counted FROM $this->messages_table WHERE receiver = $sender AND status = 'unread' AND Project_id = %d || user_id = $sender AND status = 'unread' AND Project_id = %d GROUP BY user_id", 
								$db1->escape($project_id), $db1->escape($project_id)
					));
						
			if($db1->num_rows($query) == 0)
			{
				return '';
			} else {
				$rows = $db1->results($query);
				
				foreach($rows as $res)
				{
					// get only messages that are not deleted
					// just to order data based on logged_in user
					if($res['user_id'] == $sender || $res['receiver'] == $sender)
					{
						if(
							$res['user_id'] == $sender && $res['storage_a'] == 0 && $res['Project_id'] == 0 ||
							$res['receiver'] == $sender && $res['storage_b'] == 0 && $res['Project_id'] == 0 ||
							$res['storage_a'] == 0 && $res['storage_b'] == 0 && $res['Project_id'] == 0 
						)
						{
							// kill it
						} else {
							$results[] = array(
								'user_id' => $res['user_id'],
								'counted' => $res['counted'],
								'Project_id' => $res['Project_id']
								
							);	
						}
					} 
				}
				
				if(isset($results) && is_array($results) == true)
				{
					return $results;
				} else {
					return false;	
				}
			}	
		}
		
		// Get the unread messages
		public function get_unread_messages()
		{
			global $db1;
			
			$query = $db1->query(
/* 				sprintf("
					SELECT grouped.id, grouped.user_id, $this->messages_table.message, $this->messages_table.Project_id, $this->messages_table.time FROM (SELECT MAX(id) AS id, user_id FROM $this->messages_table WHERE receiver = %d AND status = 'unread'
					GROUP BY Project_id 
					ORDER BY MAX(id) DESC LIMIT 10) AS grouped, $this->messages_table WHERE grouped.id = $this->messages_table.id
				",  */
				sprintf("
					SELECT id, user_id, message, Project_id, time FROM $this->messages_table WHERE receiver = %d AND status = 'unread' ORDER BY time DESC
				", 
								$db1->escape($this->logged_user_id)
					));
				 						
			if($db1->num_rows($query) == 0)
			{
				return false;
			} else {
				return $db1->results($query);	
			}
		}
		
		private function messages_processor($query, $sender, $option)
		{
			global $db1;
			
			$row = $db1->fetch_row($query);
			
			// get only messages that are not deleted
			// just to order data based on logged_in user
			if($row['user_id'] == $sender || $row['receiver'] == $sender)
			{
				if(
					$row['user_id'] == $sender && $row['storage_a'] == 0 && $row['Project_id'] == 0 ||
					$row['receiver'] == $sender && $row['storage_b'] == 0 && $row['Project_id'] == 0 ||
					$row['storage_a'] == 0 && $row['storage_b'] == 0 && $row['Project_id'] == 0
				)
				{
					// kill it
				} else {
					$result = array(
						'id' => $row['id'],
						'message' => $row['message'],
						'time' => $row['time'],
						'user_id' => $row['user_id'],
						'receiver' => $row['receiver'],
						'storage_a' => $row['storage_a'],
						'storage_b' => $row['storage_b'],
						'Project_id' => $row['Project_id'],
						'status' => $row['status']
					);	
				}
			} 
			
			if(isset($result) && is_array($result) == true)
			{
				if($option == "TRUNCATE")
				{
					return $this->truncate($result['message'], $this->word_limit);		
				} else {
					return $row;
				}	
			} else {
				return false;	
			}	
		}
		
		// Get the last message between the two users
		public function get_the_last_message($user_id, $user_pro_id, $option="TRUNCATE")
		{
			global $db1;
			
			$sender = $this->logged_user_id;
			
			$query = $db1->query(sprintf("SELECT id, message, time, user_id, receiver, storage_a, storage_b, Project_id, status FROM $this->messages_table WHERE storage_a != 0 AND user_id = %d AND receiver = %d AND Project_id = %d || user_id = %d AND receiver = %d AND Project_id = %d AND storage_a != 0 AND storage_b != 0 AND Project_id != 0 ORDER BY id DESC LIMIT 1", 
						$db1->escape($this->logged_user_id), $db1->escape($user_id), $db1->escape($user_pro_id), $db1->escape($user_id), $db1->escape($this->logged_user_id), $db1->escape($user_pro_id)
					));
					
			if($db1->num_rows($query) == 0)
			{
				return false;
			} else {
				return $this->messages_processor($query, $sender, $option);
			}	
		}
		
		// Get last user message
		public function get_last_message_from($user_id, $option="TRUNCATE", $user_pro_id)
		{
			global $db1;
			
			$query = $db1->query(sprintf("SELECT id, message, time, user_id, receiver, storage_a, storage_b, Project_id, status FROM $this->messages_table WHERE user_id = %d AND Project_id = %d ORDER BY id DESC LIMIT 1", 
								$db1->escape($user_id), $db1->escape($user_pro_id)
					));
				 						
			if($db1->num_rows($query) == 0)
			{
				return false;
			} else {
				return $this->messages_processor($query, $sender, $option);
			}
		}
		
		// Get message of a user (replicates get_messages but to a single message) (since 1.1)
		public function get_last_message($user_id, $user_pro_id)
		{
			global $db1;
			
			$sender = $this->logged_user_id;
			
			$query = $db1->query(sprintf("SELECT id, message, time, user_id, receiver, storage_a, storage_b, Project_id, status FROM $this->messages_table WHERE 
			user_id = %d AND receiver = %d AND Project_id = %d
			|| user_id = %d AND receiver = %d AND Project_id = %d
			ORDER BY id DESC LIMIT 1",
						$db1->escape($sender), $db1->escape($user_id), $db1->escape($user_pro_id),
						$db1->escape($user_id), $db1->escape($sender), $db1->escape($user_pro_id)
					));
			
			if($db1->num_rows($query) == 0)
			{
				return false;
			} else {
				$rows = $db1->results($query);
				
				foreach($rows as $res)
				{
					// get only messages that are not deleted
					// just to order data based on logged_in user
					if($res['user_id'] == $sender || $res['receiver'] == $sender)
					{
						if(
							$res['user_id'] == $sender && $res['storage_a'] == 0 && $res['Project_id'] == 0||
							$res['receiver'] == $sender && $res['storage_b'] == 0 && $res['Project_id'] == 0||
							$res['storage_a'] == 0 && $res['storage_b'] == 0 && $res['Project_id'] == 0
						)
						{
							// kill it
						} else {
							$result = array(
								'id' => $res['id'],
								'message' => $res['message'],
								'time' => $res['time'],
								'user_id' => $res['user_id'],
								'receiver' => $res['receiver'],
								'storage_a' => $res['storage_a'],
								'storage_b' => $res['storage_b'],
								'Project_id' => $res['Project_id'],
								'status' => $res['status']
							);	
						}
					} 
				}
				
				if(isset($result) && is_array($result) == true)
				{
					return $result;
				} else {
					return false;	
				}
			}	
			
		}
		
		// Last message id (since 1.1)
		public function messages_last_id()
		{
			global $db1;
			
			$query = $db1->query("SELECT id FROM $this->messages_table ORDER BY id DESC LIMIT 1");
			
			if($db1->num_rows($query) == 0)
			{
				return false;
			} else {
				$row = $db1->fetch_row($query);
				return $row['id'];	
			}
				
		}
		
		// Get all messages of those users
		public function get_messages($user_id, $user_pro_id, $limit='')
		{
			global $db1;
			
			$sender = $this->logged_user_id;
			
			$query = $db1->query(sprintf("SELECT id, message, time, user_id, receiver, storage_a, storage_b, status, Project_id FROM $this->messages_table WHERE storage_a != 0 AND user_id = %d AND receiver = %d AND Project_id = %d || user_id = %d AND receiver = %d AND Project_id = %d $limit", 
$db1->escape($sender), $db1->escape($user_id), $db1->escape($user_pro_id), $db1->escape($user_id), $db1->escape($sender), $db1->escape($user_pro_id)
					));
					
			if($db1->num_rows($query) == 0)
			{
				return false;
			} else {
				$rows = $db1->results($query);
				
				foreach($rows as $res)
				{
					// get only messages that are not deleted
					// just to order data based on logged_in user
					if($res['user_id'] == $sender || $res['receiver'] == $sender)
					{
						if(
							$res['user_id'] == $sender && $res['storage_a'] == 0 && $res['Project_id'] == 0 ||
							$res['receiver'] == $sender && $res['storage_b'] == 0 && $res['Project_id'] == 0 ||
							$res['storage_a'] == 0 && $res['storage_b'] == 0 && $res['Project_id'] == 0
						)
						{
							// kill it
						} else {
							$results[] = array(
								'id' => $res['id'],
								'message' => $res['message'],
								'time' => $res['time'],
								'user_id' => $res['user_id'],
								'receiver' => $res['receiver'],
								'storage_a' => $res['storage_a'],
								'storage_b' => $res['storage_b'],
								'Project_id' => $res['Project_id'],
								'status' => $res['status']
							);	
						}
					} 
				}
				
				if(isset($results) && is_array($results) == true)
				{
					return $results;
				} else {
					return false;	
				}
			}	
		}
		
		// limit text by a certain amount of chars
		public function truncate($string, $length, $dots = "...") 
		{
			return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . ' '.$dots : $string;
		}
		
		// Search Friend (Friends Approach: true)
		private function Search_Friend($filterword) 
		{
			global $db1;
			
			$filterword = $db1->escape($filterword);
			$logged_in = $db1->escape($this->logged_user_id);
			
			$sql = "
				SELECT friend, firstName FROM (SELECT $this->users_table.id as UID, $this->users_table.firstName, $this->friends_table.id AS FID, TRIM(BOTH $logged_in FROM CONCAT(user_id, friend)) AS friend FROM $this->friends_table, $this->users_table
				WHERE user_id = $logged_in 
				|| 
				friend = $logged_in 
				HAVING friend = $this->users_table.id) AS merged WHERE firstName LIKE '%$filterword%'";

			$query = $db1->query($sql);
								
			if($db1->num_rows($query) == 0)
			{
				return false;
			} else {
				return $db1->results($query);	
			}
		}
		
		// Search Users (Friends Approach: false)
		private function Search_Users($filterword) 
		{
			global $db1;
			
			$filterword = $db1->escape($filterword);
			$logged_in = $db1->escape($this->logged_user_id);
			
			$sql = "SELECT id AS friend, firstName FROM $this->users_table WHERE firstName LIKE '%$filterword%' AND id != $this->logged_user_id";

			$query = $db1->query($sql);
								
			if($db1->num_rows($query) == 0)
			{
				return false;
			} else {
				return $db1->results($query);	
			}
		}
		
		// Search your contacts
		public function Search_Contact($filterword)
		{
			if($this->friends_approach == true)
			{
				return $this->Search_Friend($filterword);
			} else {
				return $this->Search_Users($filterword);
			}
		}
		
		// Last Seen 
		public function last_seen($user_id)
		{
			global $db1;
			
			$query = $db1->query(
				sprintf("SELECT last_seen FROM $this->users_table WHERE id = %d", $db1->escape($user_id))
			);
			
			if($db1->num_rows($query) !== 0)
			{
				$row = $db1->fetch_row($query);
				return $row['last_seen'];
			} else {
				return false;
			}
				
		}
		
		// Calculate Last Seen
		public function calculate_last_seen($timestamp, $user_id)
		{
			$user_status = $this->get_user_session_status($user_id);
			
			if($user_status == 'offline')
			{
				$then = $timestamp;
				$now = time();	
	
				$result = $now - $then;
				
				$date = date('h:i a', $then);
				if($result <= 86400)
				{
					return 'last seen today at ' . $date;	
				} elseif($result <= 172800) {
					return 'last seen yesterday at ' . $date;
				} else {
					return 'last seen ' . date("d/m/Y h:i a", $then);	
				}
			} elseif($user_status == 'online') {
				return 'online';	
			} else {
				return '';	
			}
			
		}
		
		// Get User Session Status
		public function get_user_session_status($user_id)
		{
			global $db1;
			
			$query = $db1->query(
				sprintf("SELECT session_status FROM $this->users_table WHERE id = %d", $db1->escape($user_id))
			);
			
			if($db1->num_rows($query) !== 0)
			{
				$row = $db1->fetch_row($query);
				return $row['session_status'];
			} else {
				return false;
			}
		}
				
		// Add Message (chat)
		public function add_message($user_id, $pro_ID, $message)
		{
			global $db1;
			$query = $db1->query(sprintf("INSERT INTO $this->messages_table SET message = '%s', user_id = %d, receiver = %d, storage_a = %d, storage_b = %d, time = %d, Project_id = $pro_ID, status = 'unread'", 
						$db1->escape(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')), $db1->escape($this->logged_user_id), $db1->escape($user_id), $db1->escape($this->logged_user_id), $db1->escape($user_id), time()
					));
					
			if($db1->affected_rows($query) == 1)
			{
				return true;
			} else {
				return false;
			}	
		}
		
		// private update status
		private function update_session_status($status)
		{
			global $db1;
			
			$query = $db1->query(
				sprintf("UPDATE $this->users_table
							SET 
							  session_status = '%s',
							  last_seen = %d
							WHERE
							  id = %d
						", 
						$status,
						time(),
						$db1->escape($this->logged_user_id)
					)
				);

			if($db1->affected_rows($query) == 1)
			{
				return true;	
			} else {
				return false;	
			}
		}
		
		// Update user status
		public function set_user_sessionStatus($status)
		{						
			switch($status)
			{
				case "online":
					return $this->update_session_status('online');
				break;
				
				case "offline":
					return $this->update_session_status('offline');
				break;
			}
		}
		
		// Update Messaget Status (chat) 'works with unread messages counter'
		public function update_message_status($message_id, $user_id, $pro_ID)
		{
			global $db1;
			
			$message_id = $db1->escape($message_id);
			
			$query = $db1->query("UPDATE $this->messages_table SET status = 'read' WHERE id = $message_id AND user_id = $user_id AND Project_id = $pro_ID");
			
			if($db1->affected_rows($query) == 1)
			{
				return true;
			} else {
				return false;
			}
		}
		
		// testing (since 1.1)
		public function chat_type($status, $id='')
		{
			global $db1;
			
			// for get typing status
			if(strlen($id) !== 0)
			{
				$user = $db1->escape($id); // clist
				$log_user = $db1->escape($this->logged_user_id); // log user
								
				$status = 'typing_'.$log_user;
				$tq = $db1->query("SELECT id, type_status FROM $this->users_table WHERE id = $user AND type_status = '$status'");
				
				if($db1->num_rows($tq) == 1)
				{
					return $user;
				} else {
					return 'stopped';
				}
			
			// for setting typing status	
			} else {
				
				$user = $db1->escape($this->logged_user_id);
				
				$query = $db1->query("SELECT id, type_status FROM $this->users_table WHERE id = $user");
			
				if($db1->num_rows($query) == 1)
				{
					if($status !== 'stopped')
					{
						$status = $db1->escape($status);
						$tq = $db1->query("UPDATE $this->users_table SET type_status = '$status' WHERE id = $user");
					} elseif($status == 'stopped') {
						$tq = $db1->query("UPDATE $this->users_table SET type_status = 'stopped' WHERE id = $user");	
					}	
				}
				
				if($db1->affected_rows($tq) == 1)
				{
					return $user;
				} else {
					return 'stopped';
				}	
			}
			
		}
		
		// Delete Message (chat)
		public function delete_message($message_id, $user_id, $pro_ID)
		{
			global $db1;
			
			// Find Owner
			$query = $db1->query(
					sprintf("SELECT user_id, receiver, storage_a, storage_b FROM $this->messages_table
								WHERE
								  id = %d AND Project_id = %d
							", 
							 $db1->escape($message_id), $db1->escape($pro_ID)
					)
				);	
				
				$row = $db1->fetch_row($query);
				
				// Delete Magic
				if($row['user_id'] == $this->logged_user_id || $row['receiver'] == $this->logged_user_id)
				{
					if($row['user_id'] == $this->logged_user_id)
					{
						$internal_storage_a = 0;
						$internal_storage_b = $row['storage_b'];
					}
					
					if($row['receiver'] == $this->logged_user_id)
					{
						$internal_storage_a = $row['storage_a'];
						$internal_storage_b = 0;
					} 
				} 
						
				// Register Storages (a => logged_user_id/user_id, b => user_id/logged_user_id)
				$updated = $db1->query(
					sprintf("UPDATE $this->messages_table
								SET 
								  storage_a = %d,
								  storage_b = %d
								WHERE
								  id = %d
							", 
							 $db1->escape($internal_storage_a),
							 $db1->escape($internal_storage_b),
							 $db1->escape($message_id)
					));	
				
				if($db1->affected_rows() == 1)
				{
					// check if both users does not have the messages to remove them
					// If you want to never delete messages remove this code and left just return true;
					
					// Look again
					$query_d = $db1->query(
						sprintf("SELECT storage_a, storage_b FROM $this->messages_table
									WHERE
									  id = %d
								", 
								 $db1->escape($message_id)
						)
					);
						
					$r = $db1->fetch_row($query_d);
					
					// permanent delete it
					if($r['storage_a'] == 0 && $r['storage_b'] == 0)
					{
						$db1->query(
							sprintf("DELETE FROM $this->messages_table WHERE id = %d", 
									$db1->escape($message_id)
							)
						);			
					}
					
					return true;
					
				} else {
					return false;	
				}
		}
	}
	
?>