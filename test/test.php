<?
require_once("class.phpmailer.php");
				$mailer = new PHPMailer();
				$mailer->IsSMTP();
				$mailer->Host = 'mail.agilitypilipinas.com';
				$mailer->SMTPAuth = true; 

				$mailer->Username = 'no-reply@agilitypilipinas.com';
				$mailer->Password = '';
				$mailer->FromName = 'Runningmate';
				$mailer->From = 'no-reply@agilitypilipinas.com';
				$mailer->AddAddress('charlieperena@yahoo.com', 'Charlie Perena');
				$mailer->Subject = 'Sample sample sample';
				$mailer->Body = 'CongratulationsYouhavesuccessfullyregisteredtooursiteTomakethisaccountactivatedblahblahlahbla';
				echo 'no-reply@agilitypilipinas.com';
				  if(!$mailer->Send())
				{
					echo ":)";
					echo "Mailer Error: " . $mailer->ErrorInfo;
					//exit;
				}
				?>