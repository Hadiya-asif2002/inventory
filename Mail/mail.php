<?php

namespace Mail;
require dirname(__FILE__, 2) . '/vendor/autoload.php';

use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;


class Mail
{
  public static function sendMail($name, $url)
  {
    $env = parse_ini_file('.env');
    $apiKey = $env['MAILTRAP_API_KEY2'];
    $fromAddress = $env['FROM_ADDRESS'];
    $mailtrap = MailtrapClient::initSendingEmails(
      apiKey: $apiKey,
      inboxId: 3797790,
      isSandbox: true,
    );

    $email = (new MailtrapEmail())
      ->from(new Address('hello@demomailtrap.co', 'Mailtrap Test'))
      ->to(new Address("hadiya.asif@devbunch.com"))
      ->templateUuid('496d735e-3419-4aea-bba1-570822d0b8c7')
      ->templateVariables([
        'company_info_name' => 'Devbunch',
        'name' => $name,
        'url' => $url,
      ])
    ;

    $response = $mailtrap->send($email);

    var_dump(ResponseHelper::toArray($response));
  }

}

