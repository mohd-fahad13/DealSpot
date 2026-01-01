<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailHelper
{
    /**
     * Send a plain text email.
     *
     * @param string $to Email address of the recipient
     * @param string $subject Subject of the email
     * @param string $body Body content of the email
     * @return bool Returns true if sent successfully, false otherwise
     */
    public static function sendPlain($to, $subject, $body)
    {
        try {
            Mail::raw($body, function ($message) use ($to, $subject) {
                $message->to($to)
                        ->subject($subject);
            });

            Log::info('📧 EMAIL SENT SUCCESSFULLY', ['to' => $to, 'subject' => $subject]);
            return true;
        } catch (\Exception $e) {
            Log::error('❌ EMAIL FAILED TO SEND', ['to' => $to, 'error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send an OTP email (Wrapper for common OTP functionality).
     */
    public static function sendOtp($to, $otp)
    {
        $subject = 'Your Verification Code - ' . config('app.name');
        $body = "Your verification code is: {$otp}\n\nThis code expires in 10 minutes.\n\nIf you did not request this, please ignore this email.";
        
        return self::sendPlain($to, $subject, $body);
    }
}