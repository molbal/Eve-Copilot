<?php


	namespace App\Connector\EveAPI\Mail;


	use App\Connector\EveAPI\EveAPICore;

	class MailService extends EveAPICore
	{

		/**
		 * Sends an EVE-mail
		 * @param int    $charId
		 * @param int    $target
		 * @param string $title
		 * @param string $body
		 */
		public function sendMaiItoCharacter(int $charId, int $target, string $title, string $body)
		{
			$params = [
				"character_id" => $charId,
				"mail" => [
					"approved_cost" => 0,
					"body" => $body,
					"recipients" => [
						[
							"recipient_id" => $target,
							"recipient_type" => "character"
						]
					],
					"subject" => $title]];
		}
	}