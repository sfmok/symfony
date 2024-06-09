<?php

use Symfony\Component\RemoteEvent\Event\Mailer\MailerDeliveryEvent;

$wh = new MailerDeliveryEvent(MailerDeliveryEvent::BOUNCE, '62fb66bef54a112e920b5493', json_decode(file_get_contents(str_replace('.php', '.json', __FILE__)), true));
$wh->setRecipientEmail('test@example.com');
$wh->setTags(["test-tag"]);
$wh->setMetadata([]);
$wh->setReason('Host or domain name not found');
$wh->setDate(\DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.uP', '2024-01-01T12:00:00.000000Z'));

return $wh;
