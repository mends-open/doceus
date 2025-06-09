<?php

namespace App\Feature\Identity\Enums;
enum ContactPointSystem: string
{
    case Phone = 'phone';
    case Fax = 'fax';
    case Email = 'email';
    case Pager = 'pager';
    case URL = 'url';
    case SMS = 'sms';
    case Other = 'other';
    // extension
    case WhatsApp = 'whatsapp';
    case Signal = 'signal';
    case Telegram = 'telegram';
}
